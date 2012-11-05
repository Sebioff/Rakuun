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
<? $i = 0; ?>
<? foreach (Rakuun_GameSecurity::get()->getVIPGroups() as $group): ?>
	<? $this->displayPanel('group_'.$i); ?>
	<? ++$i; ?>
	<br class="clear" />
<? endforeach; ?>
<div style="font-weight:bold">Konzept &amp; Entwicklung</div>
Sebastian "<?= Rakuun_Text::colorUsername("[gold]Sebi[/gold][lightgrey]off[/lightgrey]"); ?>" Mayer
<br class="clear" />
Andreas "<?= Rakuun_Text::colorUsername("[orange]o[/orange][white]ut-[/white][orange]o[/orange][white]f-[/white][orange]o[/orange][white]rder[/white]"); ?>" Sicking
<br class="clear" />
André "<?= Rakuun_Text::colorUsername("[darkblue]dr[/darkblue][lime].[/lime][white]dent[/white]"); ?>" Jährling
<br class="clear" />