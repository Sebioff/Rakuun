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

if (supports_canvas()) {
	element = document.createElement("canvas");
	element.setAttribute("width", 250);
	element.setAttribute("height", 550);
	element.style.top = "0";
	element.style.right = "0";
	element.style.position = "absolute";
	element.style.zIndex = "-1";
	document.getElementById("ctn_index").style.position = "relative";
	document.getElementById("ctn_index").appendChild(element);
	c = element.getContext("2d");
	
	// read the width and height of the canvas
	width = parseInt(element.getAttribute("width"));
	height = parseInt(element.getAttribute("height"));
	
	function setPixel(imageData, x, y, r, g, b, a) {
	    index = (x + y * width) * 4;
	    imageData[index+0] = r;
	    imageData[index+1] = g;
	    imageData[index+2] = b;
	    imageData[index+3] = a;
	}
	
	particles = new Array();
	
	setInterval("go()", 35);
}

// create a new pixel array
function go() {
	image = c.createImageData(width, height);
	var imageData = image.data;

	for (i in particles) {
		particle = particles[i];
		particle.move();
		if (particle.getAge() > 255 || particle.getX() >= width || particle.getX() < 0 || particle.getY() >= height || particle.getY() < 0)
	    	particles.splice(i, 1);
		else
	    	setPixel(imageData, particle.getX(), particle.getY(), particle.getR(), particle.getG(), particle.getB(), 255-particle.getAge()); // 0xff opaque
	}
	image.data = imageData;
	
	// copy the image data back onto the canvas
	c.putImageData(image, 0, 0); // at coords 0,0

	if (Math.floor(Math.random() * 30) == 0) {
		particles.push(new particleObj(Math.random() * (width - 100), 100 + Math.random() * (height - 200), Math.floor(Math.random() * 3) - Math.floor(Math.random() * 3), Math.floor(Math.random() * 3) - Math.floor(Math.random() * 6), Math.round(Math.random()), 120, 2, 255, 255, 255));
	}
}


function particleObj(x, y, vx, vy, type, age, vage, r, g, b) {
	this.move = function() {
		x += vx;
		y += vy;
		age += vage;
		vy += 0.05;
		vx *= 0.999;

		if (type == 0 && age == 200) {
			rad = Math.floor(Math.random() * 5);
			for (i = 0; i < Math.PI * 2; i += Math.PI * 2 / 20) {
				particles.push(new particleObj(x, y, vx + Math.cos(i) / rad, vy + Math.sin(i) / rad, 2, 140, 1, 255, 255, 255));
			}
		}
		if (type == 1 && age == 200) {
			rad = Math.floor(Math.random() * 5);
			rn = Math.floor(Math.random() * 255);
			gn = Math.floor(Math.random() * 255);
			bn = Math.floor(Math.random() * 255);
			for (i = 0; i < Math.PI * 2; i += Math.PI * 2 / 20) {
				particles.push(new particleObj(x, y, vx + Math.cos(i) / rad, vy + Math.sin(i) / rad, 3, 0, 1, rn, gn, bn));
			}
		}
		if (type == 2 && age == 160) {
			rn = Math.floor(Math.random() * 255);
			gn = Math.floor(Math.random() * 255);
			bn = Math.floor(Math.random() * 255);
			for (i = 0; i < Math.PI * 2; i += Math.PI * 2 / 5) {
				particles.push(new particleObj(x, y, vx + Math.cos(i) / 4,  vy + Math.sin(i) / 4, 3, 0, 1, rn, gn, bn));
			}
		}
	}

	this.getX = function() {
		return Math.round(x);
	}

	this.getY = function() {
		return Math.round(y);
	}

	this.getAge = function() {
		return age;
	}

	this.getR = function() {
		return r;
	}

	this.getG = function() {
		return g;
	}

	this.getB = function() {
		return b;
	}
}

function supports_canvas() {
  return !!document.createElement('canvas').getContext;
}