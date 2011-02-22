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
		return str_replace(array(
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
		), array(
			'<img src="'.$smileyPath.'/artist.gif">',
			'<img src="'.$smileyPath.'/cry.gif">',
			'<img src="'.$smileyPath.'/dizzy.gif">',
			'<img src="'.$smileyPath.'/eyepatch.gif">',
			'<img src="'.$smileyPath.'/happy.gif">',
			'<img src="'.$smileyPath.'/ape.gif">',
			'<img src="'.$smileyPath.'/frown.gif">',
			'<img src="'.$smileyPath.'/cool.gif">',
			'<img src="'.$smileyPath.'/happy2.gif">',
			'<img src="'.$smileyPath.'/mad.gif">',
			'<img src="'.$smileyPath.'/nono.gif">',
			'<img src="'.$smileyPath.'/oh.gif">',
			'<img src="'.$smileyPath.'/sad.gif">',
			'<img src="'.$smileyPath.'/sick.gif">',
			'<img src="'.$smileyPath.'/tongue.gif">',
			'<img src="'.$smileyPath.'/uuh.gif">',
			'<img src="'.$smileyPath.'/wacko.gif">',
			'<img src="'.$smileyPath.'/zwinker.gif">',
			'<img src="'.$smileyPath.'/elk.gif">',
			'<img src="'.$smileyPath.'/xd.gif">'
		), $text);
	}
}