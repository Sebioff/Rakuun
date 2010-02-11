<ul <?= $this->getAttributeString() ?>>
	<? foreach ($this->params->categoryLinks as $categoryLink): ?>
		<li><? $categoryLink->display(); ?></li>
	<? endforeach; ?>
</ul>