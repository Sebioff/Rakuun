<?php

class Rakuun_DB_Army extends DB_Record {
	/**
	 * Makes the army calculate a path home
	 */
	public function moveHome() {
		Rakuun_DB_Containers::getArmiesPathsContainer()->deleteByArmy($this);
		$this->targetX = $this->user->cityX;
		$this->targetY = $this->user->cityY;
		$this->tick = time();
		$this->targetTime = 0;
		$pathCalculator = new Rakuun_Intern_Map_ArmyPathCalculator($this);
		$pathCalculator->getPath();
		$this->save();
	}
	
	public function canTransportDatabase() {
		$attackPower = 0;
		foreach (Rakuun_Intern_Production_Factory::getAllUnits($this) as $unit) {
			$attackPower += $unit->getAttackValue();
			if ($attackPower >= 1000)
				return true;
		}
		return false;
	}
}

?>