<?php
$modelFiles = scandir(Url::modelsFolderPath());
if (is_array($modelFiles)) { 
	foreach ($modelFiles as $modelFile) {
		if (strpos($modelFile, ".php") > -1 && $modelFile != "Product.php") {
			include_once(Url::modelsFolderPath() . $modelFile);
		}
	}
}

$controllers = scandir(Url::controllersFolderPath());
if (is_array($controllers)) { 
	foreach ($controllers as $controller) {
		if (strpos($controller, ".php") > -1 && $controller != 'PageController.php') {
			include_once(Url::controllersFolderPath() . $controller);
		}
	}
}

class PageController {
	public $link;
	public $dbConnection;
	public $dbController;
  public $commonController;
	public $langSet;
	public $pageName;

	public $categoryController;
	public $urlController;
	public $userController;
	public $productController;
	public function __construct()  
	{  
		$this->dbConnection = new DbConnection();
		$this->link = $this->dbConnection->GetConnection();
		$this->dbController = new DBController($this->dbConnection, $this->link);
		$this->commonController = new CommonController($this->dbController);
		$this->categoryController = new CategoryController($this->dbController, $this->commonController);
		$this->urlController = new UrlController($this->dbController, $this->commonController, $this->categoryController);
		$this->userController = new UserController($this->dbController, $this->commonController);
		$this->productController = new ProductController($this->dbController, $this->commonController);
	} 
	
	public function show($pageName) {
		$randomKey = Cookie::RandomValue();
		if (Session::get("internalApiKey") == "") {
			Session::set("internalApiKey", $randomKey);
		}
		$this->pageName = $pageName;
		$this->commonController->pageName = $pageName;
		$this->urlController->pageName = $pageName;

		if (strpos($pageName, "exApi") >  -1) {
			header('Content-Type: application/json');
			$process = false;
			if (file_exists(Url::getPath("exapi") .  $pageName)) {
				$keyCheck = false;
				foreach (getallheaders() as $name => $value) { 
					if (strtolower($name) == "client-key") {
						if ($value == "e0e7331687bec20c4f3ec3323f63fa18r0VxR8S33lrn0xQT") {
							$keyCheck = true;
						}
					}
				} 			
				if ($keyCheck == true) {
					$process = true;
				}
			}
			if ($process) {
				include Url::getPath("exapi") . $pageName;
			} else {
				header("HTTP/1.1 400 Bad Request");
				$json = json_encode(new Error("Bad request"), JSON_UNESCAPED_UNICODE);
				echo $json; 
			}
		}
		else if (strpos($pageName, "Api") >  -1) {
			header('Content-Type: application/json');
			$process = false;
			if (file_exists(Url::getPath("api") .  $pageName)) {
				$keyCheck = false;
				foreach (getallheaders() as $name => $value) { 
					if (strtolower($name) == "internal-client-key") {
						if ($value == Session::get("internalApiKey")) {
							$keyCheck = true;
							$process = true;
						}
					}
				} 			
			}

			if ($process) {
				include Url::getPath("api") . $pageName;
			} else {
				$json = json_encode(new Error("Bad request", 400), JSON_UNESCAPED_UNICODE);
				echo $json; 
			}

		} else {
			$this->userController->CookieLogin();

			//redirection for pagechecking
			if ($pageName == "category.php") {
				if (empty($_GET)) {
					Url::redirect("");
				}
			}


			include Url::getPath("views") . 'header.php';
			// include Url::getPath("views") . 'modal.php';

			if (file_exists(Url::getPath("views") .  $pageName) && Permission::PermissionCheck($pageName, Session::get("permissionId"), "page")) {
				include Url::getPath("views") . $pageName;
			} else {
				include Url::getPath("errorPage") . '404.php';
			}
			include Url::getPath("views") . 'footer.php';
		}
	}
}

?>
