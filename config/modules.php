<?php

/**
 * @package Rakuun Browsergame
 * @copyright Copyright (C) 2012 Sebastian Mayer, Andreas Sicking, Andre Jährling
 * @license GNU/GPL, see license.txt
 * This file is part of Rakuun.
 *
 * Rakuun is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later version.
 *
 * Rakuun is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Rakuun. If not, see <http://www.gnu.org/licenses/>.
 */

$app = App::get();
$app->addModule(new Rakuun_Index_Module_Index('index'));
$app->addModule(new Rakuun_Index_Module_News('news'));
$app->addModule(new Rakuun_Index_Module_Info('infos'));
$app->addModule(new Rakuun_Index_Module_Story('story'));
$app->addModule(new Rakuun_Index_Module_Screenshots('screenshots'));
$app->addModule(new Rakuun_Index_Module_Activation('activation'));
$app->addModule(new Rakuun_Index_Module_PasswordForgotten('password_forgotten'));
$app->addModule(new Rakuun_Index_Module_Master('master'));
$app->addModule(new Rakuun_Index_Module_Endscore('endscore'));
$app->addModule(new Rakuun_Cronjob('cronjob', 'cronjobs'));
$app->addModule(Rakuun_Intern_Modules::get());
  
// setup security features
Security::register(Rakuun_GameSecurity::get());
Security::register(Rakuun_TeamSecurity::get());
Security::register(Rakuun_Intern_Alliance_Security::get());
  
// setup additional scriptlets
$app->addModule(new Rakuun_GUI_Control_UserSelect_Scriptlet('user_select_scriptlet'));
$app->addModule(new Rakuun_Intern_Map_Path('map_path'));
$app->addModule(new Rakuun_Intern_Map_Items('map_items'));
$app->addModule(new GUI_Panel_Plot_Image());

Core_MigrationsLoader::addMigrationFolder(dirname(__FILE__).'/../migrations/persistent', array(), Rakuun_DB_Containers_Persistent::getPersistentConnection());
if (Environment::getCurrentEnvironment() == Environment::DEVELOPMENT)
	Core_MigrationsLoader::addMigrationFolder(dirname(__FILE__).'/../migrations/testdata');

?>