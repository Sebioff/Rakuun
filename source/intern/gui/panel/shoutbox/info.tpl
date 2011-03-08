<span id="<?= $this->getID(); ?>" class="<?= $this->getClassString() ?>" title="Klick mich"><?= $this->getTitle() ?></span>
<div id="<?= $this->getID(); ?>_hover" class="core_gui_hoverinfo" style="display:none;">
	<dl>
		<? foreach ($this->params->links as $code => $link): ?>
			<dt><?= $code ?></dt>
			<dd><?= $link ?></dd>
		<? endforeach; ?>
		<? foreach ($this->params->smilies as $code => $link): ?>
			<dt><?= $code ?></dt>
			<dd><?= $link ?></dd>
		<? endforeach; ?>
	</dl>
</div>