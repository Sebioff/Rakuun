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
<? $user = Rakuun_User_Manager::getCurrentUser(); ?>
<?= Rakuun_Intern_Production_Influences::getPeopleSatisfactionText($user); ?>
<br class="clear" />
<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
<? endif; ?>
<br class="clear" />
Username:
<? $userlink = new Rakuun_GUI_Control_UserLink('userlink', $user); ?>
<? $userlink->display(); ?>
<br class="clear" />
Stadtname: <?= Text::escapeHTML($user->cityName); ?>
<br class="clear" />
Punkte: <?= Text::formatNumber((int)$user->points); ?>
<br class="clear" />
Platz: <?= Text::formatNumber((int)Rakuun_Intern_Statistics::getRank($user)); ?>
<? if ($user->alliance) : ?>
	<br class="clear" />
	Allianz:
	<? $allylink = new Rakuun_GUI_Control_AllianceLink('allylink', $user->alliance, $user->alliance->name); ?>
	<? $allylink->display(); ?>
<? endif;?>
<br class="clear" />
Koordinaten:
<? $mapLink = new Rakuun_GUI_Control_Maplink('maplink', $user, 'zur Karte'); ?>
<? $mapLink->display(); ?>
<br class="clear" />
<? if($user->isInNoob()): ?>
<br class="clear" />
	<b>Hinweis</b>: Du befindest dich im Noobschutz!
	<br/>
	Im Noobschutz kannst du nicht handeln und nicht angegriffen werden.
	<br/>
	Du verlässt den Noobschutz, sobald deine Punktzahl &gt; <?= Text::formatNumber(Rakuun_Intern_Statistics::getNoobPointLimit()); ?>
	oder deine Armeestärke &gt; <?= Text::formatNumber(Rakuun_Intern_Statistics::getNoobArmyStrengthLimit()); ?> ist.
	<br/>
	Du kehrst jederzeit wieder in den Noobschutz zurück, sobald alle der oben genannten Kriterien zutreffen und du:
	<br/>
	<ul>
		<li>- kein Datenbankteil hälst</li>
		<li>- kein Schildgenerator hast</li>
		<li>- keine laufenden Angriffe hast</li>
	</ul>
<? endif; ?>