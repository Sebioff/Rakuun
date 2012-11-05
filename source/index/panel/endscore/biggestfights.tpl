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
<? foreach ($this->params->fights as $fight): ?>
	<? $userLink = new Rakuun_GUI_Control_UserLink('user', $fight->user, $fight->get('user')); ?>
	<? $opponentLink = new Rakuun_GUI_Control_UserLink('opponent', $fight->opponent, $fight->get('opponent')); ?>
	<?= ($fight->role == Rakuun_Intern_Log_Fights::ROLE_ATTACKER) ? 'Angriff von' : 'Verteidigung von'; ?>
	<? $userLink->display(); ?>
	(<?= ($fight->type == Rakuun_Intern_Log_Fights::TYPE_WON) ? 'Sieger' : 'Verlierer'; ?>)
	<?= ($fight->role == Rakuun_Intern_Log_Fights::ROLE_ATTACKER) ? 'auf' : 'gegen'; ?>
	<? $opponentLink->display(); ?> am <?= date('d.m.Y, H:i:s', $fight->time); ?>
	<br/>
	Vernichtete Einheiten:
	<br/>
	<? foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit): ?>
		<? $amount = $fight->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')}; ?>
		<? if ($amount > 0): ?>
			<?= Text::formatNumber($amount); ?> <?= $unit->getNameForAmount($amount); ?>
			<br/>
		<? endif; ?>
	<? endforeach; ?>
	<hr/>
<? endforeach; ?>