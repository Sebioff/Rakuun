<?php

/**
 * Base class for additional requirements
 */
abstract class Rakuun_Intern_Production_Requirement_Base implements Rakuun_Intern_Production_Requirement {
	private $productionItem = null;
	
	public function setProductionItem(Rakuun_Intern_Production_Base $productionItem) {
		$this->productionItem = $productionItem;
	}
	
	/**
	 * @return Rakuun_Intern_Production_Base
	 */
	public function getProductionItem() {
		return $this->productionItem;
	}
}

?>