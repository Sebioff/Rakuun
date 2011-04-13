<?php

/**
 * @property Rakuun_DB_User $user
 */
class Rakuun_DB_CityItems extends DB_Record {
	/**
	 * Lowers the item level.
	 */
	public function lower($internalName, Rakuun_DB_User $destroyer, $deltaLevel = 1) {
		$escapedInternalName = DB_Container::escape($internalName);
		$databaseSchema = $this->getContainer()->getDatabaseSchema();
		$query = 'UPDATE '.$this->getContainer()->getTable().' SET
			`'.$escapedInternalName.'` = `'.$escapedInternalName.'` - '.$deltaLevel.'
			WHERE '.$databaseSchema['primaryKey'].' = '.$this->getPK();
		if ($this->getContainer()->update($query, $this) === true) {
			$this->{Text::underscoreToCamelCase($internalName)} -= $deltaLevel;
			$this->user->recalculatePoints();
		}
	}
	
	/**
	 * Raises item level.
	 */
	public function raise($internalName, $deltaLevel = 1) {
		$escapedInternalName = DB_Container::escape($internalName);
		$databaseSchema = $this->getContainer()->getDatabaseSchema();
		$query = 'UPDATE '.$this->getContainer()->getTable().' SET
			`'.$escapedInternalName.'` = `'.$escapedInternalName.'` + '.$deltaLevel.'
			WHERE '.$databaseSchema['primaryKey'].' = '.$this->getPK();
		if ($this->getContainer()->update($query, $this) === true) {
			$this->{Text::underscoreToCamelCase($internalName)} += $deltaLevel;
			$this->user->recalculatePoints();
		}
	}
}

?>