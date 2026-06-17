<?php
class PageController
{
  private $dbController;
  private $commonController;
  private $categoryController;
  private $productController;
  private $userController;
  private $messageController;
  private $urlController;

  public function __construct($dbController, $commonController, $categoryController, $productController, $userController, $messageController, $urlController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
    $this->categoryController = $categoryController;
    $this->productController = $productController;
    $this->userController = $userController;
    $this->messageController = $messageController;
    $this->urlController = $urlController;
  }

  public function render($view, $data = array())
  {
    extract($data);
    require_once 'views/header.php';
    require_once 'views/' . $view . '.php';
    require_once 'views/footer.php';
  }

  public function home()
  {
    $this->render('index');
  }

  public function login()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $result = $this->userController->login($email, $password);
      if ($result['success']) {
        header('Location: ' . Url::getDomain());
        exit;
      } else {
        $this->render('login', array('error' => $result['message']));
        return;
      }
    }
    $this->render('login');
  }

  public function signup()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = array(
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirmPassword' => $_POST['confirmPassword']
      );
      $result = $this->userController->register($data);
      if ($result['success']) {
        $this->render('signup', array('success' => $result['message']));
        return;
      } else {
        $this->render('signup', array('error' => $result['message']));
        return;
      }
    }
    $this->render('signup');
  }

  public function logout()
  {
    Session::destroy();
    header('Location: ' . Url::getDomain());
    exit;
  }

  public function verify($code)
  {
    $result = $this->userController->verifyEmail($code);
    $this->render('verify', array('result' => $result));
  }

  public function profile($seo)
  {
    $user = $this->userController->getUserBySeo($seo);
    if (!$user) {
      $this->error404();
      return;
    }
    $products = $this->productController->getProductsByUserId($user['userId'], 1);
    $this->render('profile', array('profileUser' => $user, 'products' => $products));
  }

  public function myProducts()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $products = $this->productController->getProductsByUserId($userId);
    $this->render('my-products', array('products' => $products));
  }

  public function myFavorites()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $favorites = $this->productController->getFavorites($userId);
    $this->render('my-favorites', array('favorites' => $favorites));
  }

  public function savedSearches()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $searches = $this->productController->getSavedSearches($userId);
    $this->render('saved-searches', array('searches' => $searches));
  }

  public function notifications()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $notifications = $this->userController->getNotifications($userId);
    $unreadCount = $this->userController->getUnreadNotificationCount($userId);
    $this->render('notifications', array(
      'notifications' => $notifications,
      'unreadCount' => $unreadCount
    ));
  }

  public function searchHistory()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $history = $this->userController->getSearchHistory($userId);
    $this->render('search-history', array('history' => $history));
  }

  public function blockedUsers()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $blocked = $this->userController->getBlockedUsers($userId);
    $this->render('blocked-users', array('blocked' => $blocked));
  }

  public function settings()

  {
    $this->requireLogin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = array();
      if (isset($_POST['firstName'])) $data['firstName'] = $_POST['firstName'];
      if (isset($_POST['lastName'])) $data['lastName'] = $_POST['lastName'];
      if (isset($_POST['phone'])) $data['phone'] = $_POST['phone'];
      $result = $this->userController->updateProfile($data);
      if ($result['success']) {
        $this->render('settings', array('success' => $result['message']));
        return;
      } else {
        $this->render('settings', array('error' => $result['message']));
        return;
      }
    }
    $this->render('settings');
  }

  public function sell()
  {
    $this->requireLogin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = array(
        'fcId' => $_POST['fcId'],
        'scId' => $_POST['scId'],
        'listingTitle' => $_POST['listingTitle'],
        'condition' => $_POST['condition'],
        'brand' => $_POST['brand'],
        'price' => $_POST['price'],
        'description' => $_POST['description'],
        'keyword' => $_POST['keyword']
      );
      $images = isset($_FILES['images']) ? $_FILES['images'] : array();
      $refId = $this->productController->createProduct($data, $images);
      if ($refId) {
        header('Location: ' . Url::getDomain() . 'product/' . $refId . '/');
        exit;
      } else {
        $this->render('sell', array('error' => Lang::$lang["uploadError"]));
        return;
      }
    }
    $this->render('sell');
  }

  public function editProduct($refId)
  {
    $this->requireLogin();
    $product = $this->productController->getProductByRefId($refId);
    if (!$product || $product['userId'] != Session::get('userId')) {
      $this->error404();
      return;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $data = array(
        'fcId' => $_POST['fcId'],
        'scId' => $_POST['scId'],
        'listingTitle' => $_POST['listingTitle'],
        'condition' => $_POST['condition'],
        'brand' => $_POST['brand'],
        'price' => $_POST['price'],
        'description' => $_POST['description'],
        'keyword' => $_POST['keyword']
      );
      $this->productController->updateProduct($product['productId'], $data);
      header('Location: ' . Url::getDomain() . 'product/' . $refId . '/');
      exit;
    }
    $this->render('edit-product', array('product' => $product));
  }

  public function deleteProduct($refId)
  {
    $this->requireLogin();
    $product = $this->productController->getProductByRefId($refId);
    if ($product && $product['userId'] == Session::get('userId')) {
      $this->productController->deleteProduct($product['productId']);
    }
    header('Location: ' . Url::getDomain() . 'my-products/');
    exit;
  }

  public function productDetail($refId)
  {
    $product = $this->productController->getProductByRefId($refId);
    if (!$product) {
      $this->error404();
      return;
    }
    
    // Record view
    $this->productController->recordProductView($product['productId']);
    
    // Get similar products
    $similarProducts = $this->productController->getSimilarProducts($product['productId'], $product['fcId']);
    
    // Get more from seller
    $moreFromSeller = $this->productController->getMoreFromSeller($product['userId'], $product['productId']);
    
    $this->render('product-detail', array(
      'product' => $product,
      'similarProducts' => $similarProducts,
      'moreFromSeller' => $moreFromSeller
    ));
  }


  public function search()
  {
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $fcId = isset($_GET['fcId']) ? intval($_GET['fcId']) : 0;
    $scId = isset($_GET['scId']) ? intval($_GET['scId']) : 0;
    $condition = isset($_GET['condition']) ? intval($_GET['condition']) : 0;
    $sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';
    
    $rs = $this->productController->search($fcId, $scId, $keyword, $condition, $sortBy);
    $products = array();
    while ($row = mysqli_fetch_array($rs)) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
    }
    
    $this->render('search', array(
      'products' => $products,
      'keyword' => $keyword,
      'fcId' => $fcId,
      'scId' => $scId,
      'condition' => $condition,
      'sortBy' => $sortBy
    ));
  }

  public function category($seo)
  {
    $category = $this->categoryController->getCategoryBySeo($seo);
    if (!$category) {
      $this->error404();
      return;
    }
    
    $fcId = $category['id'];
    $scId = 0;
    if ($category['fcId'] > 0) {
      $fcId = $category['fcId'];
      $scId = $category['id'];
    }
    
    $rs = $this->productController->search($fcId, $scId);
    $products = array();
    while ($row = mysqli_fetch_array($rs)) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
    }
    
    $this->render('category', array(
      'category' => $category,
      'products' => $products,
      'fcId' => $fcId,
      'scId' => $scId
    ));
  }

  public function inbox()
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    $conversations = $this->messageController->getConversations($userId);
    $this->render('inbox', array('conversations' => $conversations));
  }

  public function conversation($otherUserId)
  {
    $this->requireLogin();
    $userId = Session::get('userId');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
      $this->messageController->sendMessage($userId, $otherUserId, $_POST['content']);
      header('Location: ' . Url::getDomain() . 'inbox/' . $otherUserId . '/');
      exit;
    }
    
    $messages = $this->messageController->getMessages($userId, $otherUserId);
    $otherUser = $this->userController->getUserById($otherUserId);
    $conversations = $this->messageController->getConversations($userId);
    
    $this->render('inbox', array(
      'conversations' => $conversations,
      'messages' => $messages,
      'otherUser' => $otherUser,
      'activeConversation' => $otherUserId
    ));
  }

  public function api($action)
  {
    header('Content-Type: application/json');
    
    switch ($action) {
      case 'toggle-favorite':
        $this->requireLogin();
        $productId = intval($_POST['productId']);
        $result = $this->productController->toggleFavorite($productId);
        echo json_encode($result);
        break;
        
      case 'save-search':
        $this->requireLogin();
        $keyword = $_POST['keyword'];
        $fcId = intval($_POST['fcId']);
        $scId = intval($_POST['scId']);
        $result = $this->productController->saveSearch($keyword, $fcId, $scId);
        echo json_encode($result);
        break;
        
      case 'delete-search':
        $this->requireLogin();
        $searchId = intval($_POST['searchId']);
        $this->productController->deleteSavedSearch($searchId);
        echo json_encode(array('success' => true));
        break;
        
      case 'send-message':
        $this->requireLogin();
        $toUserId = intval($_POST['toUserId']);
        $content = $_POST['content'];
        $result = $this->messageController->sendMessage(Session::get('userId'), $toUserId, $content);
        echo json_encode($result);
        break;
        
      case 'get-messages':
        $this->requireLogin();
        $otherUserId = intval($_GET['otherUserId']);
        $messages = $this->messageController->getMessages(Session::get('userId'), $otherUserId);
        echo json_encode($messages);
        break;
        
      case 'get-conversations':
        $this->requireLogin();
        $conversations = $this->messageController->getConversations(Session::get('userId'));
        echo json_encode($conversations);
        break;
        
      case 'get-categories':
        $categories = $this->categoryController->GetCategory();
        echo json_encode($categories);
        break;
        
      case 'get-subcategories':
        $fcId = intval($_GET['fcId']);
        $subcategories = $this->categoryController->GetSubCategory($fcId);
        echo json_encode($subcategories);
        break;
        
      case 'toggle-follow':
        $this->requireLogin();
        $followingId = intval($_POST['followingId']);
        $result = $this->userController->toggleFollow($followingId);
        echo json_encode($result);
        break;
        
      case 'toggle-block':
        $this->requireLogin();
        $blockedUserId = intval($_POST['blockedUserId']);
        $result = $this->userController->toggleBlock($blockedUserId);
        echo json_encode($result);
        break;
        
      case 'report-product':
        $this->requireLogin();
        $productId = intval($_POST['productId']);
        $reason = $_POST['reason'];
        $result = $this->userController->reportProduct($productId, $reason);
        echo json_encode($result);
        break;
        
      case 'get-notifications':
        $this->requireLogin();
        $notifications = $this->userController->getNotifications(Session::get('userId'));
        $unreadCount = $this->userController->getUnreadNotificationCount(Session::get('userId'));
        echo json_encode(array('notifications' => $notifications, 'unreadCount' => $unreadCount));
        break;
        
      case 'mark-notification-read':
        $this->requireLogin();
        $notificationId = intval($_POST['notificationId']);
        $result = $this->userController->markNotificationRead($notificationId);
        echo json_encode($result);
        break;
        
      case 'mark-all-notifications-read':
        $this->requireLogin();
        $result = $this->userController->markAllNotificationsRead();
        echo json_encode($result);
        break;
        
      case 'get-search-history':
        $this->requireLogin();
        $history = $this->userController->getSearchHistory(Session::get('userId'));
        echo json_encode($history);
        break;
        
      case 'clear-search-history':
        $this->requireLogin();
        $result = $this->userController->clearSearchHistory();
        echo json_encode($result);
        break;
        
      case 'get-recently-viewed':
        $this->requireLogin();
        $products = $this->productController->getRecentlyViewed(Session::get('userId'));
        echo json_encode($products);
        break;
        
      case 'get-trending':
        $products = $this->productController->getTrendingProducts(8);
        echo json_encode($products);
        break;
        
      case 'is-following':
        $this->requireLogin();
        $followingId = intval($_GET['followingId']);
        $result = $this->userController->isFollowing(Session::get('userId'), $followingId);
        echo json_encode(array('following' => $result));
        break;
        
      case 'is-blocked':
        $this->requireLogin();
        $blockedUserId = intval($_GET['blockedUserId']);
        $result = $this->userController->isBlocked(Session::get('userId'), $blockedUserId);
        echo json_encode(array('blocked' => $result));
        break;
        
      case 'save-search-history':
        $this->requireLogin();
        $keyword = $_POST['keyword'];
        $this->userController->addSearchHistory($keyword);
        echo json_encode(array('success' => true));
        break;
        
      default:
        echo json_encode(array('error' => 'Unknown action'));

    }
    exit;
  }

  private function requireLogin()
  {
    if (!Session::get('userId')) {
      if ($this->isAjax()) {
        echo json_encode(array('error' => Lang::$lang["loginRequired"]));
        exit;
      }
      header('Location: ' . Url::getDomain() . 'login/');
      exit;
    }
  }

  private function isAjax()
  {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  }

  public function error404()
  {
    http_response_code(404);
    require_once 'views/header.php';
    require_once 'errorPage/404.php';
    require_once 'views/footer.php';
    exit;
  }
}
?>
