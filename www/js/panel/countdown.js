function GUI_Control_CountDown(controlID, currentTime, targetTime, enableHoverInfo, finishedMessage, callback) {
	var self = this;
	var restTime = targetTime - currentTime;
	var interval = setInterval(function(){self.tick();}, 1000);
	
	if (enableHoverInfo == 1) {
		$("#" + controlID).mouseover(function() {
			var date = new Date();
			date.setTime(targetTime * 1000);
			var dateString = 
				self.addLeadingZero(date.getDate()) + "." + self.addLeadingZero(date.getMonth() + 1) + "."
				+ date.getFullYear() + ", " + self.addLeadingZero(date.getHours()) + ":"
				+ self.addLeadingZero(date.getMinutes()) + ":" + self.addLeadingZero(date.getSeconds());
			$("body").append('<div id="' + controlID + '_hover" class="core_gui_hoverinfo rakuun_countdown_hoverinfo" style="position:absolute;">' + dateString + '</div>');
		}).mouseout(function() {
			$("#" + controlID + "_hover").remove();
		}).mousemove(function(e) {
			$("#" + controlID + "_hover").css("left", e.pageX + 10).css("top", e.pageY + 10);
		});
	}
	
	this.tick = function() {
		restTime -= 1;
		if (restTime < 0) {
			restTime = 0;
		}
		var seconds = restTime % 60;
		var minutes = Math.floor((restTime / 60) % 60);
		var hours = Math.floor((restTime / 60 / 60) % 24);
		var days = Math.floor((restTime / 60 / 60 / 24));
		
		var timeString = '';
		if (days > 0){
			var multiple = '';
			if (days > 1)
				multiple='e';
			timeString += days + ' Tag' + multiple + ', ';
		}
		
		if (hours >= 1)
			var unit = ' Stunden';
		else
			unit = ' Minuten';
		timeString += self.addLeadingZero(hours) + ':' + self.addLeadingZero(minutes) + ':' + self.addLeadingZero(seconds) + ' ' + unit;
		
		$("#" + controlID).text(timeString);
		
		if (restTime <= 0) {
			if (finishedMessage)
				$("#" + controlID).text(finishedMessage);
			if (callback)
				callback();
			clearInterval(interval);
		}
	}
	
	this.addLeadingZero = function(number) {
		return ((number < 10) ? '0' : '') + number;
	}
}