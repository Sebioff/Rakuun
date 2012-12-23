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