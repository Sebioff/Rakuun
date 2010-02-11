<? if (!empty($this->params->visibleDatabases)): ?>
	<ul>
		<? foreach ($this->params->visibleDatabases as $db): ?>
			<li>
				<? $this->displayPanel('image_'.$db); ?>
				<? $this->displayPanel('link_'.$db); ?>
			</li>
		<? endforeach; ?>
	</ul>
<? else: ?>
	Keine Datenbankteile sichtbar.
<? endif; ?>