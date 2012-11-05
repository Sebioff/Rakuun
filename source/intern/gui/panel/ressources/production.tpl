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
<? $satisfactionBonus = (Rakuun_Intern_Production_Influences::getPeopleSatisfactionRate() * 100) - 100; ?>
<? $satisfactionBonus = ($satisfactionBonus > 0) ? '+'.$satisfactionBonus : $satisfactionBonus ?>
<?= Rakuun_Intern_Production_Influences::getPeopleSatisfactionText() ?>
<? if ($satisfactionBonus != 0): ?>
 - Ressourcenproduktion <?= $satisfactionBonus ?>%
<? endif; ?>
<br/>
<? $ressourceProductionDatabase = new Rakuun_User_Specials_Database(Rakuun_User_Manager::getCurrentUser(), Rakuun_User_Specials::SPECIAL_DATABASE_BROWN); ?>
<? if ($ressourceProductionDatabase->hasSpecial()): ?>
	<?= 'Produktionsrate von Eisen und Beryllium durch Ressourcenproduktions-Datenbankteil um '.($ressourceProductionDatabase->getEffectValue() * 100).'% erhöht';?>
	<br/>
<? endif; ?>
<? $this->displayPanel('ressource_production'); ?>