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

class Rakuun_Index_Module_News extends Rakuun_Index_Module {
	public function init() {
		parent::init();
		
		$this->setPageTitle('News');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/news.tpl');
		$this->setMetaTag('description', 'Neuigkeiten über das kostenlose SciFi-Browsergames Rakuun.');
		$this->setMetaTag('keywords', 'browsergame, scifi, news');
		
		$this->contentPanel->addPanel($newsBox = new Rakuun_Index_Panel_News_Overview('news', 'News'));
		$newsBox->addClasses('rakuun_box_news');
		
		if ($logoutReason = $this->getParam('logout-reason')) {
			$this->contentPanel->addPanel(new Rakuun_GUI_Panel_Box_Note('logout_reason', $logoutReasonText = new GUI_Panel_Text('logout_reason', '', 'Ausgeloggt'), 'Ausgeloggt'));
			switch ($logoutReason) {
				case 'noactivity':
					$logoutReasonText->setText('Du wurdest sicherheitshalber automatisch ausgeloggt, da du für mindestens '.Rakuun_Date::formatCountDown(Rakuun_Intern_Module::TIMEOUT_NOACTIVITY).' keine Aktionen durchgeführt hast.');
				break;
			}
		}
	}
}

?>