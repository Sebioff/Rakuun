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
<? if ($this->hasPanel('namecolored')): ?>
	<? $this->displayLabelForPanel('namecolored'); ?> <? $this->displayPanel('namecolored'); ?> <? $this->displayPanel('namecoloredhelp'); ?>
	<br class="clear" />
<? endif; ?>
<? $this->displayLabelForPanel('cityname'); ?> <? $this->displayPanel('cityname'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('icq'); ?> <? $this->displayPanel('icq'); ?>
<? if ($this->hasPanel('description')): ?>
	<br class="clear" />
	<? $this->displayLabelForPanel('description'); ?> <? $this->displayPanel('description'); ?>
<? endif;?>
<br class="clear" />
<? $this->displayLabelForPanel('skin'); ?> <? $this->displayPanel('skin'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('mail'); ?> <? $this->displayPanel('mail'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('sitter'); ?> <? $this->displayPanel('sitter'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('picture'); ?> <? $this->displayPanel('picture'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('tutorial'); ?> <? $this->displayPanel('tutorial'); ?>
<br class="clear" />
<? $this->displayLabelForPanel('boardcount'); ?> <? $this->displayPanel('boardcount'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>