<? if ($this->hasBeenActivated()): ?>
	Dein Account wurde aktiviert. Viel Spaß!
<? else: ?>
	<? if($this->hasErrors()): ?>
		<? $this->displayErrors(); ?>
	<? endif ?>
	Account konnte nicht aktiviert werden.
<? endif; ?>