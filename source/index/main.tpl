<div id="ctn_index" class="<?= Rakuun_GUI_Skinmanager::get()->getCurrentSkinClass() ?>">
	<div id="ctn_navigation">
		<? $this->params->navigation->display() ?>
	</div>
	<div id="ctn_content">
		<? $this->displayPage() ?>
	</div>
</div>