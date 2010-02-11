<?php

class Rakuun_Intern_GUI_Panel_Admin_Logs extends GUI_Panel {
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/logs.tpl');
		
		$this->addPanel(new GUI_Control_DropDownBox('logfiles', IO_Utils::getFilesFromFolder(IO_Log::getLogfilePath(), array(IO_Log::LOGFILE_EXTENSION)), null, 'Logfiles'));
		$this->addPanel(new GUI_Control_SubmitButton('show', 'Anzeigen'));
		$this->addPanel($logfileContent = new GUI_Control_TextArea('logfile_content', '', 'Inhalt'));
		$logfileContent->setAttribute('rows', 20);
		$logfileContent->setAttribute('cols', 100);
	}
	
	public function afterInit() {
		parent::afterInit();
		
		$this->logfiles->addJS(
			sprintf(
				'
				$("#%s").change(
					function() {
						$("#%s").click();
					}
				);
				',
				$this->logfiles->getID(), $this->show->getID()
			)
		);
	}
	
	public function onShow() {
		$logfile = new IO_File(IO_Log::getLogfilePath().'/'.$this->logfiles->getValue());
		$logfile->open();
		$this->logfileContent->setValue($logfile->read());
	}
}

?>