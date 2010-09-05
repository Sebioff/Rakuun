<? $databases = $this->getMetaDatabases(); ?>
<? if (!empty($databases)): ?>
	<ul>
		<? foreach ($databases as $databaseRecord): ?>
			<li>
				<? $database = new Rakuun_User_Specials_Database($databaseRecord->user, $databaseRecord->identifier); ?>
				<? $effects = Rakuun_User_Specials::getEffects(); ?>
				<? $images = Rakuun_User_Specials_Database::getDatabaseImages(); ?>
				<? $image = new GUI_Panel_Image('image_'.$databaseRecord->identifier, Router::get()->getStaticRoute('images', $images[$databaseRecord->identifier].'.gif')); ?>
				<?= $image->render(); ?>
				<?= $effects[$databaseRecord->identifier]; ?> (aktuell: +<?= $database->getEffectValue() * 100; ?>%)
			</li>
		<? endforeach; ?>
	</ul>
<? else: ?>
	Keine.
<? endif; ?>