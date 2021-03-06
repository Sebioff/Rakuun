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

class Rakuun_Intern_Module_Overview extends Rakuun_Intern_Module {
	public function init() {
		// demo account login
		if (!Rakuun_Game::isLoginDisabled() && $loginParam = $this->getParam('login')) {
			if ($loginParam == 'testaccount') {
				Rakuun_User_Manager::login(RAKUUN_TESTACCOUNT_NAME, RAKUUN_TESTACCOUNT_PASSWORD);
			}
		}
		
		parent::init();
		
		$this->setPageTitle('Übersicht');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/overview.tpl');
		$this->addJsRouteReference('js', 'fb.js');
		
		$user = Rakuun_User_Manager::getCurrentUser();
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('news', new Rakuun_Intern_GUI_Panel_User_News('news'), 'Aktuelles'));
		
		// dancertia countdown
		$options = array();
		$options['conditions'][] = array('dancertia_starttime > 0');
		$options['order'] = 'dancertia_starttime ASC';
		if ($metaWithDancertia = Rakuun_DB_Containers::getMetasContainer()->selectFirst($options)) {
			$dancertiaCountdownPanel = new Rakuun_GUI_Panel_Box_Collapsible('dancertia_countdown', new Rakuun_Intern_GUI_Panel_Meta_DancertiaCountdown('dancertia_countdown', $metaWithDancertia, 'Raumschiffstart!'), 'Raumschiffstart!');
			$dancertiaCountdownPanel->addClasses('rakuun_box_dancertiastart');
			$this->contentPanel->addPanel($dancertiaCountdownPanel);
		}
		
		if (!Rakuun_User_Manager::isSitting()) {
			// panel for outgoing armies
			if (Rakuun_DB_Containers::getArmiesContainer()->selectByUserFirst($this->getUser())) {
				$outgoingArmiesPanel = new Rakuun_GUI_Panel_Box_Collapsible('outgoing_armies', new Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmies('outgoing_armies', 'Laufende Angriffe'), 'Laufende Angriffe');
				$outgoingArmiesPanel->addClasses('rakuun_box_outgoingarmies');
				$this->contentPanel->addPanel($outgoingArmiesPanel);
			}
			
			// panel for incomming armies
			$options = Rakuun_Intern_GUI_Panel_Map_Fights_IncommingArmies::getOptionsForVisibleArmies();
			if (Rakuun_DB_Containers::getArmiesContainer()->selectFirst($options)) {
				$incommingArmiesPanel = new Rakuun_GUI_Panel_Box_Collapsible('incomming_armies', new Rakuun_Intern_GUI_Panel_Map_Fights_IncommingArmies('incomming_armies', 'Eingehende Angriffe'), 'Eingehende Angriffe');
				$incommingArmiesPanel->addClasses('rakuun_box_incommingarmies');
				$this->contentPanel->addPanel($incommingArmiesPanel);
			}
		}
		
		// panels for currently produced buildings/technologies/units
		$options = array();
		$options['conditions'][] = array('user = ?', $this->getUser());
		if (Rakuun_DB_Containers::getBuildingsWIPContainer()->selectFirst($options)) {
			$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_CityItems('wip_buildings', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getBuildingsContainer(), Rakuun_DB_Containers::getBuildingsWIPContainer()), 'Aktueller Bauvorgang');
			$wipPanel->enableQueueView(false);
			$wipPanel->addClasses('rakuun_box_wipbuildings');
			$this->contentPanel->addPanel($wipPanel);
		}
		if (Rakuun_DB_Containers::getTechnologiesWIPContainer()->selectFirst($options)) {
			$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_CityItems('wip_technologies', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers::getTechnologiesWIPContainer()), 'Aktuelle Forschung');
			$wipPanel->enableQueueView(false);
			$wipPanel->addClasses('rakuun_box_wiptechnologies');
			$this->contentPanel->addPanel($wipPanel, true);
		}
		if (Rakuun_DB_Containers::getUnitsWIPContainer()->selectFirst($options)) {
			$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Units('wip_units', new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer()), 'Aktuelle Einheitenproduktion');
			$wipPanel->enableQueueView(false);
			$wipPanel->addClasses('rakuun_box_wipunits');
			$this->contentPanel->addPanel($wipPanel, true);
		}
		
		// overview panels for owned buildings/technologies/units
		$this->contentPanel->addPanel(
			$buildingList = new Rakuun_Intern_GUI_Panel_Production_ProducedList(
				'buildings', Rakuun_Intern_Production_Factory::getAllBuildings(), null, 'Gebäude'
			)
		);
		$buildingList->addClasses('rakuun_building_list');
		$this->contentPanel->addPanel(
			$technologyList = new Rakuun_Intern_GUI_Panel_Production_ProducedList(
				'technologies', Rakuun_Intern_Production_Factory::getAllTechnologies(), null, 'Forschungen'
			)
		);
		$technologyList->addClasses('rakuun_technology_list');
		$this->contentPanel->addPanel(
			$unitList = new Rakuun_Intern_GUI_Panel_Production_ProducedListUnits(
				'units', Rakuun_Intern_Production_Factory::getAllUnits(), null, 'Einheiten'
			)
		);
		$unitList->addClasses('rakuun_unit_list');
		
		if (!Rakuun_User_Manager::isSitting()) {
			$this->contentPanel->addPanel(
				new Rakuun_GUI_Panel_Box(
					'sbbox',
					new Rakuun_Intern_GUI_Panel_Shoutbox_Global('shoutbox'),
				'Shoutbox'
				)
			);
		}
		
		if ($user->sitter) {
			$this->contentPanel->addPanel($sitterBox = new Rakuun_GUI_Panel_Box('sitterbox', new Rakuun_Intern_GUI_Panel_User_Sitterbox('sitterbox')));
			$sitterBox->addClasses('rakuun_box_sitter');
		}
		
		if (!Rakuun_User_Manager::isSitting() && $sitting = Rakuun_DB_Containers::getUserContainer()->selectBySitterFirst(Rakuun_User_Manager::getCurrentUser())) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('sitterswitch', new Rakuun_Intern_GUI_Panel_User_SitterSwitch('sitterswitch', $sitting)));
		}
		
		// info panel
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('info', new Rakuun_Intern_GUI_Panel_User_Info('info'), 'Informationen'));
		
		// fight tick
		$this->contentPanel->addPanel($fightTick = new Rakuun_GUI_Panel_Box('fight_tick', new Rakuun_Intern_GUI_Panel_Tick_Fight('fight_tick'), 'Kampftick'));
		$fightTick->addClasses('rakuun_box_fighttick');
		
		// specials
		if (Rakuun_DB_Containers::getSpecialsUsersAssocContainer()->selectByUserFirst($user))
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Collapsible('specials', $specialsPanel = new Rakuun_Intern_GUI_Panel_User_Specials('specials'), 'Specials'));
		
		// admin news
		if ($user->adminnews)
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('adminnews', new Rakuun_Intern_GUI_Panel_User_Adminnews('adminnews'), 'Nachricht von den Admins'));
	}
}

?>