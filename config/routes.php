<?php

  // static routes
  Router::get()->addStaticRoute('css', dirname(__FILE__).'/../www/css');
  Router::get()->addStaticRoute('js', dirname(__FILE__).'/../www/js');
  Router::get()->addStaticRoute('images', dirname(__FILE__).'/../www/images');
    
?>