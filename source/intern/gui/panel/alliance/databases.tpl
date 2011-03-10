<? $databases = $this->getMetaDatabases(); ?>
<? $actualUser = Rakuun_User_Manager::getCurrentUser(); ?>
<? $invisibleCount = 0; ?>
<? if (!empty($databases)): ?>
	<ul>
		<? foreach ($databases as $databaseRecord): ?>
			<? if ($actualUser && $actualUser->alliance && $actualUser->alliance->canSeeDatabase($databaseRecord->identifier)): ?>
				<li>
					<? $database = new Rakuun_User_Specials_Database($databaseRecord->user, $databaseRecord->identifier); ?>
					<? $effects = Rakuun_User_Specials::getEffects(); ?>
					<? $images = Rakuun_User_Specials_Database::getDatabaseImages(); ?>
					<? $image = new GUI_Panel_Image('image_'.$databaseRecord->identifier, Router::get()->getStaticRoute('images', $images[$databaseRecord->identifier].'.gif')); ?>
					<?= $image->render(); ?>
					<?= $effects[$databaseRecord->identifier]; ?> (aktuell: +<?= $database->getEffectValue() * 100; ?>%)
				</li>
			<? else ?>
				<? $invisibleCount++; ?>
			<? endif; ?>
		<? endforeach; ?>
		<? if ($invisibleCount > 0): ?>
			<li>Diese Allianz besitzt <?= count($databases); ?> <?= ($invisibleCount < count($databases) ? 'weitere ' : '') ?>Datenbankteile.</li> 
		<? endif; ?>
	</ul>
<? else: ?>
	Keine.
<? endif; ?>