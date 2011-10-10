<? foreach ($this->params->fights as $fight): ?>
	<? $userLink = new Rakuun_GUI_Control_UserLink('user', $fight->user, $fight->get('user')); ?>
	<? $opponentLink = new Rakuun_GUI_Control_UserLink('opponent', $fight->opponent, $fight->get('opponent')); ?>
	<?= ($fight->role == Rakuun_Intern_Log_Fights::ROLE_ATTACKER) ? 'Angriff von' : 'Verteidigung von'; ?>
	<? $userLink->display(); ?>
	(<?= ($fight->type == Rakuun_Intern_Log_Fights::TYPE_WON) ? 'Sieger' : 'Verlierer'; ?>)
	<?= ($fight->role == Rakuun_Intern_Log_Fights::ROLE_ATTACKER) ? 'auf' : 'gegen'; ?>
	<? $opponentLink->display(); ?> am <?= date('d.m.Y, H:i:s', $fight->time); ?>
	<br/>
	Vernichtete Einheiten:
	<br/>
	<? foreach (Rakuun_Intern_Production_Factory::getAllUnits() as $unit): ?>
		<? $amount = $fight->{Text::underscoreToCamelCase($unit->getInternalName().'_sum')}; ?>
		<? if ($amount > 0): ?>
			<?= Text::formatNumber($amount); ?> <?= $unit->getNameForAmount($amount); ?>
			<br/>
		<? endif; ?>
	<? endforeach; ?>
	<hr/>
<? endforeach; ?>