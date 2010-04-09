<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
	<div class="body">
		<div class="head">
			<? if ($this->getTitle()): ?>
				<div class="head_inner">
					<h2><?= $this->getTitle() ?></h2>
				</div>
			<? endif; ?>
		</div>
		<div class="content">
			<div class="content_inner">
				<? $this->contentPanel->display() ?>
			</div>
		</div>
	</div>
	<div class="corner topleft"></div>
	<div class="corner bottomleft"></div>
	<div class="corner topright"></div>
	<div class="corner bottomright"></div>
</div>