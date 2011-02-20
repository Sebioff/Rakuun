<?= $this->getProductionItem()->getLongDescription(); ?>
<br/>
<br/>
<? if ($this->getProductionItem()->getEffects()): ?>
	<h3>Effekte</h3>
	<ul>
		<? foreach ($this->getProductionItem()->getEffects() as $effect): ?>
			<li><?= $effect; ?></li>
		<? endforeach; ?>
	</ul>
	<br/>
<? endif; ?>
<? if ($this->getProductionItem()->getAttributes()): ?>
	<h3>Eigenschaften</h3>
	<ul>
		<? foreach ($this->getProductionItem()->getAttributes() as $attributeProperties): ?>
			<? if ($attributeProperties['value'] == true): ?>
				<li><?= $attributeProperties['description']; ?></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
	<br/>
<? endif; ?>
Punkte / Stufe: <?= $this->getProductionItem()->getPoints(); ?>
<br/>
<h3>Kosten</h3>
<? $this->displayPanel('costs'); ?>