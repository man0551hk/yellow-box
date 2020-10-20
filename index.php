<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	ob_start();
	session_start();
	include_once 'helpers/session_helper.php';
	include_once 'helpers/cookie_helper.php';
	include_once 'helpers/lang_helper.php';
	$lang = "tc";
	if (isset($_GET["lang"])) {
		Cookie::set("lang", $_GET["lang"]);
		Session::set("lang", $_GET["lang"]);
		Lang::SetLang($_GET["lang"]);
	} else {
		$lang = Cookie::get("lang");
		if ($lang == "") {
			$lang = "tc";
		}
		Cookie::set("lang", $lang);
		Session::set("lang", $lang);
		Lang::SetLang($lang);
	}
	include_once 'helpers/encrypt_helper.php';
	include_once 'helpers/url_helper.php';
	include_once 'helpers/ui_helper.php';
	// include_once 'helpers/header_helper.php';
	include_once 'helpers/permission_helper.php';
	include_once 'helpers/email_helper.php';
	include_once 'controllers/PageController.php';

	$pageName = "index";
	if (isset($_GET["pageName"])) {
		$pageName = $_GET["pageName"];
	}
	$page_controller = new PageController();
	$page_controller->show($pageName.'.php');
	ob_end_flush();
?>