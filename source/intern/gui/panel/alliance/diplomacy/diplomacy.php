<?php

/**
 * Parent class to actives, newoffer and offers to provide some constants.
 */
class Rakuun_Intern_GUI_Panel_Alliance_Diplomacy extends GUI_Panel {
	//TODO: delete records marked as 'STATUS_DELETED' from database after 'notice' hours
	const RELATION_AUVB = 0;
	const RELATION_NAP = 1;
	const RELATION_WAR = 2;
	
	const STATUS_NEW = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_DELETED = 2;
}
?>