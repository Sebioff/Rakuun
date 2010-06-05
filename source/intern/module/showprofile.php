<?php

/**
 * Show the public Profile of a User
 * @author dr.dent
 */
class Rakuun_Intern_Module_ShowProfile extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('Profil anzeigen');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/showprofile.tpl');
		
		$param = $this->getParam('user');
		$user = Rakuun_DB_Containers::getUserContainer()->selectByPK($param);
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('showprofile', new Rakuun_Intern_GUI_Panel_User_ShowProfile('showprofile', $user), 'Profil'));
		if ($user->getPK() != Rakuun_User_Manager::getCurrentUser()->getPK()) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('armybox', new Rakuun_Intern_GUI_Panel_User_Reports_Army('army', $user), 'Einheitenübersicht'));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('buildingsbox', new Rakuun_Intern_GUI_Panel_User_Reports_Buildings('buildings', $user), 'Gebäudeübersicht'));
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('reportsbox', new Rakuun_Intern_GUI_Panel_User_Reports_View('reports', $user), 'Berichteübersicht'));
		}
	}
}

?>