<?php

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

class Rakuun_Intern_GUI_Panel_Admin_Cronjobs extends GUI_Panel {
	public function __construct($name) {
		parent::__construct($name);
		
		$this->setTemplate(dirname(__FILE__).'/cronjobs.tpl');
		
		$this->addPanel($table = new GUI_Panel_Table('cronjobs', 'Cronjobs'));
		$table->addHeader(array('Cronjob', 'Letzte Ausführung', 'Erfolgreich', 'Dauer (s)'));
		foreach (Rakuun_DB_Containers::getCronjobsContainer()->select() as $cronjob) {
			$table->addLine(array($cronjob->identifier, date('d.m.Y, H:i:s', $cronjob->lastExecution), $cronjob->lastExecutionSuccessful, $cronjob->lastExecutionDuration));
		}
	}
}

?>