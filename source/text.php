<?php

class Rakuun_Text {
	public static final function formatPlayerText($text, $escapeHTML = true) {
		if ($escapeHTML)
			$text = Text::escapeHTML($text);
		$text = self::replaceSmileys($text);
		$text = Text::format($text);
		$text = preg_replace_callback('/([@|#])(?=[[:^space:]])[^@<>,]{2,25}(?<=[[:^space:]])\1/U', 'Rakuun_Text::linkPlayerProfiles', $text);
		return $text;
	}
	
	private static function linkPlayerProfiles($match) {
		if (isset($match[0][1]) && $user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst(substr($match[0], 1, -1))) {
			if ($match[0][0] == '@') {
				$userLink = new Rakuun_GUI_Control_UserLink('', $user);
				return $userLink->render();
			}
			else {
				$mapLink = new Rakuun_GUI_Control_MapLink('', $user);
				$userLink = new Rakuun_GUI_Control_UserLink('', $user);
				return $mapLink->render().' ('.$userLink->render().')';
			}
		}
		
		return $match[0];
	}
	
	private static function replaceSmileys($text) {
		$smileyPath = Router::get()->getStaticRoute('images', '/smileys');
		return str_replace(self::getSmilieCodes(), array(
			'<img src="'.$smileyPath.'/artist.gif" alt="artist" />',
			'<img src="'.$smileyPath.'/cry.gif" alt="cry" />',
			'<img src="'.$smileyPath.'/dizzy.gif" alt="dizzy" />',
			'<img src="'.$smileyPath.'/eyepatch.gif" alt="eyepatch" />',
			'<img src="'.$smileyPath.'/happy.gif" alt="happy" />',
			'<img src="'.$smileyPath.'/ape.gif" alt="ape" />',
			'<img src="'.$smileyPath.'/frown.gif" alt="frown" />',
			'<img src="'.$smileyPath.'/cool.gif" alt="cool" />',
			'<img src="'.$smileyPath.'/happy2.gif" alt="happy2" />',
			'<img src="'.$smileyPath.'/mad.gif" alt="mad" />',
			'<img src="'.$smileyPath.'/nono.gif" alt="nono" />',
			'<img src="'.$smileyPath.'/oh.gif" alt="oh" />',
			'<img src="'.$smileyPath.'/sad.gif" alt="sad" />',
			'<img src="'.$smileyPath.'/sick.gif" alt="sick" />',
			'<img src="'.$smileyPath.'/tongue.gif" alt="tongue" />',
			'<img src="'.$smileyPath.'/uuh.gif" alt="uuh" />',
			'<img src="'.$smileyPath.'/wacko.gif" alt="wacko" />',
			'<img src="'.$smileyPath.'/zwinker.gif" alt="zwinker" />',
			'<img src="'.$smileyPath.'/elk.gif" alt="elk" />',
			'<img src="'.$smileyPath.'/xd.gif" alt="xd" />'
		), $text);
	}
	
	public static function getSmilieCodes() {
		return array(
			':artist:',
			':cry:',
			':dizzy:',
			':eyepatch:',
			':)',
			':(|)',
			':(',
			'8)',
			':D',
			':mad:',
			':nono:',
			':o',
			':sad:',
			':sick:',
			':P',
			':uuh:',
			':wacko:',
			';)',
			':elk:',
			'xD'
		);
	}
}