<ul class="alliance_ranklist">
	<li>
		<a href="<?= $this->getModule()->getURL() ?>">Neuer Rang...</a>
		<hr/>
	</li>
	<? foreach($this->panels as $panel): ?>
		<li><? $panel->display() ?></li>
	<? endforeach; ?>
</ul>