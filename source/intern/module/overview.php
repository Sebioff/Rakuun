<?php

class Rakuun_Intern_Module_Overview extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Übersicht');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/overview.tpl');
		
		if (!Rakuun_User_Manager::isSitting()) {
			$options = array();
			$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
			$options['conditions'][] = array('has_been_read = ?', 0);
			if ($unreadMessages = Rakuun_DB_Containers::getMessagesContainer()->count($options)) {
				$url = App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_UNREAD));
				$this->contentPanel->addPanel($unreadMessagesLink = new GUI_Control_Link('unread_messages', 'Du hast '.$unreadMessages.' ungelesene Nachrichten.', $url));
				if ($unreadMessages == 1)
					$unreadMessagesLink->setCaption('Du hast 1 ungelesene Nachricht.');
			}
			
			// notification of new support tickets for users
			$options = array();
			$options['conditions'][] = array('user = ?', Rakuun_User_Manager::getCurrentUser());
			$options['conditions'][] = array('has_been_read = ?', 0);
			if ($unreadTickets = Rakuun_DB_Containers::getSupportticketsContainer()->count($options)) {
				$url = App::get()->getInternModule()->getSubmodule('messages')->getUrl(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS));
				$this->contentPanel->addPanel($unreadTicketsLink = new GUI_Control_Link('unread_tickets_users', 'Du hast '.$unreadTickets.' ungelesene Supportnachrichten.', $url));
				if ($unreadTickets == 1)
					$unreadTicketsLink->setCaption('Du hast 1 ungelesene Supportnachricht.');
			}
			
			// notification of new support tickets for supporters
			if (Rakuun_TeamSecurity::get()->isInGroup(Rakuun_User_Manager::getCurrentUser(), Rakuun_TeamSecurity::GROUP_SUPPORTERS)) {
				$options = array();
				$options['conditions'][] = array('is_answered = ?', 0);
				if ($unreadTickets = Rakuun_DB_Containers::getSupportticketsContainer()->count($options)) {
					$url = App::get()->getInternModule()->getSubmodule('support')->getUrl();
					$this->contentPanel->addPanel($unreadTicketsLink = new GUI_Control_Link('unread_tickets_supporters', $unreadTickets.' unbeantwortete Supportnachrichten.', $url));
					if ($unreadTickets == 1)
						$unreadTicketsLink->setCaption('1 unbeantwortete Supportnachricht.');
				}
			}
		}
		
		// news panel
		if (Rakuun_User_Manager::getCurrentUser()->news) {
			$this->contentPanel->addPanel(new GUI_Panel_Text('news', Rakuun_User_Manager::getCurrentUser()->news, 'News'));
			Rakuun_User_Manager::getCurrentUser()->news = '';
			Rakuun_User_Manager::update(Rakuun_User_Manager::getCurrentUser());
		}
		
		$options = array();
		$options['conditions'][] = array('dancertia_starttime > 0');
		$options['order'] = 'dancertia_starttime ASC';
		if ($metaWithDancertia = Rakuun_DB_Containers::getMetasContainer()->selectFirst($options)) {
			$dancertiaCountdownPanel = new Rakuun_GUI_Panel_Box_Collapsible('dancertia_countdown', new Rakuun_Intern_GUI_Panel_Meta_DancertiaCountdown('dancertia_countdown', $metaWithDancertia, 'Raumschiffstart!'), 'Raumschiffstart!');
			$this->contentPanel->addPanel($dancertiaCountdownPanel);
		}
		
		if (!Rakuun_User_Manager::isSitting()) {
			// panel for outgoing armies
			if (Rakuun_DB_Containers::getArmiesContainer()->selectByUserFirst($this->getUser())) {
				$outgoingArmiesPanel = new Rakuun_GUI_Panel_Box_Collapsible('outgoing_armies', new Rakuun_Intern_GUI_Panel_Map_Fights_OutgoingArmies('outgoing_armies', 'Laufende Angriffe'), 'Laufende Angriffe');
				$this->contentPanel->addPanel($outgoingArmiesPanel);
			}
			
			// panel for incomming armies
			// TODO booh, duplicate code. See Rakuun_Intern_GUI_Panel_Map_Fights_IncommingArmies
			$options = array();
			$options['conditions'][] = array('target = ?', Rakuun_User_Manager::getCurrentUser());
			$options['conditions'][] = array('target_x = ?', Rakuun_User_Manager::getCurrentUser()->cityX);
			$options['conditions'][] = array('target_y = ?', Rakuun_User_Manager::getCurrentUser()->cityY);
			$cloakingUnits = array();
			$unCloakingUnits = array();
			foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit) {
				if ($unit->getBaseAttackValue() > 0) {
					if ($unit->getAttribute(Rakuun_Intern_Production_Unit::ATTRIBUTE_CLOAKING)) {
						$cloakingUnits[] = $unit->getInternalName();
					}
					else {
						$unCloakingUnits[] = $unit->getInternalName();
					}
				}
			}
			$sensorfieldRange = Rakuun_Intern_Production_Factory::getBuilding('sensor_bay')->getRange();
			// respect cloaked armies + sensorfield
			$options['conditions'][] = array(implode('+',$cloakingUnits).' <= 0 OR target_time-'.$sensorfieldRange.' <= ? OR '.implode('+',$unCloakingUnits).' > 0', time());
			if (Rakuun_DB_Containers::getArmiesContainer()->selectFirst($options)) {
				$incommingArmiesPanel = new Rakuun_GUI_Panel_Box_Collapsible('incomming_armies', new Rakuun_Intern_GUI_Panel_Map_Fights_IncommingArmies('incomming_armies', 'Eingehende Angriffe'), 'Eingehende Angriffe');
				$this->contentPanel->addPanel($incommingArmiesPanel);
			}
		}
		
		// panels for currently produced buildings/technologies/units
		$options = array();
		$options['conditions'][] = array('user = ?', $this->getUser());
		if (Rakuun_DB_Containers::getBuildingsWIPContainer()->selectFirst($options)) {
			$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP('wip_buildings', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getBuildingsContainer(), Rakuun_DB_Containers::getBuildingsWIPContainer()), 'Momentaner Bauvorgang');
			$wipPanel->enableQueueView(false);
			$this->contentPanel->addPanel($wipPanel);
		}
		if (Rakuun_DB_Containers::getTechnologiesWIPContainer()->selectFirst($options)) {
			$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP('wip_technologies', new Rakuun_Intern_Production_Producer_CityItems(Rakuun_DB_Containers::getTechnologiesContainer(), Rakuun_DB_Containers::getTechnologiesWIPContainer()), 'Momentane Forschung');
			$wipPanel->enableQueueView(false);
			$this->contentPanel->addPanel($wipPanel, true);
		}
		if (Rakuun_DB_Containers::getUnitsWIPContainer()->selectFirst($options)) {
			$wipPanel = new Rakuun_Intern_GUI_Panel_Production_WIP_Units('wip_units', new Rakuun_Intern_Production_Producer_Units(Rakuun_DB_Containers::getUnitsContainer(), Rakuun_DB_Containers::getUnitsWIPContainer()), 'Momentane Einheitenproduktion');
			$wipPanel->enableQueueView(false);
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
					new Rakuun_Intern_GUI_Panel_Shoutbox('shoutbox', Rakuun_DB_Containers::getShoutboxContainer()),
				'Shoutbox'
				)
			);
		}
		
		if (Rakuun_User_Manager::getCurrentUser()->sitter)
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_User_Sitterbox('sitterbox'));
		
		if (!Rakuun_User_Manager::isSitting() && $sitting = Rakuun_DB_Containers::getUserContainer()->selectBySitterFirst(Rakuun_User_Manager::getCurrentUser())) {
			$this->contentPanel->addPanel(new Rakuun_Intern_GUI_Panel_User_SitterSwitch('sitterswitch', $sitting));
		}
		
		//Info Panel
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('info', new Rakuun_Intern_GUI_Panel_User_Info('info'), 'Informationen'));
	}
}

?>