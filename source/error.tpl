<?
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Oh noes!</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="imagetoolbar" content="no" />
		<link rel="stylesheet" type="text/css" href="<?= Router::get()->getStaticRoute('core_css', 'reset.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?= Router::get()->getStaticRoute('css', 'default.css'); ?>" />
		<link rel="stylesheet" type="text/css" href="<?= Router::get()->getStaticRoute('css', 'index.css'); ?>" />
	</head>
	<body id="rakuun_error_page">
		<h1>Das hätte nicht passieren dürfen!</h1>
		Es ist ein interner Fehler aufgetreten.
		<br/>
		Aber keine Panik! Die Administratoren wurden über dieses Problem informiert und werden
		sich so bald wie möglich darum kümmern, alles wieder zusammenzusetzen.
	</body>
</html>