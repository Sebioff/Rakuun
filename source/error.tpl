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