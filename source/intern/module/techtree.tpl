<h1>Gebäude</h1>
<hr />
<ul class="techtree_buildings">
	<? foreach($this->params->buildings as $panel): ?>
		<li>
			<? $panel->display(); ?>
			<hr />
		</li>
	<? endforeach; ?>
</ul>

<h1>Forschungen</h1>
<hr />
<ul class="techtree_technologies">
	<? foreach($this->params->technologies as $panel): ?>
		<li>
			<? $panel->display(); ?>
			<hr />
		</li>
	<? endforeach; ?>
</ul>

<h1>Einheiten</h1>
<hr />
<ul class="techtree_units">
	<? foreach($this->params->units as $panel): ?>
		<li>
			<? $panel->display(); ?>
			<hr />
		</li>
	<? endforeach; ?>
</ul>