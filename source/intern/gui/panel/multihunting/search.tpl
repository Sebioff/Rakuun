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
<? endif; ?>

<? $this->displayLabelForPanel('ip') ?> <? $this->displayPanel('ip') ?>
<br class="clear" />
<? $this->displayLabelForPanel('hostname') ?> <? $this->displayPanel('hostname') ?>
<br class="clear" />
<? $this->displayLabelForPanel('browser') ?> <? $this->displayPanel('browser') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && count($this->params->logs)): ?>
	<br class="clear" />
	<? 	$this->addPanel($table = new GUI_Panel_Table('table', 'Suchergebnis')); ?>
	<? 	$table->addHeader(array('Aktion', 'Darum', 'User', 'IP', 'Hostname', 'Browser')); ?>
	<? foreach ($this->params->logs as $log): ?>
		<?	$date = new GUI_Panel_Date('date'.$log->getPK(), $log->time); ?>
		<?	$table->addLine(array(Rakuun_Intern_Log::getActionDescription($log->action), $date, $log->user->name, $log->ip, $log->hostname, $log->browser)); ?>
	<? endforeach; ?>
	<? $this->displayPanel('table') ?>
<? endif; ?>