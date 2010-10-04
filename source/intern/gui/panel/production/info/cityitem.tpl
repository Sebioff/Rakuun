<?= $this->getProductionItem()->getLongDescription(); ?>
<br/>
<? foreach($this->getProductionItem()->getAttributes() as $attributeProperties): ?>
	<? if($attributeProperties['value'] == true): ?>
		<?= $attributeProperties['description']; ?>
		<br/>
	<? endif; ?>
<? endforeach; ?>
<br/>
Punkte / Stufe: <?= $this->getProductionItem()->getPoints(); ?>
<br/>
<h3>Kosten</h3>
<? $this->displayPanel('costs'); ?>