<?php

class Rakuun_GUI_Control_MetaLink extends GUI_Control_Link {
	public function __construct($name, Rakuun_DB_Meta $meta, $title = '') {
		parent::__construct($name, $meta->name, App::get()->getInternModule()->getSubmodule('metaview')->getURL(array('meta' => $meta->getPK())), $title);
	}
}

?>