<?php

class Rakuun_Intern_Alliance_History {
	const TYPE_APPLICATION = 0;
	const TYPE_ACCEPTED = 1;
	const TYPE_UNACCEPTED = 2;
	const TYPE_KICK = 3;
	const TYPE_INVITATION = 4;
	const TYPE_LEAVE = 5;
	const TYPE_JOIN = 6;
	const TYPE_FOUND = 7;
	
	public function __construct(Rakuun_DB_User $user, $alliancename, $type) {
		$this->user = $user;
		$this->allianceName = $alliancename;
		$this->type = $type;
		$this->date = time();
	}
	
	public function save() {
		$record = new DB_Record();
		$record->user = $this->user;
		$record->allianceName = $this->allianceName;
		$record->type = $this->type;
		$record->date = $this->date;
		Rakuun_DB_Containers::getAllianceHistoryContainer()->save($record);
	}
	
	public static function getMessageTypes() {
		return array(
			self::TYPE_APPLICATION => 'Bewerbung',
			self::TYPE_ACCEPTED => 'Bewerbung angenommen',
			self::TYPE_UNACCEPTED => 'Bewerbung abgelehnt',
			self::TYPE_KICK => 'Rauswurf',
			self::TYPE_INVITATION => 'Einladung',
			self::TYPE_LEAVE => 'Austritt',
			self::TYPE_JOIN => 'Beitritt',
			self::TYPE_FOUND => 'Gründung'
		);
	}
}

?>