<?php

/**
 * Panel to edit alliance details
 */
class Rakuun_Intern_GUI_Panel_Alliance_Edit extends GUI_Panel {
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/edit.tpl');
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->addPanel($description = new GUI_Control_TextArea('description', $user->alliance->description, 'Öffentlicher Beschreibungstext'));
		$description->addValidator(new GUI_Validator_HTML());
		$this->addPanel($intern = new GUI_Control_TextArea('intern', $user->alliance->intern, 'Interner Beschreibungstext'));
		$intern->addValidator(new GUI_Validator_HTML());
		$this->addPanel($picture = new GUI_Control_FileUpload('picture', 102400, 'Profilbild'));
		$picture->setAllowedFiletypes(array(GUI_Control_FileUpload::TYPE_GIF, GUI_Control_FileUpload::TYPE_JPEG, GUI_Control_FileUpload::TYPE_PNG));
		$this->addPanel(new GUI_Control_SubmitButton('submit', 'speichern'));
	}
	
	public function onSubmit() {
		if ($this->hasErrors())
			return;
		
		$alliance = Rakuun_User_Manager::getCurrentUser()->alliance;
		$alliance->description = $this->description;
		$alliance->intern = $this->intern;
		$picture = $this->picture->moveTo('alliance_'.$alliance->name);
		if ($picture) {
			if ($alliance->picture) {
				// remove old picture
				$file = new IO_File($alliance->picture);
				if (!$file->delete())
					$this->addError('Couldn\'t delete old alliance image');
			}
			$image = new IO_Image($picture['path'].DS.$picture['new_name']);
			$image->resize(300, 200);
			$image->save();
			
			$alliance->picture = $picture['path'].DS.$picture['new_name'];
		}
		Rakuun_DB_Containers::getAlliancesContainer()->save($alliance);
		$this->setSuccessMessage('Profil aktualisiert.');
		$this->getModule()->invalidate();
	}
}

?>