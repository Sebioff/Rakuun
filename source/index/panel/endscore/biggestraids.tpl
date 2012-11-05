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
<? foreach ($this->params->raids as $raid): ?>
	<? $userLink = new Rakuun_GUI_Control_UserLink('user', $raid->user, $raid->get('user')); ?>
	<? $opponentLink = new Rakuun_GUI_Control_UserLink('opponent', $raid->sender, $raid->get('sender')); ?>
	Angriff von <? $userLink->display(); ?> auf	<? $opponentLink->display(); ?> am <?= date('d.m.Y, H:i:s', $raid->time); ?>
	<br/>
	Beute:
	<br/>
	<?= Text::formatNumber($raid->iron); ?> Eisen
	<br/>
	<?= Text::formatNumber($raid->beryllium); ?> Beryllium
	<br/>
	<?= Text::formatNumber($raid->energy); ?> Energie
	<hr/>
<? endforeach; ?>