<div id="ctn_ingame" class="module_<?= Router::get()->getCurrentModule()->getName() ?>">
	<div id="ctn_head" class="clearfix">
		<div id="ctn_navigation">
			<? $this->params->navigation->display() ?>
		</div>
		<div id="ctn_ressources">
			<span class="rakuun_ressource rakuun_ressource_iron"><? $this->displayLabelForPanel('iron'); ?>: <? $this->displayPanel('iron'); ?></span>
			<br />
			<span class="rakuun_ressource rakuun_ressource_beryllium"><? $this->displayLabelForPanel('beryllium'); ?>: <? $this->displayPanel('beryllium'); ?></span>
			<br />
			<span class="rakuun_ressource rakuun_ressource_energy"><? $this->displayLabelForPanel('energy'); ?>: <? $this->displayPanel('energy'); ?></span>
			<br />
			<span class="rakuun_ressource rakuun_ressource_people"><? $this->displayLabelForPanel('people'); ?>: <? $this->displayPanel('people'); ?></span>
		</div>
	</div>
	<div id="ctn_content">
		<? if ($this->hasPanel('tutor')): ?>
			<? $this->displayPanel('tutor'); ?>
			<br class="clear" />
		<? endif; ?>
		<? $this->displayPage() ?>
	</div>
</div>