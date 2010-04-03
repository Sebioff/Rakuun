<?php

abstract class Rakuun_Intern_Quest_Factory {
	public static function getAllQuests() {
		$quests = array();
		$quests[] = new Rakuun_Intern_Quest_FirstCompleteMomo();
		$quests[] = new Rakuun_Intern_Quest_FirstLaboratory10();
		$quests[] = new Rakuun_Intern_Quest_FirstCapturedDatabase();
		return $quests;
	}
}

?>