<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
	<div class="rakuun_message_head">
		<h1 class="subject">
			<?= Text::escapeHTML($this->getMessage()->subject); ?>
		</h1>
		<div class="sender">
			<? $this->displayLabelForPanel('sender'); ?>: <? $this->displayPanel('sender'); ?>
		</div>
		<div class="date">
			<? $this->displayPanel('date'); ?>
		</div>
		<br class="clear" />
	</div>
	<div class="rakuun_message_content">
		<?= Text::format($this->getMessage()->text); ?>
	</div>
	<? if ($this->hasPanel('delete')): ?>
		<? $this->displayPanel('delete'); ?>
	<? endif; ?>
</div>