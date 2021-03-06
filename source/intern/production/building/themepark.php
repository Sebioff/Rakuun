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

class Rakuun_Intern_Production_Building_Themepark extends Rakuun_Intern_Production_Building {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('themepark');
		$this->setName('Freizeitpark');
		$this->setBaseIronCosts(480);
		$this->setBaseBerylliumCosts(320);
		$this->setBasePeopleCosts(24);
		$this->setBaseTimeCosts(4*60);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Baue Freizeitparks, damit deine Bürger zufrieden mit dir sind.');
		$this->setLongDescription('Freizeitparks heben die Moral der arbeitslosen Bevölkerung, denn ganz nach der Devise "Wer arbeitet ist glücklich", ist der nicht arbeitende Bevölkerungsteil unglücklich.
			<br/>
			Wenn Freizeitparks überfüllt sind, senkt sich schnell der Spassfaktor und die Leute denken eher darüber nach, bewaffnet gegen die Regierung vorzugehen.
			<br/>
			Freizeitparks sind vollgestopft mit modernster Unterhaltungstechnologie.
			<br/>
			Von Cyber-3D Räumen bis hin zu Anti-G Diskos ist alles vertreten, auch wenn sich viele Eltern wünschen, es gäbe weniger Stände mit fetthaltigem und gezuckertem Essen.
			<br/>
			In dieser zum Teil virtuellen Umgebung kann man seine Sinne völlig verwirren und entspannen während man Massagen im gravitationslosen Flug durch eine Wand aus Dampf geniesst oder in virtuellen Welten gegen andere Besucher agiert.
			<br/>
			Durch den hier erzeugten Stimmungseffekt scheint die lange Arbeitslosigkeit in eine lang vergangene Zeit zurückzufallen, sodass sich die Arbeiter in Ruhe mit doppeltem Schwung wieder an die Arbeit machen können.');
		$this->setPoints(12);
	}
	
	protected function defineEffects() {
		$futureLevel = $this->getLevel() + $this->getFutureLevels();
		$this->addEffect('Zufriedenstellung von insgesamt '.Text::formatNumber($this->getSatisfiedPeopleAmount($futureLevel + 1)).' Leuten (vorher: '.Text::formatNumber($this->getSatisfiedPeopleAmount($futureLevel)).')');
	}
	
	private function getSatisfiedPeopleAmount($level) {
		return $level * Rakuun_Intern_Production_Influences::THEMEPARK_SATISFACTION_NORMAL * RAKUUN_SPEED_SATISFACTION_MULTIPLIER;
	}
}

?>