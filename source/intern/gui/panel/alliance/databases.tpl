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
<? $databases = $this->getMetaDatabases(); ?>
<? $databasesCount = count($databases); ?>
<? $actualUser = Rakuun_User_Manager::getCurrentUser(); ?>
<? $visibleCount = 0; ?>
<? $effects = Rakuun_User_Specials::getEffects(); ?>
<? if (!empty($databases)): ?>
	<ul>
		<? foreach ($databases as $databaseRecord): ?>
			<? if ($actualUser && $actualUser->alliance && $actualUser->alliance->canSeeDatabase($databaseRecord->identifier)): ?>
				<li>
					<? $database = new Rakuun_User_Specials_Database($databaseRecord->user, $databaseRecord->identifier); ?>
					<? $images = Rakuun_User_Specials_Database::getDatabaseImages(); ?>
					<? $image = new GUI_Panel_Image('image_'.$databaseRecord->identifier, Router::get()->getStaticRoute('images', $images[$databaseRecord->identifier].'.gif')); ?>
					<?= $image->render(); ?>
					<?= $effects[$databaseRecord->identifier]; ?> (aktuell: +<?= $database->getEffectValue($this->getAlliance()) * 100; ?>%)
				</li>
				<? $visibleCount++; ?>
			<? endif; ?>
		<? endforeach; ?>
		<? if ($visibleCount != $databasesCount): ?>
			<li><hr />Diese Allianz besitzt <?= ($databasesCount - $visibleCount) ?> <?= ($visibleCount < $databasesCount ? 'weitere(s) ' : '') ?>Datenbankteil(e).</li>
		<? endif; ?>
	</ul>
<? else: ?>
	Keine.
<? endif; ?>