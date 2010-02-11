function GUI_Control_Box_Collapsible(collapseStatusScriptletURL, controlID) {
	var height = $("#" + controlID + " .content").height();
	var animationDuration = height * 8;
	
	$("#" + controlID + " .head").click(
		function() {
			$.get(collapseStatusScriptletURL, { panel: controlID });
			
			var contentInner = $(this).parent().find(".content_inner");
			var content = $(this).parent().find(".content");

			if (content.height() > 0) {
				content.css({overflow: "hidden"});
				contentInner.animate( {top: "-" + (height + 4) + "px"}, { queue:false, duration: animationDuration});
				content.animate( {height: "0px"}, { queue:false, duration: animationDuration, 
					complete: function() {
						$("#" + controlID).addClass("collapsed");
					}
				});
			}
			else {
				contentInner.animate( {top: "0px"}, { queue:false, duration: animationDuration });
				content.animate( {height: height + "px"}, { queue:false, duration: animationDuration, 
					complete: function() {
						$(this).css({overflow: "auto"});
						$("#" + controlID).removeClass("collapsed");
					}
				});
			}
		}
	);
	
	if ($("#" + controlID).hasClass("collapsed")) {
		$("#" + controlID + " .content").css({height: "0px", overflow: "hidden"});
		$("#" + controlID + " .content_inner").css({top: "-" + (height + 4) + "px"});
	}
}