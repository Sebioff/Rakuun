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
	<? $this->displayPanel('items'); ?>
</div>


<? $this->displayPanel('scroll_right'); ?>
<? $this->displayPanel('legend'); ?>
<br class="clear" />
<? $this->displayPanel('scroll_down'); ?>
<br class="clear" />
<? $this->displayPanel('target'); ?>