<? $i = 0; ?>
<? foreach (Rakuun_GameSecurity::get()->getVIPGroups() as $group) { ?>
	<? $this->displayPanel('group_'.$i); ?>
	<? ++$i; ?>
	<br class="clear" />
<? } ?>