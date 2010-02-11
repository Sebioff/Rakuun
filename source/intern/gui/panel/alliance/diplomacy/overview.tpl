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
					<dd><? $link = new Rakuun_GUI_Control_AllianceLink('link', $auvb->other); $link->display(); ?></dd>
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
					<dd><? $link = new Rakuun_GUI_Control_AllianceLink('link', $nap->other); $link->display();  ?></dd>
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
					<dd><? $link = new Rakuun_GUI_Control_AllianceLink('link', $war->other); $link->display();  ?></dd>
				</dl>
			</li>
		<? endforeach; ?>
	</ul>
<? endif; ?>