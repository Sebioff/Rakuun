<?php

class Rakuun_Intern_Modules extends Rakuun_Module {
	private static $instance = null;
	
	public function onConstruct() {
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addSubmodule(new Rakuun_Intern_Module_Overview('overview'));
		$this->addSubmodule(new Rakuun_Intern_Module_Build('build'));
		$this->addSubmodule(new Rakuun_Intern_Module_Produce('produce'));
		$this->addSubmodule(new Rakuun_Intern_Module_Research('research'));
		$this->addSubmodule(new Rakuun_Intern_Module_Techtree('techtree'));
		$this->addSubmodule(new Rakuun_Intern_Module_Ressources('ressources'));
		$this->addSubmodule(new Rakuun_Intern_Module_Search('suchen'));
		$this->addSubmodule(new Rakuun_Intern_Module_Highscores('highscores'));
		$this->addSubmodule(new Rakuun_Intern_Module_Info('info'));
		$this->addSubmodule(new Rakuun_Intern_Module_ShowProfile('showprofile'));
		$this->addSubmodule(new Rakuun_Intern_Module_BotProtection('botprotection'));
		$this->addSubmodule(new Rakuun_Intern_Module_Summary('summary'));
		$this->addSubmodule(new Rakuun_Intern_Module_Alliance_View('allianceview'));
		$this->addSubmodule(new Rakuun_Intern_Module_Meta_View('metaview'));
		
		// modules that aren't accessible by sitter
		if (!Rakuun_User_Manager::isSitting()) {
			if ($user) {
				if ($user->buildings->moleculartransmitter > 0 && Rakuun_GameSecurity::get()->hasPrivilege($user, Rakuun_GameSecurity::PRIVILEGE_USE_MOLECULARTRANSMITTER))
					$this->addSubmodule(new Rakuun_Intern_Module_Trade('trade'));

				if ($user->alliance != null) {
					$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Profile_Own('alliance'));
					$this->addSubmodule(new Rakuun_Intern_Module_Meta('meta'));
				} else {
					$this->addSubmodule(new Rakuun_Intern_Module_Alliance_Profile_None('alliance'));
				}
			}
				
			$this->addSubmodule(new Rakuun_Intern_Module_FightDetails('fightdetails'));
			$this->addSubmodule(new Rakuun_Intern_Module_Map('map'));
			$this->addSubmodule(new Rakuun_Intern_Module_Messages('messages'));
			$this->addSubmodule(new Rakuun_Intern_Module_Profile('profile'));
			$this->addSubmodule(new Rakuun_Intern_Module_Warsim('warsim'));
			$this->addSubmodule(new Rakuun_Intern_Module_VIPs('vips'));
			$this->addSubmodule(new Rakuun_Intern_Module_Statistics('statistics'));
			$this->addSubmodule(new Rakuun_Intern_Module_Admin('admin'));
			$this->addSubmodule(new Rakuun_Intern_Module_Multihunting('multihunting'));
			$this->addSubmodule(new Rakuun_Intern_Module_Support('support'));
			$this->addSubmodule(new Rakuun_Intern_Module_Logout('logout'));
			$this->addSubmodule(new Rakuun_Intern_Module_Boards('boards'));
			if ($user && $user->buildings->stockMarket > 0)
				$this->addSubmodule(new Rakuun_Intern_Module_StockMarket('stockmarket'));
		}
		// modules that are only accessible by sitter
		else {
			$this->addSubmodule(new Rakuun_Intern_Module_LogoutSitter('sitterlogout'));
		}
	}
	
	public function init() {
		$this->redirect($this->getSubmoduleByName('overview')->getUrl());
	}
	
	public static function get() {
		return (self::$instance) ? self::$instance : self::$instance = new self('intern');
	}
}

?>