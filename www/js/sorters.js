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

$.tablesorter.addParser(
	{
		id: "army",
		is: function(s) {
			return false;
		},
		format: function(s) {
			inout = s.replace(/\./g, "").split("/");
			build = inout[0].match(/\(\+(.+)\)/);
			sum = parseInt(inout[0]) + parseInt(inout[1]);
			if (build != null)
				sum += parseInt(build[1]);
			return jQuery.tablesorter.formatFloat(sum);
		}, 
		type: "numeric"
	}
);
$.tablesorter.addParser(
	{
		id: "username",
		is: function(s) {
			return false;
		},
		format: function(s) {
			name = s.match(/<span .+>(.+)<\/span>/);
			if (name == null) {
				name = s.match(/<a .+>(.+)<\/a>/);
			}
			return name[1].toUpperCase();
		},
		type: "text"
	}
);
$.tablesorter.addParser(
	{
		id: "mapkoords",
		is: function(s) {
			return false;
		},
		format: function(s) {
			return s.match(/<a .+>(.+)<\/a>/)[1].replace(/:/g, "");
		},
		type: "numeric"
	}
);