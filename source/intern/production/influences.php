<?php

/**
 * Provides methods to calculate influences on production.
 */
class Rakuun_Intern_Production_Influences {
	const RESSOURCE_IRON = 1;
	const RESSOURCE_BERYLLIUM = 2;
	const RESSOURCE_ENERGY = 3;
	const RESSOURCE_PEOPLE = 4;
	
	public static function getRessourceProductionInfluenceRate($ressourceType, Rakuun_DB_User $user = null) {
		if ($user === null)
			$user = Rakuun_User_Manager::getCurrentUser();
		
		$rate = 1;
		$rate *= self::getPeopleSatisfactionRate($user);
		if ($ressourceType == self::RESSOURCE_IRON || $ressourceType == self::RESSOURCE_BERYLLIUM) {
			$ressourceProductionDatabase = new Rakuun_User_Specials_Database($user, Rakuun_User_Specials::SPECIAL_DATABASE_BROWN);
			if ($ressourceProductionDatabase->hasSpecial())
				$rate *= 1.1;
		}
		
		return $rate;
	}
	
	/**
	 * @return float index indicating how much the people like the given user
	 */
	public static function getPeopleSatisfaction(Rakuun_DB_User $user = null) {
		if ($user === null)
			$user = Rakuun_User_Manager::getCurrentUser();
		
		// TODO: add massacre people
		return $user->ressources->people / Rakuun_Intern_Production_Factory::getBuilding('themepark', $user)->getLevel();
	}
	
	/**
	 * @return int normed index
	 */
	public static function getPeopleSatisfactionRate(Rakuun_DB_User $user = null) {
		if ($user === null)
			$user = Rakuun_User_Manager::getCurrentUser();
		
		$satisfaction = self::getPeopleSatisfaction($user) / RAKUUN_SPEED_SATISFACTION_MULTIPLIER;
		if ($satisfaction >= 1250) {
			return 0.85;
		}
		else if ($satisfaction >= 1000){
			return 0.9;
		}
		else if ($satisfaction >= 750){
			return 0.95;
		}
		else if ($satisfaction >= 500){
			return 1;
		}
		else if ($satisfaction >= 250){
			return 1.05;
		}
		else {
			return 1.1;
		}
	}
	
	public static function getPeopleSatisfactionText(Rakuun_DB_User $user = null) {
		if ($user === null)
			$user = Rakuun_User_Manager::getCurrentUser();
		
		switch (self::getPeopleSatisfactionRate($user)) {
			case 0.85:
				return 'Deine Bürger hassen dich';
			case 0.9:
				return 'Deine Bürger finden dich schlecht';
			case 0.95:
				return 'Deine Bürger finden dich nicht so gut';
			case 1:
				return 'Deine Bürger finden dich mittelmäßig';
			case 1.05:
				return 'Deine Bürger finden dich gut';
			case 1.1:
				return 'Deine Bürger verehren dich';
		}
	}
}

?>