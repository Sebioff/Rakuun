<div id="ctn_index" class="<?= Rakuun_GUI_Skinmanager::get()->getCurrentSkinClass() ?>">
	<div id="ctn_navigation">
		<? $this->params->navigation->display() ?>
	</div>
	<div id="ctn_content">
		<? $this->displayPage(); ?>
		<? $bgImage = Router::get()->getStaticRoute('images', 'background_index.jpg'); ?>
		<? $easterSunday = easter_date(); ?>
		<? $date = date('d.m'); ?>
		<? if ($date == date('d.m', $easterSunday - 60 * 60 * 24 * 2) || $date == date('d.m', $easterSunday - 60 * 60 * 24) || $date == date('d.m', $easterSunday) || $date == date('d.m', $easterSunday + 60 * 60 * 24)): ?>
			<? $bgImage = Router::get()->getStaticRoute('images', 'seasons/background_index_easter.png'); ?>
		<? endif; ?>
		<? if (date('n') == 2 && (date('j') == 15 || date('Y') == 2012)): ?>
			<? $bgImage = Router::get()->getStaticRoute('images', 'seasons/background_index_ooo.png'); ?>
		<? endif; ?>
		<img class="background_image" alt="Rakuun" src="<?= $bgImage; ?>"/>
	</div>
</div>