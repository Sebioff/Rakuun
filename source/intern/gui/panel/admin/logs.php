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