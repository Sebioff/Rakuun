<? if($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if (!empty($this->params->members)): ?>
	<ul>
	<? foreach ($this->params->members as $member): ?>
		<li>
			<? $memberPanel = new Rakuun_GUI_Control_UserLink('member_'.$member->id, $member); ?>
			<? $memberPanel->display(); ?>
			<? $ranks = Rakuun_Intern_Alliance_Security::getForAlliance($this->getAlliance())->getUserGroups($member); ?>
			<? if (!empty($ranks)): ?>
				<? $rankNames = array(); ?>
				<? foreach ($ranks as $rank): ?>
					<? $rankNames[] = Text::escapeHTML($rank->name); ?>
				<? endforeach; ?>
				(<?= implode(', ', $rankNames); ?>)
			<? endif; ?>
		</li>
	<? endforeach; ?>
	<li>Anzahl: <?= count($this->params->members); ?></li>
	</ul>
<? endif; ?>