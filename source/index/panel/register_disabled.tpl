<? if (RAKUUN_ROUND_STARTTIME > time()): ?>
	Momentan läuft leider keine Runde.
	<br/>
	Die Anmeldung ist wieder ab <?= date('d.m.Y, H:i:s', RAKUUN_ROUND_STARTTIME); ?> Uhr möglich!
<? else: ?>
	Anmeldung derzeit nicht möglich.
<? endif; ?>