<? if($this->hasErrors()): ?>
	<? $this->displayErrors() ?>
<? endif; ?>

<? $this->displayLabelForPanel('name') ?> <? $this->displayPanel('name') ?>
<br class="clear" />
<? $this->displayPanel('submit') ?>
<? if ($this->hasBeenSubmitted() && !$this->hasErrors() && count($this->params->metas)): ?>
	<br class="clear" />
	<ul>
		<? foreach ($this->params->metas as $meta): ?>
			<li><a href="<?= App::get()->getInternModule()->getSubmodule('meta')->getUrl(array('meta' => $meta->id)) ?>"><?= $meta->name ?></a></li>
		<? endforeach; ?>
	</ul>
<? endif; ?>