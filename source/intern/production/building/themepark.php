<?php

class Rakuun_Intern_Production_Building_Themepark extends Rakuun_Intern_Production_Building {
	public function __construct(DB_Record $dataSource = null) {
		parent::__construct($dataSource);
		
		$this->setInternalName('themepark');
		$this->setName('Freizeitpark');
		$this->setBaseIronCosts(600);
		$this->setBaseBerylliumCosts(400);
		$this->setBasePeopleCosts(30);
		$this->setBaseTimeCosts(10*60);
		$this->setMinimumLevel(1);
		$this->setShortDescription('Baue Freizeitparks, damit deine Bürger zufrieden mit dir sind.');
		$this->setLongDescription('Freizeitparks heben die Moral der Bevölkerung.
			<br/>
			Wenn Freizeitparks überfüllt sind, senkt sich schnell der Spassfaktor und die Leute denken eher darüber nach, bewaffnet gegen die Regierung vorzugehen.
			<br/>
			Freizeitparks sind vollgestopft mit modernster Unterhaltungstechnologie.
			<br/>
			Von Cyber-3D Räumen bis hin zu Anti-G Diskos ist alles vertreten, auch wenn sich viele Eltern wünschen, es gäbe weniger Stände mit fetthaltigem und gezuckertem Essen.
			<br/>
			In dieser zum Teil virtuellen Umgebung kann man seine Sinne völlig verwirren und entspannen während man Massagen im gravitationslosen Flug durch eine Wand aus Dampf geniesst oder in virtuellen Welten gegen andere Besucher agiert.
			<br/>
			Durch den hier erzeugten Stimmungseffekt scheinen die langen Arbeitsstunden in den Minen in eine lang vergangene Zeit zurückzufallen, sodass man sich mit doppeltem Schwung wieder an die Arbeit machen kann.');
		$this->setPoints(12);
	}
}

?>