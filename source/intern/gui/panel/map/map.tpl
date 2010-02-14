<style type="text/css">
	.scroll_item {
		height:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
		width:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
	}
</style>

<? $this->displayPanel('scroll_up'); ?>
<? $this->displayPanel('scroll_left'); ?>

<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
	<?= $this->getMapLayer(); ?>
	<? $this->displayPanel('path'); ?>
	<div id="rakuun_map_scroll_panels" style="position:absolute;left:<?= (-$this->getViewRectX() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE); ?>px;top:<?= (-$this->getViewRectY() * Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE); ?>px">
		<? foreach ($this->getScrollItems() as $scrollItem): ?>
			<? $scrollItem->display(); ?>
		<? endforeach; ?>
	</div>
</div>

<? $this->displayPanel('scroll_right'); ?>
<? $this->displayPanel('legend'); ?>
<br class="clear" />
<? $this->displayPanel('scroll_down'); ?>
<br class="clear" />
<? $this->displayPanel('target'); ?>