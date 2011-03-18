<? $databases = $this->getMetaDatabases(); ?>
<? $databasesCount = count($databases); ?>
<? $actualUser = Rakuun_User_Manager::getCurrentUser(); ?>
<? $visibleCount = 0; ?>
<? $effects = Rakuun_User_Specials::getEffects(); ?>
<? if (!empty($databases)): ?>
	<ul>
		<? foreach ($databases as $databaseRecord): ?>
			<? if ($actualUser && $actualUser->alliance && $actualUser->alliance->canSeeDatabase($databaseRecord->identifier)): ?>
				<li>
					<? $database = new Rakuun_User_Specials_Database($databaseRecord->user, $databaseRecord->identifier); ?>
					<? $images = Rakuun_User_Specials_Database::getDatabaseImages(); ?>
					<? $image = new GUI_Panel_Image('image_'.$databaseRecord->identifier, Router::get()->getStaticRoute('images', $images[$databaseRecord->identifier].'.gif')); ?>
					<?= $image->render(); ?>
					<?= $effects[$databaseRecord->identifier]; ?> (aktuell: +<?= $database->getEffectValue() * 100; ?>%)
				</li>
				<? $visibleCount++; ?>
			<? endif; ?>
		<? endforeach; ?>
		<? if ($visibleCount != $databasesCount): ?>
			<li><hr />Diese Allianz besitzt <?= ($databasesCount - $visibleCount) ?> <?= ($visibleCount < $databasesCount ? 'weitere(s) ' : '') ?>Datenbankteil(e).</li> 
		<? endif; ?>
	</ul>
<? else: ?>
	Keine.
<? endif; ?>