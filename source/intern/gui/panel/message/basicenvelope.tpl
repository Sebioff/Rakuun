<div id="<?= $this->getID(); ?>" <?= $this->getAttributeString(); ?>>
	<? $this->params->selectionCheckbox->display(); ?>
	<? $this->displayLabelForPanel('receiver'); ?> <? $this->displayPanel('receiver'); ?>
	<? if ($this->getMessage()->type == Rakuun_Intern_IGM::TYPE_FIGHT && $attachments = $this->getMessage()->getAttachmentsOfType(Rakuun_Intern_IGM::ATTACHMENT_TYPE_FIGHTREPORTMARKERS)): ?>
		<? $markers = explode(',', $attachments[0]->value); ?>
		<? foreach ($markers as $marker): ?>
			<img class="rakuun_igm_marker" src="<?= Router::get()->getStaticRoute('images', $marker.'.png'); ?>" alt="<?= Rakuun_Intern_IGM::getDescriptionForFightReportMarker($marker); ?>" title="<?= Rakuun_Intern_IGM::getDescriptionForFightReportMarker($marker); ?>" />
		<? endforeach; ?>
	<? endif; ?>
	<? if ($this->getMessage()->get('sender') == Rakuun_User_Manager::getCurrentUser()->getPK() && $this->getMessage()->hasBeenRead): ?>
		<img class="rakuun_igm_marker" src="<?= Router::get()->getStaticRoute('images', 'readigm.png'); ?>" alt="Nachricht wurde gelesen" title="Nachricht wurde gelesen" />
	<? endif; ?>
	<br/>
	<? $this->displayLabelForPanel('sender'); ?> <? $this->displayPanel('sender'); ?>
	<br/>
	<label>Betreff</label> <?= Text::escapeHTML($this->getMessage()->subject); ?>
	<br/>
	<? $this->displayLabelForPanel('date'); ?> <? $this->displayPanel('date'); ?>
	<br/>
	<a href="<?= $this->params->url ?>">Öffnen</a>
</div>