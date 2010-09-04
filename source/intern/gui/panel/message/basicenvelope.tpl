<div id="<?= $this->getID() ?>" <?= $this->getAttributeString() ?> onClick="window.location.href='<?= $this->params->url ?>'">
	<a href="<?= $this->params->url ?>">
		<? $this->displayLabelForPanel('receiver'); ?>: <? $this->displayPanel('receiver'); ?>
		<? if ($this->getMessage()->type == Rakuun_Intern_IGM::TYPE_FIGHT && $attachments = $this->getMessage()->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_FIGHTREPORTMARKERS)): ?>
			<? $markers = explode(',', $attachments[0]->value); ?>
			<? foreach ($markers as $marker): ?>
				<img class="rakuun_fightreport_marker" src="<?= Router::get()->getStaticRoute('images', $marker.'.png'); ?>" alt="<?= Rakuun_Intern_IGM::getDescriptionForFightReportMarker($marker); ?>" title="<?= Rakuun_Intern_IGM::getDescriptionForFightReportMarker($marker); ?>" />
			<? endforeach; ?>
		<? endif; ?>
		<br/>
		<? $this->displayLabelForPanel('sender'); ?>: <? $this->displayPanel('sender'); ?>
		<br/>
		Betreff: <?= Text::escapeHTML($this->getMessage()->subject); ?>
		<br/>
		<? $this->displayLabelForPanel('date'); ?>: <? $this->displayPanel('date'); ?>
	</a>
</div>