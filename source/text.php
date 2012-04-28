<?php

class Rakuun_Text {
	public static final function formatPlayerText($text, $escapeHTML = true) {
		if ($escapeHTML)
			$text = Text::escapeHTML($text);
		if (date('d.m') == '19.09')
			$text = self::yarr($text);
		$text = self::replaceSmileys($text);
		$text = Text::format($text);
		$text = preg_replace_callback('/([@|#])(?=[[:^space:]])[^@<>,]{2,25}(?<=[[:^space:]])\1/U', 'Rakuun_Text::linkPlayerProfiles', $text);
		return $text;
	}
	
	private static function linkPlayerProfiles($match) {
		if (isset($match[0][1]) && $user = Rakuun_DB_Containers::getUserContainer()->selectByNameFirst(substr($match[0], 1, -1))) {
			if ($user->alliance) {
				$allianceLink = new Rakuun_GUI_Control_AllianceLink('', $user->alliance);
				$allianceLink->setDisplay(Rakuun_GUI_Control_AllianceLink::DISPLAY_TAG_ONLY);
				$alliance = $allianceLink->render().' ';
			} else {
				$alliance = '';
			}
			if ($match[0][0] == '@') {
				$userLink = new Rakuun_GUI_Control_UserLink('', $user);
				return $alliance.$userLink->render();
			}
			else {
				$mapLink = new Rakuun_GUI_Control_MapLink('', $user);
				$userLink = new Rakuun_GUI_Control_UserLink('', $user);
				return $mapLink->render().' '.$alliance.$userLink->render();
			}
		}
		
		return $match[0];
	}
	
	private static function replaceSmileys($text) {
		$smileyPath = Router::get()->getStaticRoute('images', '/smileys');
		$replacements = array(
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
		);
		if (date('d.m') == '19.09')
			$replacements = '<img src="'.$smileyPath.'/eyepatch.gif" alt="eyepatch" />';
		return str_replace(self::getSmilieCodes(), $replacements, $text);
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
	
	private static function yarr($text) {
		self::srandom(Text::length($text));
		$words = explode(' ', $text);
		foreach ($words as &$word) {
			if (preg_match('/[<>]+/', $word) === 1)
				continue;
			
			if (self::random(1) == 0) {
				$word = preg_replace('/[r]/', str_repeat('r', 3 + self::random(3)), $word);
			}
			if (self::random(2) == 0) {
				$r = array('\\1', '\\1', '\'', '\\1');
				$word = preg_replace('/([aeio])/', $r[self::random(count($r) - 1)], $word);
			}
			if (Text::toLowerCase($word) == 'ja')
				$word = 'aye';
		}
		$text = implode(' ', $words);
		$text = preg_replace_callback('/([,.!;?]) /', 'Rakuun_Text::yarrHelperrr', $text);
		if (self::random(2) == 0) {
			$cussWords = array('Landratten', 'Leichtmatrosen', 'Seichtwasserpiraten', 'Brackwasserplanscher', 'Küstenschiffer');
			$greetings = array('Yarr!', 'Arrr!', 'Ahoi!', 'Ahoi, ihr '.$cussWords[self::random(count($cussWords) - 1)].'!', 'Moin!', 'Bei Neptuns Bart!');
			$text = $greetings[self::random(count($greetings) - 1)].' '.$text;
		}
		return $text;
	}
	
	private static function yarrHelperrr($text) {
		$sounds = array($text[0], ', yohoho'.$text[0].' ', ', arrr'.$text[0].' ', ', yarr'.$text[0].' ', ', jawoll'.$text[0].' ', ', ho'.$text[0].' ', ', hah'.$text[0].' ', ', aye'.$text[0].' ', ', beim Klabautermann'.$text[0].' ');
		return $sounds[self::random(count($sounds) - 1)];
	}
	
	private static $a;
	
	public static function srandom($seed) {
		self::$a = $seed;
	}
	
	public static function random($max) {
		self::$a = (self::$a * 32719 + 3) % 32749;
		return (self::$a % ($max + 1));
	}
}