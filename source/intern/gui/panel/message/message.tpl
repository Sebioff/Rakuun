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
		<?= nl2br($this->getMessage()->text); ?>
	</div>
	<? $this->displayPanel('delete'); ?>
</div>