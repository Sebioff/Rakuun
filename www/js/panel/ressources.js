function GUI_Control_Ressources(controlID, amount, productionRate, limit) {
	var self = this;
	var interval = setInterval(function(){self.tick();}, 1000 / productionRate);
	
	this.tick = function() {
		if (amount < limit) {
			amount++;
			$("#" + controlID).text(self.numberFormat(amount));
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