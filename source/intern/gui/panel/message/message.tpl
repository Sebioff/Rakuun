<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
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
	<? if ($this->getMessage()->type == Rakuun_Intern_IGM::TYPE_PRIVATE): ?>
		<? $userLinks = array(); ?>
		<? foreach ($this->getMessage()->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_COPYRECIPIENT) as $copyRecipient): ?>
			<? $userLink = new Rakuun_GUI_Control_UserLink('user', Rakuun_DB_Containers::getUserContainer()->selectByPK($copyRecipient->value), $copyRecipient->value); ?>
			<? $userLinks[] = $userLink->render(); ?>
		<? endforeach; ?>
		<? if (!empty($userLinks)): ?>
			Kopien: <?= implode(', ', $userLinks); ?>
		<? endif; ?>
	<? endif; ?>
	<? if ($this->hasPanel('delete')): ?>
		<? $this->displayPanel('delete'); ?>
	<? endif; ?>
</div>