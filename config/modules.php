<?php

$app = App::get();
$app->addModule(new Rakuun_Index_Module_Index('index'));
$app->addModule(new Rakuun_Index_Module_Register('register'));
$app->addModule(new Rakuun_Index_Module_Login('login'));
$app->addModule(new Rakuun_Index_Module_Activation('activation'));
$app->addModule(new Rakuun_Index_Module_Master('master'));
$app->addModule(new Rakuun_Cronjob('cronjob'));
$app->addModule(Rakuun_Intern_Modules::get());
  
// setup security features
Security::register(Rakuun_GameSecurity::get());
Security::register(Rakuun_TeamSecurity::get());
Security::register(Rakuun_Intern_Alliance_Security::get());
  
// setup additional scriptlets
$app->addModule(new Rakuun_GUI_Control_UserSelect_Scriptlet('user_select_scriptlet'));
$app->addModule(new Rakuun_GUI_Panel_Box_Collapsible_Ajax('panel_collapse'));
$app->addModule(new Rakuun_Intern_Map_Path('map_path'));
$app->addModule(new Rakuun_Intern_Map_Items('map_items'));

$app->addModule(new GUI_Panel_Plot_Image('plotimage'));
    
?>