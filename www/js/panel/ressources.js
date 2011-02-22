function GUI_Control_Ressources(controlID, amount, productionRate, limit) {
	var self = this;
	var interval = setInterval(function(){self.tick();}, Math.max(100, 1000 / productionRate));
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