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
<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<? $this->params->selectionCheckbox->display(); ?>
	<? $this->displayLabelForPanel('receiver'); ?> <? $this->displayPanel('receiver'); ?>
	<? if ($this->getMessage()->type == Rakuun_Intern_IGM::TYPE_FIGHT && $attachments = $this->getMessage()->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_FIGHTREPORTMARKERS)): ?>
		<? $markers = explode(',', $attachments[0]->value); ?>
		<? foreach ($markers as $marker): ?>
			<img class="rakuun_igm_marker" src="<?= Router::get()->getStaticRoute('images', $marker.'.png'); ?>" alt="<?= Rakuun_Intern_IGM::getDescriptionForFightReportMarker($marker); ?>" title="<?= Rakuun_Intern_IGM::getDescriptionForFightReportMarker($marker); ?>" />
		<? endforeach; ?>
	<? endif; ?>
	<? if ($this->getMessage()->get('sender') == Rakuun_User_Manager::getCurrentUser()->getPK() && $this->getMessage()->hasBeenRead): ?>
		<img class="rakuun_igm_marker" src="<?= Router::get()->getStaticRoute('images', 'readigm.png'); ?>" alt="Nachricht wurde gelesen" title="Nachricht wurde gelesen" />
	<? endif; ?>
	<br/>
	<? $this->displayLabelForPanel('sender'); ?> <? $this->displayPanel('sender'); ?>
	<br/>
	<label>Betreff</label> <?= Text::escapeHTML($this->getMessage()->subject); ?>
	<br/>
	<? $this->displayLabelForPanel('date'); ?> <? $this->displayPanel('date'); ?>
	<br/>
	<a href="<?= $this->params->url ?>" class="rakuun_message_open">Öffnen</a>
	<? $this->displayPanel('content'); ?>
</div>