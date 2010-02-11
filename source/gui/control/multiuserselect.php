<?php

class Rakuun_GUI_Control_MultiUserSelect extends Rakuun_GUI_Control_UserSelect {
	protected function generateJS() {
		return sprintf('$("#%s").autocomplete("%s", {width: 260, autoFill: true, multiple: true, max: 10});', $this->getID(), App::get()->getUserSelectScriptletModule()->getURL());
	}
	
	protected function validation() {
		if ($this->getValue()) {
			$recipients = explode(',', $this->getValue());
			foreach ($recipients as $recipient) {
				$recipient = trim($recipient);
				if (strlen($recipient) > 0
					&& !Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($recipient)
				)
					return 'Spieler existiert nicht: '.$recipient;
			}
		}
	}
	
	/**
	 * @return Rakuun_DB_User
	 */
	public function getUser() {
		$users = array();
		
		if ($this->getValue()) {
			$recipients = explode(',', $this->getValue());
			$recipients = array_map('trim', $recipients);
			$recipients = array_unique($recipients);
			foreach ($recipients as $recipient) {
				if ($user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst($recipient))
					$users[] = $user;
			}
		}
		return $users;
	}
}

?>