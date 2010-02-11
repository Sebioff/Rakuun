<ul>
<? $gotItems = false; ?>
<? foreach ($this->params->producedItems as $producedItem): ?>
	<? if ($producedItem->getAmount() > 0): ?>
		<li>
			<a href="<?= App::get()->getInternModule()->getSubmodule('info')->getURL(array('type' => $producedItem->getType(), 'id' => $producedItem->getInternalName())); ?>">
				<?= $producedItem->getNameForAmount() ?> (<?= GUI_Panel_Number::formatNumber($producedItem->getAmount()) ?>)
			</a>
		</li>
		<? $gotItems = true; ?>
	<? endif ?>
<? endforeach ?>
<? if (!$gotItems): ?>
	<li>Keine.</li>
<? endif; ?>
</ul>