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
<h1 class="slogan">Rakuun - kostenloses SciFi-Browsergame</h1>
<h2>Baue, forsche, handle, kämpfe!</h2>

<? if ($roundInformation = Rakuun_DB_Containers_Persistent::getRoundInformationContainer()->selectByRoundNameFirst(RAKUUN_ROUND_NAME)): ?>
	<br/>
	Die aktuelle Runde wurde durch einen Sieg der Meta "<?= $roundInformation->winningMeta; ?>" gewonnen.
	<br/>
	<center><a href="<?= App::get()->getModule('endscore')->getUrl(); ?>"><u>Zum Endhighscore</u></a></center>
<? endif; ?>

<? if ($this->hasPanel('start_countdown')): ?>
	<br/>
	<u>Start der nächsten Runde:</u>
	<br/>
	<?= date('d.m.Y, H:i:s', RAKUUN_ROUND_STARTTIME); ?> Uhr
	<br/>
	Noch <? $this->displayPanel('start_countdown'); ?>!
	<br/>
<? endif; ?>

<? $settings = ''; ?>
<? if (RAKUUN_SPEED_BUILDING > 1): ?>
	<? $settings .= '<br/>Baugeschwindigkeit x'.RAKUUN_SPEED_BUILDING; ?>
<? endif; ?>
<? if (RAKUUN_SPEED_UNITPRODUCTION > 1): ?>
	<? $settings .= '<br/>Einheitenproduktion x'.RAKUUN_SPEED_UNITPRODUCTION; ?>
<? endif; ?>
<? if (RAKUUN_SPEED_UNITMOVEMENT > 1): ?>
	<? $settings .= '<br/>Angriffsgeschwindigkeit x'.RAKUUN_SPEED_UNITMOVEMENT; ?>
<? endif; ?>
<? if (RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER > 1): ?>
	<? $settings .= '<br/>Ressourcenproduktion x'.RAKUUN_RESSOURCEPRODUCTION_MULTIPLIER; ?>
<? endif; ?>
<? if (RAKUUN_STORE_CAPACITY_MULTIPLIER > 1): ?>
	<? $settings .= '<br/>Lagerkapazität x'.RAKUUN_STORE_CAPACITY_MULTIPLIER; ?>
<? endif; ?>
<? if (RAKUUN_TRADELIMIT_MULTIPLIER > 1): ?>
	<? $settings .= '<br/>Handelsvolumen x'.RAKUUN_TRADELIMIT_MULTIPLIER; ?>
<? endif; ?>

<? if ($settings): ?>
	<br/>
	<u>Einstellungen</u>
	<?= $settings; ?>
	<br/>
<? endif; ?>
<br />
<span class="copyright">
	Rakuun, Codes, Ideen und Grafiken:
	<br />
	&copy; 2002-<?= date('Y'); ?> by Rakuun-Team
	<br />
	Rakuun Version <?= RAKUUN_VERSION; ?>, revision <?= PROJECT_VERSION; ?>
</span>