<? if ($this->hasMessages()): ?>
	<? $this->displayMessages(); ?>
<? endif ?>
<? if (count($this->params->auvbs) > 0): ?>
	Angriffs- und Verteidigungsbündnisse<br />
	<ul class="diplomacy-offer">
		<? foreach ($this->params->auvbs as $auvb): ?>
			<li>
				<dl>
					<dt>Allianz:</dt>
					<dd><?= $auvb->other->name; ?></dd>
					<dt>Kündigungsfrist:</dt>
					<dd><?= $auvb->notice; ?> Stunden</dd>
					<dt>Botschaft:</dt>
					<dd><?= $auvb->text; ?></dd>
					<? if ($auvb->status == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_ACTIVE): ?>
						<dt>Aktion:</dt>
						<dd><? $this->displayPanel('blanko'.$auvb->getPK()); ?></dd>
					<? else: ?>
						<dt>Anmerkung:</dt>
						<dd>Gekündigt, noch aktiv bis <? $time = new GUI_Panel_Date('time', $auvb->date + ($auvb->notice * 3600)); $time->display(); ?></dd>
					<? endif; ?>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
	<hr />
<? endif; ?>
<? if (count($this->params->naps) > 0): ?>
	Nicht-Angriffs-Pakte<br />
	<ul class="diplomacy-offer">
		<? foreach ($this->params->naps as $nap): ?>
			<li>
				<dl>
					<dt>Allianz:</dt>
					<dd><?= $nap->other->name; ?></dd>
					<dt>Kündigungsfrist:</dt>
					<dd><?= $nap->notice; ?> Stunden</dd>
					<dt>Botschaft:</dt>
					<dd><?= $nap->text; ?></dd>
					<? if ($nap->status == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_ACTIVE): ?>
						<dt>Aktion:</dt>
						<dd><? $this->displayPanel('blanko'.$nap->getPK()); ?></dd>
					<? else: ?>
						<dt>Anmerkung:</dt>
						<dd>Gekündigt, noch aktiv bis <? $time = new GUI_Panel_Date('time', $nap->date + ($nap->notice * 3600)); $time->display(); ?></dd>
					<? endif; ?>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
	<hr />
<? endif; ?>
<? if (count($this->params->wars) > 0): ?>
	Kriege<br />
	<ul class="diplomacy-offer">
		<? foreach ($this->params->wars as $war): ?>
			<li>
				<dl>
					<dt>Allianz:</dt>
					<dd><?= $war->other->name; ?></dd>
					<dt>Kündigungsfrist:</dt>
					<dd><?= $war->notice; ?> Stunden</dd>
					<dt>Botschaft:</dt>
					<dd><?= $war->text; ?></dd>
					<? if ($war->status == Rakuun_Intern_GUI_Panel_Alliance_Diplomacy::STATUS_ACTIVE): ?>
						<dt>Aktion:</dt>
						<dd><? $this->displayPanel('blanko'.$war->getPK()); ?></dd>
					<? else: ?>
						<dt>Anmerkung:</dt>
						<dd>Beendet, noch aktiv bis <? $time = new GUI_Panel_Date('time', $war->date + ($war->notice * 3600)); $time->display(); ?></dd>
					<? endif; ?>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>