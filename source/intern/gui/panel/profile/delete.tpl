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
<? if ($this->hasMessages()): ?>
	<? $this->displayMessages() ?>
<? endif; ?>
<? if (Rakuun_User_Manager::getCurrentUser()->getDatabaseCount() > 0): ?>
	<p style="color: red">Du verteidigst ein Datenbankteil für deine Allianz und kannst dich daher nicht löschen.</p><br class="clear" />
<? endif; ?>
Um den Account zu löschen ist dein Passwort notwendig:
<br class="clear" />
<? $this->displayLabelForPanel('password'); ?> <? $this->displayPanel('password'); ?>
<br class="clear" />
Wir arbeiten ständig an der Verbesserung des Spiels und sind an jedem Hinweis, der uns hierbei hilft, sehr interessiert. Falls du uns hier noch irgendwelche Verbesserungsvorschläge oder den Grund für deine Accountlöschung mitteilen willst, würden wir uns darüber sehr freuen.
<br class="clear" />
<? $this->displayLabelForPanel('text'); ?> <? $this->displayPanel('text'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>