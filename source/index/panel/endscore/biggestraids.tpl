<? foreach ($this->params->raids as $raid): ?>
	<? $userLink = new Rakuun_GUI_Control_UserLink('user', $raid->user, $raid->get('user')); ?>
	<? $opponentLink = new Rakuun_GUI_Control_UserLink('opponent', $raid->sender, $raid->get('sender')); ?>
	Angriff von <? $userLink->display(); ?> auf	<? $opponentLink->display(); ?> am <?= date('d.m.Y, H:i:s', $raid->time); ?>
	<br/>
	Beute:
	<br/>
	<?= GUI_Panel_Number::formatNumber($raid->iron); ?> Eisen
	<br/>
	<?= GUI_Panel_Number::formatNumber($raid->beryllium); ?> Beryllium
	<br/>
	<?= GUI_Panel_Number::formatNumber($raid->energy); ?> Energie
	<hr/>
<? endforeach; ?>