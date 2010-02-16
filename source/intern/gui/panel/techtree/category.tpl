<ul class="techtree_items">
	<? foreach ($this->panels as $panel): ?>
		<li>
			<? $panel->display(); ?>
			<hr />
		</li>
	<? endforeach; ?>
</ul>