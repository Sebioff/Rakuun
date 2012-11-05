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
					<dd><?= $auvb->other->name; ?></dd>
					<dt>Kündigungsfrist:</dt>
					<dd><?= $auvb->notice; ?> Stunden</dd>
					<dt>Botschaft:</dt>
					<dd><?= $auvb->text; ?></dd>
					<dt>Aktion:</dt>
					<? if ($auvb->other == $auvb->allianceActive): ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('accept' => $auvb->getPK())); ?>">annehmen</a></dd>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('deny' => $auvb->getPK())); ?>">ablehnen</a></dd>
					<? else: ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('cancel' => $auvb->getPK())); ?>">zurückziehen</a></dd>
					<? endif; ?>
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
					<dd><?= $nap->other->name; ?></dd>
					<dt>Kündigungsfrist:</dt>
					<dd><?= $nap->notice; ?> Stunden</dd>
					<dt>Botschaft:</dt>
					<dd><?= $nap->text; ?></dd>
					<dt>Aktion:</dt>
					<? if ($nap->other == $nap->allianceActive): ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('accept' => $nap->getPK())); ?>">annehmen</a></dd>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('deny' => $nap->getPK())); ?>">ablehnen</a></dd>
					<? else: ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('cancel' => $nap->getPK())); ?>">zurückziehen</a></dd>
					<? endif; ?>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
	<hr />
<? endif; ?>