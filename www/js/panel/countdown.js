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

function GUI_Control_CountDown(controlID, currentTime, targetTime, enableHoverInfo, finishedMessage, callback) {
	var self = this;
	var duration = targetTime - currentTime;
	var interval = setInterval(function(){self.tick();}, 1000);
	var timerID = currentTime;
	var startTime = new Date().getTime();
	
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
		// clean up timers that might still be active e.g. after this panel has been reloaded using ajax
		if ($("#" + controlID).data('activeTimer')) {
			// there exists another active, newer timer
			if ($("#" + controlID).data('activeTimer') > timerID) {
				clearInterval(interval);
				return;
			}
			else if ($("#" + controlID).data('activeTimer') < timerID)
				$("#" + controlID).data('activeTimer', timerID);
		}
		else {
			$("#" + controlID).data('activeTimer', timerID);
		}
		
		var restTime = duration - Math.round((new Date().getTime() - startTime) / 1000);
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