<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?>>
	<div class="rakuun_message_head">
		<h1 class="subject">
			<?= Text::escapeHTML($this->getTicket()->subject); ?>
		</h1>
		<div class="sender">
			<? $this->displayLabelForPanel('user'); ?>: <? $this->displayPanel('user'); ?>
		</div>
		<div class="date">
			<? $this->displayPanel('date'); ?>
		</div>
		<br class="clear" />
	</div>
	<div class="rakuun_message_content">
		<?= Text::format($this->getTicket()->text); ?>
	</div>
</div>