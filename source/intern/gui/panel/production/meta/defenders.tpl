<h2>Verteidiger:</h2>
<ul>
	<? foreach (Rakuun_User_Manager::getCurrentUser()->alliance->meta->getCurrentShieldGeneratorOwners() as $user): ?>
		<li><?= $user->name; ?></li>
	<? endforeach; ?>
</ul>