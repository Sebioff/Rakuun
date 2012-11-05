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

class Rakuun_Intern_Module_Reports extends Rakuun_Intern_Module {
	const SHOW_OWN = 'own';
	const SHOW_ALLIANCE = 'alliance';
	const SHOW_META = 'meta';
	const SHOW_FOR_ALLIANCE = 'foralliance';
	const SHOW_FOR_META = 'formeta';
	
	public function init() {
		parent::init();
		
		$this->setPageTitle('Spionagecenter');
		$this->contentPanel->setTemplate(dirname(__FILE__).'/reports.tpl');
		
		$this->contentPanel->addPanel($detailBox = new Rakuun_GUI_Panel_Box('detailsbox', null, 'Details'));
		
		$user = Rakuun_User_Manager::getCurrentUser();
		$this->contentPanel->addPanel($box = new Rakuun_GUI_Panel_Box('reportsbox', null, 'Berichte'));
		switch ($this->getParam('show')) {
			case self::SHOW_FOR_ALLIANCE:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_ForAlliance('reports', $detailBox));
			break;
			case self::SHOW_FOR_META:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_ForMeta('reports', $detailBox));
			break;
			case self::SHOW_ALLIANCE:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_ByAlliance('reports', $detailBox));
			break;
			case self::SHOW_META:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_ByMeta('reports', $detailBox));
			break;
			case self::SHOW_OWN:
			default:
				$box->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_Own('reports', $detailBox));
			break;
		}
		$this->contentPanel->addPanel($menubox = new Rakuun_GUI_Panel_Box('menubox', null, 'Quelle'));
		$menubox->getContentPanel()->addPanel(new GUI_Control_Link('ownlink', 'Eigene Berichte', $this->getUrl()));
		if ($user->alliance)
			$menubox->getContentPanel()->addPanel(new GUI_Control_Link('alliancelink', '| Berichte der Allianz', $this->getUrl(array('show' => self::SHOW_ALLIANCE))));
		if ($user->alliance && $user->alliance->meta)
			$menubox->getContentPanel()->addPanel(new GUI_Control_Link('metalink', '| Berichte der Meta', $this->getURL(array('show' => self::SHOW_META))));
//		$this->contentPanel->addPanel($filterbox = new Rakuun_GUI_Panel_Box('filterbox', null, 'Filter'));
//		$filterbox->addClasses('rakuun_box_reports_filter');
//		$filterbox->getContentPanel()->addPanel(new Rakuun_Intern_GUI_Panel_Reports_Filter('filter'));
	}
}
?>