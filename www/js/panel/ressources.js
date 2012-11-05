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

function GUI_Control_Ressources(controlID, amount, productionRate, limit) {
	var self = this;
	var interval = setInterval(function(){self.tick();}, Math.max(300, 1000 / productionRate));
	var control = document.getElementById(controlID);
	var startTime = new Date().getTime();
	
	this.tick = function() {
		currentAmount = amount + (new Date().getTime() - startTime) / 1000 * productionRate;
		if (currentAmount < limit) {
			// not using jQuery here for the update for a tiny performance gain
			control.innerHTML = self.numberFormat(currentAmount);
		}
		else {
			control.innerHTML = self.numberFormat(limit);
			clearInterval(interval);
		}
	}
	
	this.numberFormat = function(number) {
		number = String(Math.round(number));
		formattedNumber = "";

		while (number.length > 3) {
			part = number.substr(number.length - 3, 3);
			if (formattedNumber)
				formattedNumber = part + "." + formattedNumber;
			else
				formattedNumber = part;
			number = number.substr(0, number.length - 3);
		}
		if (number) {
			if (formattedNumber)
				formattedNumber = number + "." + formattedNumber;
			else
				formattedNumber = number;
		}
		
		return formattedNumber;
	}
}