function GUI_Control_Box_Collapsible(collapseStatusScriptletURL, controlID) {
	$("#" + controlID + " .head").click(
		function() {
			var element = $("#" + controlID);
			
			if (!element.hasClass("animating")) {
				element.addClass("animating");
				$.get(collapseStatusScriptletURL, { panel: controlID });
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