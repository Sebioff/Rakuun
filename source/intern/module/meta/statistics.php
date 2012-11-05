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

class Rakuun_Intern_Module_Meta_Statistics extends Rakuun_Intern_Module_Meta_Common {
	public function init() {
		parent::init();

		$meta = $this->getUser()->alliance->meta;
		$this->setPageTitle('Statistiken - '.$meta->name);
		$this->contentPanel->setTemplate(dirname(__FILE__).'/statistics.tpl');
		$options['order'] = 'name ASC';
		$alliances = Rakuun_User_Manager::getCurrentUser()->alliance->meta->alliances->select($options);
		$panels = array();
		foreach ($alliances as $alliance) {
			$ressourcesPanel = new Rakuun_GUI_Panel_Box('ressources_'.$alliance->getPK(), new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Ressources('ressources', $alliance), 'Rohstoffübersicht');
			$this->contentPanel->addPanel($ressourcesPanel);
			$armyPanel = new Rakuun_GUI_Panel_Box('army_'.$alliance->getPK(), new Rakuun_Intern_GUI_Panel_Alliance_Statistic_Army('army', $alliance), 'Armeeübersicht');
			$this->contentPanel->addPanel($armyPanel);
			$panels[] = array(
				'alliancelink' => new Rakuun_GUI_Control_AllianceLink('link_'.$alliance->getPK(), $alliance),
				'ressources' => $ressourcesPanel,
				'army' => $armyPanel
			);
		}
		$this->contentPanel->params->panels = $panels;
	}
}

?>