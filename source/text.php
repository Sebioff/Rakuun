<?php

class Rakuun_Text {
	// TODO merge smilies in here
	public static final function formatPlayerText($text, $escapeHTML = true) {
		if ($escapeHTML)
			$text = Text::escapeHTML($text);
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
}