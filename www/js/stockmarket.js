function SM_trade(buyAmount, buyPool, sellPool, minC, maxC) {
	sellAmount = 0;
	while (buyAmount > 0 && buyPool > 0) {
		buyAmount--;
		price = sellPool / buyPool;
		if (price < minC)
			price = minC;
		if (price > maxC)
			price = maxC;
		sellAmount += price;
		buyPool--;
		sellPool += price;
	}
	return Math.ceil(sellAmount);
}