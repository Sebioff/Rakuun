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
<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->params->type == Rakuun_Intern_GUI_Panel_User_Directory::TYPE_MESSAGES): ?>
	<ul>
		<li>
			<u>System</u>
			<dl>
				<dt>Support</dt>
				<dd>
					<? $link = new GUI_Control_Link(
						'support',
						'write',
						App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS))
					); ?>
					<? $link->addClasses('rakuun_gui_writemessage'); ?>
					<? $link->display(); ?>
				</dd>
			</dl>
		</li>
	</ul>
	<br class="clear"/>
	<? if (!empty($this->params->groups)): ?>
		<ul>
			<? foreach ($this->params->groups as $group): ?>
				<li>
					<u><?= $group['group']->name; ?></u>
					<br class="clear"/>
					<? if (!empty($group['entities'])): ?>
							<? foreach ($group['entities'] as $entity): ?>
								<? $userLink = new Rakuun_GUI_Control_UserLink('userlink'.$entity->getPK(), $entity->user); ?>
								<? $userLink->display(); ?>
								<? $link = new GUI_Control_JsLink(
									'link'.$entity->getPK(),
									'write',
									// FIXME Evil hardcoded stuff, don't hit me too hard
									'$(\'#main-messages_content-send-send-recipients\').val($(\'#main-messages_content-send-send-recipients\').val() + \''.$entity->user->nameUncolored.', \');return false;'
									// Link needs fallback-url
								); ?>
								<? $link->addClasses('rakuun_gui_writemessage'); ?>
								<? $link->display(); ?>
								<br class="clear"/>
							<? endforeach; ?>
					<? endif; ?>
				</li>
		<? endforeach; ?>
		</ul>
		<br class="clear"/>
	<? endif; ?>
<? elseif ($this->params->type == Rakuun_Intern_GUI_Panel_User_Directory::TYPE_ARMY): ?>
	<? //TODO: Need to be implemented ?>
<? endif; ?>
<hr />
<? $link = new GUI_Control_Link('editlink', 'bearbeiten', Router::get()->getCurrentModule()->getURL(array('edit' => true))); ?>
<? $link->display(); ?>
<br />
<? $this->displayLabelForPanel('name'); ?>
<? $this->displayPanel('name'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>