<?php

/**
 * A Module for displaying the imprint and donations introductions
 * @author Sebioff
 */
class Rakuun_Intern_Module_Imprint extends Rakuun_Intern_Module {
	public function init() {
		parent::init();
			
		$this->setPageTitle('Spenden/Impressum');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/imprint.tpl');
		
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('donation', new Rakuun_Intern_GUI_Panel_Imprint_Donation('donation'), 'Spenden'));
		$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box('imprint', new Rakuun_Intern_GUI_Panel_Imprint('imprint'), 'Impressum'));
	}
}

?>