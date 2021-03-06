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

/**
 * Panel to edit meta details
 */
class Rakuun_Intern_GUI_Panel_Meta_Edit extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/edit.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addPanel($description = new GUI_Control_TextArea('description', $user->alliance->meta->description, 'Öffentlicher Beschreibungstext'));
		$description->addValidator(new GUI_Validator_HTML());
		$this->addPanel($intern = new GUI_Control_TextArea('intern', $user->alliance->meta->intern, 'Interner Beschreibungstext'));
		$intern->addValidator(new GUI_Validator_HTML());
		$this->addPanel($picture = new GUI_Control_FileUpload('picture', 102400, 'Metabild'));
		$picture->setAllowedFiletypes(array(GUI_Control_FileUpload::TYPE_GIF, GUI_Control_FileUpload::TYPE_JPEG, GUI_Control_FileUpload::TYPE_PNG));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'speichern'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
			
		$meta = Rakuun_User_Manager::getCurrentUser()->alliance->meta;
		$meta->description = $this->description;
		$meta->intern = $this->intern;
		$picture = $this->picture->moveTo('meta_'.$meta->name);
		if ($picture) {
			if ($meta->picture) {
				// remove old picture
				$file = new IO_File($meta->picture);
				if (!$file->delete())
					$this->addError('Couldn\'t delete old meta image');
			}
			$image = new IO_Image($picture['path'].DIRECTORY_SEPARATOR.$picture['new_name']);
			$image->resize(300, 200);
			$image->save();
			
			$meta->picture = $picture['path'].DIRECTORY_SEPARATOR.$picture['new_name'];
		}
		Rakuun_DB_Containers::getMetasContainer()->save($meta);
		$this->getModule()->invalidate();
		 
	}
}

?>