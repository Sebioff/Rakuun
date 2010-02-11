<? $this->displayPanel('scroll_up'); ?>
<? $this->displayPanel('scroll_left'); ?>

<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
	<?= $this->getMapLayer(); ?>
	<? $this->displayPanel('path'); ?>
	<? foreach ($this->getScrollItems() as $scrollItem): ?>
		<? $scrollItem->display(); ?>
	<? endforeach; ?>
</div>

<? $this->displayPanel('scroll_right'); ?>
<br class="clear" />
<? $this->displayPanel('scroll_down'); ?>
<br class="clear" />
<? $this->displayPanel('target'); ?>