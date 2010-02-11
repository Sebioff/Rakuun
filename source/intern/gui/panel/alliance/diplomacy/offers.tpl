<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
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
					<dt>Aktion:</dt>
					<? if ($auvb->other == $auvb->allianceActive): ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('accept' => $auvb->getPK())); ?>">annehmen</a></dd>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('deny' => $auvb->getPK())); ?>">ablehnen</a></dd>
					<? else: ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('cancel' => $auvb->getPK())); ?>">zurückziehen</a></dd>
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
					<dt>Aktion:</dt>
					<? if ($nap->other == $nap->allianceActive): ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('accept' => $nap->getPK())); ?>">annehmen</a></dd>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('deny' => $nap->getPK())); ?>">ablehnen</a></dd>
					<? else: ?>
						<dd><a href="<?= Router::get()->getCurrentModule()->getUrl(array('cancel' => $nap->getPK())); ?>">zurückziehen</a></dd>
					<? endif; ?>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
	<hr />
<? endif; ?>