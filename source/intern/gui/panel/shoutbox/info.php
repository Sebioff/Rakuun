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

class Rakuun_Intern_GUI_Panel_Shoutbox_Info extends GUI_Panel {
	private $shoutarea = null;
	
	public function __construct($name, GUI_Control_TextArea $area, $title = '') {
		parent::__construct($name, $title);
		
		$this->shoutarea = $area;
	}
	
	public function init() {
		parent::init();
		
		$this->setTemplate(dirname(__FILE__).'/info.tpl');
		$this->addClasses('rakuun_gui_infopanel');
		$this->addClasses('cursor_pointer');
		
		$this->addJS("
			$('#".$this->getID()."').click(function() {
				$('#".$this->getID()."_hover').slideToggle('slow', 'linear');
			});
			function shoutboxInfoText(text) {
				$('#".$this->shoutarea->getID()."').val($('#".$this->shoutarea->getID()."').val() + ' ' + jQuery.trim(text));
				shoutboxCountCharactersDown();
				$('#".$this->getID()."').click();
			}
			$('#".$this->getID()."_hover dl dt').click(function() { shoutboxInfoText($(this).html()) });
			$('#".$this->getID()."_hover dl dd').click(function() { shoutboxInfoText($(this).prev().html()) });
		");
		
		$this->params->links = array(
			'@nickname@' => 'Profillink \'nickname\'',
			'#nickname#' => 'Maplink \'nickname\''
		);
		
		$smilies = array();
		foreach (Rakuun_Text::getSmilieCodes() as $smilie) {
			$smilies[$smilie] = Rakuun_Text::formatPlayerText($smilie);
		}
		$this->params->smilies = $smilies;
	}
}
?>