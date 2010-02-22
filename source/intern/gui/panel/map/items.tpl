<map name="items_descriptions">
	<? foreach ($this->getScrollItems() as $scrollItem): ?>
		<? $scrollItem->display(); ?>
	<? endforeach; ?>
</map>
<img alt="Städte" <?= $this->getAttributeString() ?> id="rakuun_map_scroll_items" usemap="#items_descriptions"/>