<?php

abstract class Rakuun_Intern_Skills_Skill {
	const SKILL_ECONOMY = 1;
	
	protected $identifier = null;
	protected $user = null;
	
	/**
	 * @param $user the user who gets the special
	 * @param $identifier what special is this? (see self::SKILL_*)
	 */
	public function __construct(Rakuun_DB_User $user, $identifier) {
		$this->user = $user;
		$this->identifier = $identifier;
	}
	
	public function getSkillLevel() {
				
	}
	
	public function getEffect() {
		
	}
	
}

?>