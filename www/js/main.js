function GUI_Control_Box_Collapsible(controlID) {
	$("#" + controlID + " .head").click(
		function() {
			var element = $("#" + controlID);
			
			if (!element.hasClass("animating")) {
				element.addClass("animating");
				$.core.ajaxRequest(controlID, "ajaxCollapse");
				var contentInner = element.find(".content_inner");
				var content = element.find(".content");
				
				if (!element.hasClass('collapsed')) {
					content.css({overflow: "hidden"});
					height = content.height();
					animationDuration = height * 8;
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
					animationDuration = height * 8;
					content.css({height: "0px", overflow: "hidden"});
					contentInner.css({top: "-" + (height + 4) + "px"});
					
					contentInner.animate( {top: "0px"}, { queue:false, duration: animationDuration });
					content.animate( {height: height + "px"}, { queue:false, duration: animationDuration, 
						complete: function() {
							$(this).css({overflow: "auto"});
							element.removeClass("animating");
						}
					});
				}
			}
		}
	);
}

$(document).ready(function(){
	if (!jQuery.browser.msie && jQuery.browser.version.substr(0,1) <= "7") {
		$(".skin_tech #ctn_head #ctn_navigation li a").prepend("<span></span>");
		$(".skin_tech .rakuun_box .head h2").prepend("<span></span>");
		$(".skin_tech .core_gui_submitbutton").wrap("<span class=\"core_gui_submitbutton_wrapper\"></span>").after("<div></div>");
	}
	$(".skin_tech #ctn_head #ctn_navigation li").mouseover(function() {
		$(".skin_tech #ctn_head #ctn_navigation li").removeClass("core_navigation_node_inpath");
		$(this).addClass("core_navigation_node_inpath");
	});
});
