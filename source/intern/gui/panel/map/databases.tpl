<? if (!empty($this->params->visibleDatabases)): ?>
	<ul>
		<? foreach ($this->params->visibleDatabases as $db): ?>
			<li>
				<? $this->displayPanel('image_'.$db); ?>
				<? if ($this->hasPanel('alliancelink_'.$db)): ?>
					<? $this->displayPanel('alliancelink_'.$db); ?>
				<? endif; ?>
				<? $this->displayPanel('link_'.$db); ?>
			</li>
		<? endforeach; ?>
	</ul>
<? else: ?>
	Keine Datenbankteile sichtbar.
<? endif; ?>