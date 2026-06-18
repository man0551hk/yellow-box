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
	include_once 'helpers/permission_helper.php';
	include_once 'helpers/email_helper.php';
	
	// Database connection
	include_once 'models/DbConnection.php';
	include_once 'models/Option.php';
	include_once 'models/ReturnMsg.php';
	include_once 'models/User.php';
	
	include_once 'config/config.php';
	
	$dbConnection = new DbConnection();
	$link = $dbConnection->link;
	
	include_once 'controllers/DBController.php';
	include_once 'controllers/CommonController.php';
	include_once 'controllers/CategoryController.php';
	include_once 'controllers/ProductController.php';
	include_once 'controllers/UserController.php';
	include_once 'controllers/MessageController.php';
	include_once 'controllers/PurchaseController.php';
	include_once 'controllers/ReviewController.php';
	include_once 'controllers/UrlController.php';
	include_once 'controllers/PageController.php';
	
	$dbController = new DBController($dbConnection, $link);
	$commonController = new CommonController($dbController);
	$categoryController = new CategoryController($dbController, $commonController);
	$productController = new ProductController($dbController, $commonController);
	$userController = new UserController($dbController);
	$messageController = new MessageController($dbController);
	$purchaseController = new PurchaseController($dbController);
	$reviewController = new ReviewController($dbController);
	$urlController = new UrlController($dbController, $commonController, $categoryController);
	$pageController = new PageController($dbController, $commonController, $categoryController, $productController, $userController, $messageController, $purchaseController, $reviewController, $urlController);
	
	// Parse URL - get the path relative to domain
	$requestUri = $_SERVER['REQUEST_URI'];
	$basePath = parse_url($requestUri, PHP_URL_PATH);
	$basePath = rtrim($basePath, '/');
	
	// Remove base path (everything before /yellow-box/)
	$scriptName = dirname($_SERVER['SCRIPT_NAME']);
	if ($scriptName != '/' && $scriptName != '.') {
		$basePath = substr($basePath, strlen($scriptName));
	}
	$basePath = ltrim($basePath, '/');
	
	// Handle language prefix
	$langPrefix = '';
	if (strpos($basePath, 'en/') === 0 || $basePath === 'en') {
		$langPrefix = 'en';
		$basePath = substr($basePath, 3);
		$basePath = ltrim($basePath, '/');
		Session::set("lang", "en");
		Lang::SetLang("en");
	}
	
	$segments = explode('/', $basePath);
	$firstSegment = isset($segments[0]) ? $segments[0] : '';
	$secondSegment = isset($segments[1]) ? $segments[1] : '';
	
	// Route handling
	switch ($firstSegment) {
		case '':
			$pageController->home();
			break;
			
		case 'en':
			$pageController->home();
			break;

			
		case 'login':
			$pageController->login();
			break;
			
		case 'signup':
			$pageController->signup();
			break;
			
		case 'logout':
			$pageController->logout();
			break;
			
		case 'sell':
			$pageController->sell();
			break;
			
		case 'my-products':
			$pageController->myProducts();
			break;
			
		case 'my-favorites':
			$pageController->myFavorites();
			break;
			
		case 'saved-searches':
			$pageController->savedSearches();
			break;
			
		case 'notifications':
			$pageController->notifications();
			break;
			
		case 'search-history':
			$pageController->searchHistory();
			break;
			
		case 'blocked-users':
			$pageController->blockedUsers();
			break;
			
		case 'settings':

			$pageController->settings();
			break;
			
		case 'inbox':
			if ($secondSegment) {
				$pageController->conversation($secondSegment);
			} else {
				$pageController->inbox();
			}
			break;
			
		case 'product':
			if ($secondSegment) {
				$pageController->productDetail($secondSegment);
			} else {
				$pageController->error404();
			}
			break;
			
		case 'edit-product':
			if ($secondSegment) {
				$pageController->editProduct($secondSegment);
			} else {
				$pageController->error404();
			}
			break;
			
		case 'delete-product':
			if ($secondSegment) {
				$pageController->deleteProduct($secondSegment);
			} else {
				$pageController->error404();
			}
			break;
			
		case 'profile':
			if ($secondSegment) {
				$pageController->profile($secondSegment);
			} else {
				$pageController->error404();
			}
			break;
			
		case 'verify':
			if ($secondSegment) {
				$pageController->verify($secondSegment);
			} else {
				$pageController->error404();
			}
			break;
			
		case 'search':
			$pageController->search();
			break;
			
		case 'api':
			if ($secondSegment) {
				$pageController->api($secondSegment);
			} else {
				$pageController->error404();
			}
			break;
			
		default:
			// Check if it's a category page (with optional subcategory)
			$decodedSegment = urldecode($firstSegment);
			$category = $categoryController->getCategoryBySeo($decodedSegment);
			if ($category) {
				$pageController->category($decodedSegment);
			} else {
				$pageController->error404();
			}

			break;
	}
	
	ob_end_flush();
?>
