<style type="text/css">
	.rakuun_city {
		height:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
		width:<?= Rakuun_Intern_GUI_Panel_Map::MAP_RECT_SIZE; ?>px;
	}
</style>

<div id="ctn_map">
	<? $this->displayPanel('scroll_up'); ?>
	<? $this->displayPanel('scroll_left'); ?>
	
	
	<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
		<?= $this->getMapLayer(); ?>
		<? $this->displayPanel('path'); ?>
		<? if ($this->getCityX() || $this->getCityY()): ?>
			<? $indicatorX = $this->getCityX(); ?>
			<? $indicatorY = $this->getCityY(); ?>
		<? else: ?>
			<? $indicatorX = Rakuun_User_Manager::getCurrentUser()->cityX; ?>
			<? $indicatorY = Rakuun_User_Manager::getCurrentUser()->cityY; ?>
		<? endif; ?>
		<div id="rakuun_map_indicator" class="scrolling_item" style="left:<?= ($this->realToViewPositionX($indicatorX) - 2); ?>px;top:<?= ($this->realToViewPositionY($indicatorY) - 2); ?>px;"></div>
		<? $this->displayPanel('items'); ?>
	</div>
	
	
	<? $this->displayPanel('scroll_right'); ?>
	<br class="clear" />
	<? $this->displayPanel('scroll_down'); ?>
</div>
<? $this->displayPanel('target'); ?>
<br class="clear" />
<? $this->displayPanel('legend'); ?>