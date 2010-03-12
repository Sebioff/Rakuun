<style type="text/css">
	.rakuun_city {
		height:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
		width:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
	}
</style>

<? $this->displayPanel('scroll_up'); ?>
<? $this->displayPanel('scroll_left'); ?>


<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
	<?= $this->getMapLayer(); ?>
	<? $this->displayPanel('path'); ?>
	<? if ($this->getCityX() || $this->getCityY()): ?>
		<div id="rakuun_map_indicator" class="scrolling_item" style="left:<?= ($this->realToViewPositionX($this->getCityX()) - 2); ?>px;top:<?= ($this->realToViewPositionY($this->getCityY()) - 2); ?>px;"></div>
	<? endif; ?>
	<? $this->displayPanel('items'); ?>
</div>


<? $this->displayPanel('scroll_right'); ?>
<? $this->displayPanel('legend'); ?>
<br class="clear" />
<? $this->displayPanel('scroll_down'); ?>
<br class="clear" />
<? $this->displayPanel('target'); ?>