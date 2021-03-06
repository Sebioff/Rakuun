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
	<div class="rakuun_message_head">
		<h1 class="subject">
			<?= Text::escapeHTML($this->getMessage()->subject); ?>
		</h1>
		<div class="sender">
			<? $this->displayLabelForPanel('sender'); ?>: <? $this->displayPanel('sender'); ?>
		</div>
		<div class="date">
			<? $this->displayPanel('date'); ?>
		</div>
		<br class="clear" />
	</div>
	<div class="rakuun_message_content">
		<?= Rakuun_Text::formatPlayerText($this->getMessage()->text, false); ?>
	</div>
	<? if ($this->getMessage()->type == Rakuun_Intern_IGM::TYPE_PRIVATE): ?>
		<? $userLinks = array(); ?>
		<? foreach ($this->getMessage()->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_COPYRECIPIENT) as $copyRecipient): ?>
			<? $userLink = new Rakuun_GUI_Control_UserLink('user', Rakuun_DB_Containers::getUserContainer()->selectByPK($copyRecipient->value), $copyRecipient->value); ?>
			<? $userLinks[] = $userLink->render(); ?>
		<? endforeach; ?>
		<? if (!empty($userLinks)): ?>
			Kopien: <?= implode(', ', $userLinks); ?>
			<? $replyAllUrlParams = $this->getModule()->getParams(); ?>
			<? $replyAllUrlParams['replyTo'] = 'all'; ?>
			<? $replyAllUrl = $this->getModule()->getUrl($replyAllUrlParams); ?>
			<? $replyLink = new GUI_Control_Link('reply_all_link', 'Allen Antworten', $replyAllUrl); ?>
			<?= $replyLink->render(); ?>
		<? endif; ?>
	<? endif; ?>
	<? if ($this->getMessage()->type == Rakuun_Intern_IGM::TYPE_SPY && $reportIDs = $this->getMessage()->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_SPYREPORTLOG)): ?>
		<? $reportID = $reportIDs[0]->value; ?>
		<? $warsimLinkUrl = App::get()->getInternModule()->getSubmodule('warsim')->getUrl(array('spyreport' => $reportID)); ?>
		<? $warsimLink = new GUI_Control_Link('warsim_link', 'In WarSim übernehmen', $warsimLinkUrl); ?>
		<?= $warsimLink->render(); ?>
	<? endif; ?>
	<? if ($this->hasPanel('delete')): ?>
		<? $this->displayPanel('delete'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('report')): ?>
		<? $this->displayPanel('report'); ?>
	<? endif; ?>
	<? if ($this->hasPanel('signature')): ?>
		<div class="border_top">
		<? $this->displayPanel('signature'); ?>
	<? endif; ?>
	</div>
</div>