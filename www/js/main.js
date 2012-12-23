/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

function GUI_Control_Box_Collapsible(controlID, enableSaveCollapsedState, enableAjax) {
	var ajaxHasBeenLoaded = false;
	var self = this;
	this.animationSpeed = 8;

	$("#" + controlID + " .head").click(
		function() {
			var element = $("#" + controlID);
			
			if (!element.hasClass("animating")) {
				element.addClass("animating");
				var collapsed = element.hasClass('collapsed');
				if (!collapsed || $.trim(element.find(".content_inner").html()))
					ajaxHasBeenLoaded = true;
				if (enableAjax && !ajaxHasBeenLoaded)
					element.addClass("ajax_loading");
				
				if (enableSaveCollapsedState) {
					$.core.ajaxRequest(controlID, "ajaxCollapse", undefined, function() {
						self.ajaxConditionalLoadContent(element);
					});
				}
				else
					self.ajaxConditionalLoadContent(element);
					
				if (!enableAjax || ajaxHasBeenLoaded)
					self.animate(element);
			}
		}
	);
	
	this.ajaxConditionalLoadContent = function(element) {
		if (enableAjax && !ajaxHasBeenLoaded) {
			$.core.loadPanels(new Array(controlID), function(panelData) {
				element.find(".content").replaceWith($(panelData).find("#" + controlID + " .content"));
				ajaxHasBeenLoaded = true;
				element.removeClass("ajax_loading");
				self.animate(element);
			});
		}
	}
	
	this.setAnimationSpeed = function(animationSpeed) {
		this.animationSpeed = animationSpeed;
	}
	
	this.animate = function(element) {
		var contentInner = element.find(".content_inner");
		var content = element.find(".content");
		
		if (!element.hasClass('collapsed')) {
			content.css({overflow: "hidden"});
			height = content.height();
			animationDuration = height * this.animationSpeed;
			contentInner.animate( {top: "-" + (height + 4) + "px"}, { queue:false, duration: animationDuration});
			content.animate( {height: "0px"}, { queue:false, duration: animationDuration, 
				complete: function() {
					element.addClass("collapsed");
					$(this).css({height: ""});
					element.removeClass("animating");
				}
			});
		}
		else {
			contentInner.css({top: "-1000000px"});
			element.removeClass("collapsed");
			height = content.height();
			animationDuration = height * this.animationSpeed;
			content.css({height: "0px", overflow: "hidden"});
			contentInner.css({top: "-" + (height + 4) + "px"});
			
			contentInner.animate( {top: "0px"}, { queue:false, duration: animationDuration });
			content.animate( {height: height + "px"}, { queue:false, duration: animationDuration, 
				complete: function() {
					$(this).css({overflow: "auto", height: ""});
					element.removeClass("animating");
				}
			});
		}
	}
}

$(document).ready(function(){
	if (!jQuery.browser.msie && jQuery.browser.version.substr(0,1) <= "7") {
		$(".skin_tech #ctn_head #ctn_navigation li a").prepend("<span></span>");
		$(".skin_tech .rakuun_box .head h2").prepend("<span class=\"gradient\"></span>");
		$(".skin_tech .core_gui_submitbutton").wrap("<span class=\"core_gui_submitbutton_wrapper\"></span>").after("<div></div>");
	}
	// open submenus on hover over top menu entries
	$(".skin_tech #ctn_head #ctn_navigation li").mouseover(function() {
		$(".skin_tech #ctn_head #ctn_navigation li").removeClass("core_navigation_node_inpath");
		$(this).addClass("core_navigation_node_inpath");
	});
	// center submenus below top menu entries
	$(".skin_tech #ctn_head #ctn_navigation li ul").each(function() {
		jqThis = $(this);
		ownMaxWidth = jqThis.width();
		jqThis.css("width", "auto");
		ownWidth = jqThis.width();
		jqParent = jqThis.parent();
		jqThis.children().first().css("margin-left", Math.min(jqParent.position().left + jqParent.width() / 2 - ownWidth / 2, ownMaxWidth - ownWidth));
		jqThis.css("width", ownMaxWidth);
	});
});
