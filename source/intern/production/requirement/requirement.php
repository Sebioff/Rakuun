<?php

/**
 * Base class for additional requirements
 */
interface Rakuun_Intern_Production_Requirement {
	public function getDescription();
	public function fulfilled();
}

?>