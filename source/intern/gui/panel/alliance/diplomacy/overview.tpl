<?
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
?>
<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif ?>
<? if (count($this->params->auvbs) > 0): ?>
	Angriffs- und Verteidigungsbündnisse<br />
	<ul class="diplomacy-offer">
		<? foreach ($this->params->auvbs as $auvb): ?>
			<li>
				<dl>
					<dt>Allianz:</dt>
					<dd><? $link = new Rakuun_GUI_Control_AllianceLink('link', $auvb->other); $link->display(); ?></dd>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
	<hr />
<? endif; ?>
<? if (count($this->params->naps) > 0): ?>
	Nicht-Angriffs-Pakte<br />
	<ul class="diplomacy-offer">
		<? foreach ($this->params->naps as $nap): ?>
			<li>
				<dl>
					<dt>Allianz:</dt>
					<dd><? $link = new Rakuun_GUI_Control_AllianceLink('link', $nap->other); $link->display();  ?></dd>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
	<hr />
<? endif; ?>
<? if (count($this->params->wars) > 0): ?>
	Kriege<br />
	<ul class="diplomacy-offer">
		<? foreach ($this->params->wars as $war): ?>
			<li>
				<dl>
					<dt>Allianz:</dt>
					<dd><? $link = new Rakuun_GUI_Control_AllianceLink('link', $war->other); $link->display();  ?></dd>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>