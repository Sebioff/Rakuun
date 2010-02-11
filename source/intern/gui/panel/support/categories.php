<?php

/**
 * Panel displaying all message categories
 */
class Rakuun_Intern_GUI_Panel_Support_Categories extends GUI_Panel {
	const CATEGORY_ANSWERED = 'answered';
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/categories.tpl');
		$this->addClasses('rakuun_messages_categories');
		
		$categoryLinks = array();
		foreach (Rakuun_Intern_Support_Ticket::getMessageTypes() as $messageType => $messageTypeName) {
			$options = array();
			$options['conditions'][] = array('is_answered = ?', false);
			$options['conditions'][] = array('type = ?', $messageType);
			$ticketCount = Rakuun_DB_Containers::getSupportticketsContainer()->count($options);
			$url = App::get()->getInternModule()->getSubmodule('support')->getUrl(array('category' => $messageType));
			$this->addPanel($categoryLink = new GUI_Control_Link($messageType, $messageTypeName.' ('.$ticketCount.')', $url));
			$categoryLinks[] = $categoryLink;
		}
		$messageCount = Rakuun_DB_Containers::getSupportticketsContainer()->count(self::getOptionsForCategory(self::CATEGORY_ANSWERED));
		$this->addPanel($answeredLink = new GUI_Control_Link('answered', self::getNameForCategory(self::CATEGORY_ANSWERED).' ('.$messageCount.')', App::get()->getInternModule()->getSubmodule('support')->getUrl(array('category' => self::CATEGORY_ANSWERED))));
		$categoryLinks[] = $answeredLink;
		$this->params->categoryLinks = $categoryLinks;
	}
	
	public static function getOptionsForCategory($category) {
		$options = array();
		if ($category == Rakuun_Intern_GUI_Panel_Support_Categories::CATEGORY_ANSWERED) {
			$options['conditions'][] = array('is_answered = ?', true);
		}
		
		return $options;
	}
	
	public static function getNameForCategory($category) {
		if ($category == Rakuun_Intern_GUI_Panel_Support_Categories::CATEGORY_ANSWERED) {
			return 'geschlossene Supporttickets';
		}
		else {
			$messageTypes = Rakuun_Intern_IGM::getMessageTypes();
			return $messageTypes[$category];
		}
	}
}

?>