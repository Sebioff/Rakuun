<?php

/**
 * Parent module for all internal (= ingame) sites.
 */
class Rakuun_Intern_Module extends Rakuun_Module {
	const TIMEOUT_BOTVERIFICATION = 3600; // time after which user has to verify he is no bot
	const TIMEOUT_NOACTIVITY = 3600; // time of inactivity after which user is automatically logged out
	const TIMEOUT_ISONLINE = 300; // time after which a user is considered to be offline
	
	public function init() {
		parent::init();
		
		// not logged in? redirect to login page
		if (!$this->getUser()) {
			$params = array('return' => base64_encode($this->getUrl($this->getParams())));
			Scriptlet::redirect(App::get()->getLoginModule()->getUrl($params));
		}
		
		// has been inactive? end session
		if (time() > $this->getUser()->lastActivity + self::TIMEOUT_NOACTIVITY
			&& Environment::getCurrentEnvironment() != Environment::DEVELOPMENT
		) {
			$params = array('return' => base64_encode($this->getUrl($this->getParams())));
			$params['logout-reason'] = 'noactivity';
			Scriptlet::redirect(App::get()->getLoginModule()->getUrl($params));
		}
		
		// need to re-verify you are no bot? redirect to bot protection page
		// only display if no action made or last verification long ago (to avoid abuse of first rule)
		if (time() > $this->getUser()->lastBotVerification + self::TIMEOUT_BOTVERIFICATION
			&& Router::get()->getRequestMode() != Router::REQUESTMODE_AJAX
			&& Environment::getCurrentEnvironment() != Environment::DEVELOPMENT
			&& (empty($_POST) || time() > $this->getUser()->lastBotVerification + 2 * self::TIMEOUT_BOTVERIFICATION)
		) {
			$params = array('return' => base64_encode($this->getUrl($this->getParams())));
			Scriptlet::redirect(App::get()->getInternModule()->getSubmodule('botprotection')->getUrl($params));
		}
		
		// update lastActivity/isOnline max. every 10 seconds - should be enough and saves some queries
		if ($this->getUser()->lastActivity + 10 < time()) {
			$this->getUser()->lastActivity = time();
			if (!Rakuun_User_Manager::isSitting())
				$this->getUser()->isOnline = time();
			Rakuun_User_Manager::update($this->getUser());
		}
		$this->getUser()->produceRessources();
		
		$this->mainPanel->setTemplate(dirname(__FILE__).'/main.tpl');
		$this->addCssRouteReference('css', 'ingame.css');
		
		Rakuun_GUI_Skinmanager::get()->setCurrentSkin($this->getUser()->skin);
		$this->mainPanel->addClasses(Rakuun_GUI_Skinmanager::get()->getCurrentSkinClass());
		
		$navigation = new CMS_Navigation();
		$navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('overview'), 'Übersicht', array('rakuun_navigation_node_overview'));
		
		$productionNode = $navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('build'), 'Produktion', array('rakuun_navigation_node_build'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('build'))
			$productionNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('build'), 'Gebäude', array('rakuun_navigation_node_build'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('research'))
			$productionNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('research'), 'Forschungen', array('rakuun_navigation_node_research'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('produce'))
			$productionNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('produce'), 'Einheiten', array('rakuun_navigation_node_produce'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('techtree'))
			$productionNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('techtree'), 'Techtree', array('rakuun_navigation_node_techtree'));
		
		$ressourcesNode = $navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('ressources'), 'Rohstoffe', array('rakuun_navigation_node_ressources'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('trade'))
			$ressourcesNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('trade'), 'Handeln', array('rakuun_navigation_node_trade'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('stockmarket'))
			$ressourcesNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('stockmarket'), 'Börse', array('rakuun_navigation_node_stockmarket'));
		
		$militaryNode = $navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('map'), 'Militär', array('rakuun_navigation_node_map'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('warsim'))
			$militaryNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('warsim'), 'WarSim', array('rakuun_navigation_node_warsim'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('summary'))
			$militaryNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('summary'), 'Zusammenfassung', array('rakuun_navigation_node_summary'));
		
		$allianceNode = $navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('alliance'), 'Allianz', array('rakuun_navigation_node_alliance'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('meta'))
			$allianceNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('meta'), 'Meta', array('rakuun_navigation_node_meta'));
		
		if (Rakuun_Intern_Modules::get()->hasSubmodule('messages'))
			$navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('overview'), 'Nachrichten', array('rakuun_navigation_node_overview'));
		
		$infoNode = $navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('suchen'), 'Infos', array('rakuun_navigation_node_search'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('highscores'))
			$infoNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('highscores'), 'Highscores', array('rakuun_navigation_node_highscores'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('boards'))
			$infoNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('boards'), 'Foren', array('rakuun_navigation_node_boards'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('statistics'))
			$infoNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('statistics'), 'Statistik', array('rakuun_navigation_node_statistics'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('vips'))
			$infoNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('vips'), 'VIPs', array('rakuun_navigation_node_vips'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('profile'))
			$infoNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('profile'), 'Profil', array('rakuun_navigation_node_profile'));
		
		if (Rakuun_Intern_Modules::get()->hasSubmodule('admin')) {
			$adminNode = $navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('admin'), 'Admin', array('rakuun_navigation_node_admin'));
			if (Rakuun_Intern_Modules::get()->hasSubmodule('multihunting'))
				$adminNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('multihunting'), 'Multihunting', array('rakuun_navigation_node_multihunting'));
			if (Rakuun_Intern_Modules::get()->hasSubmodule('support'))
				$adminNode->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('support'), 'Support', array('rakuun_navigation_node_support'));
		}
		
		if (Rakuun_Intern_Modules::get()->hasSubmodule('logout'))
			$navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('logout'), 'Logout', array('rakuun_navigation_node_logout'));
		if (Rakuun_Intern_Modules::get()->hasSubmodule('sitterlogout'))
			$navigation->addModuleNode(Rakuun_Intern_Modules::get()->getSubmoduleByName('sitterlogout'), 'Zu eigenem Account', array('rakuun_navigation_node_logout'));
		
		$this->mainPanel->params->navigation = $navigation;
		if (Rakuun_User_Manager::getCurrentUser()->tutorial)
			$this->mainPanel->addPanel(new Rakuun_GUI_Panel_Box_Collapsible('tutor', new Rakuun_Intern_GUI_Panel_Tutor('tutor'), 'Tutor'));
		
		$this->mainPanel->addPanel(new Rakuun_Intern_GUI_Panel_Ressources_Amount('iron', $this->getUser()->ressources->iron, Rakuun_Intern_Production_Factory::getBuilding('ironmine')->getProducedIron(time() - 1), $this->getUser()->ressources->getCapacityIron(), 'Eisen'));
		$this->mainPanel->addPanel(new Rakuun_Intern_GUI_Panel_Ressources_Amount('beryllium', (int)$this->getUser()->ressources->beryllium , Rakuun_Intern_Production_Factory::getBuilding('berylliummine')->getProducedBeryllium(time() - 1), $this->getUser()->ressources->getCapacityBeryllium(), 'Beryllium'));
		$this->mainPanel->addPanel(new Rakuun_Intern_GUI_Panel_Ressources_Amount('energy', (int)$this->getUser()->ressources->energy, Rakuun_Intern_Production_Factory::getBuilding('hydropower_plant')->getProducedEnergy(time() - 1), $this->getUser()->ressources->getCapacityEnergy(), 'Energie'));
		$this->mainPanel->addPanel(new Rakuun_Intern_GUI_Panel_Ressources_Amount('people', (int)$this->getUser()->ressources->people, Rakuun_Intern_Production_Factory::getBuilding('clonomat')->getProducedPeople(time() - 1), $this->getUser()->ressources->getCapacityPeople(), 'Leute'));
	}
	
	public function afterInit() {
		parent::afterInit();
		
		// add skin-specific css files
		foreach (Rakuun_GUI_Skinmanager::get()->getCssRouteReferences() as $route) {
			$this->addCssRouteReference($route[0], $route[1]);
		}
	}
	
	/**
	 * Shortcut for Rakuun_User_Manager::getCurrentUser()
	 */
	public function getUser() {
		return Rakuun_User_Manager::getCurrentUser();
	}
}

?>