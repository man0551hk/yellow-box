<?php
class ProductController
{
  private $dbController;
  private $commonController;
  public $pageName = "";
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function performSearch($fcId = 0, $scId = 0)
  {
    self::search(
      $fcId,
      $scId,
      isset($_POST["keyword"]) ? $_POST["keyword"] : "",
      isset($_POST["productCondition"]) ? $_POST["productCondition"] : 0,
      isset($_POST["sortBy"]) ? $_POST["sortBy"] : "",
    );
  }

  public function search($fcId = 0, $scId = 0, $keyword = "", $productCondition = 0, $sortBy = "")
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.fcId",
      "p.scId",
      "p.listingTitle",
      "p.price",
      "p.createdDate",
      "p.condition",
      "p.description",
      "p.status",
      "p.userId",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $conditionArray = array("p.status = 1");
    if ($fcId > 0) {
      array_push($conditionArray, "p.fcId = " . $fcId);
    }
    if ($scId > 0) {
      array_push($conditionArray, "p.scId = " . $scId);
    }
    if ($keyword != "") {
      array_push($conditionArray, "p.keyword like '%" . $this->dbController->escapeString($keyword) . "%'");
    }
    if ($productCondition > 0) {
      array_push($conditionArray, "p.condition = " . $productCondition);
    }
    $orderBy = "";
    switch ($sortBy) {
      case "lowToHigh":
        $orderBy = " p.price asc";
        break;
      case "hightToLow":
        $orderBy = " p.price desc";
        break;
      default:
        $orderBy = " p.createdDate desc";
    }
    $condition = implode(" and ", $conditionArray);
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, "p.productId", false);
    return $rs;
  }

  public function getLatestProducts($limit = 12)
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.fcId",
      "p.scId",
      "p.listingTitle",
      "p.price",
      "p.createdDate",
      "p.condition",
      "p.status",
      "p.userId",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $condition = "p.status = 1";
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $orderBy = " p.createdDate desc";
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, "p.productId", false);
    
    $products = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
      $count++;
    }
    return $products;
  }

  public function getProductByRefId($refId)
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.fcId",
      "p.scId",
      "p.listingTitle",
      "p.price",
      "p.createdDate",
      "p.condition",
      "p.description",
      "p.brand",
      "p.keyword",
      "p.status",
      "p.viewCount",
      "p.isSold",
      "p.userId",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $condition = "p.refId = '$refId'";
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, null, null, false);
    
    if ($row = mysqli_fetch_array($rs)) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path", "orderId"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $images = array();
      while ($imgRow = mysqli_fetch_array($imageRs)) {
        array_push($images, $imgRow["path"]);
      }
      $row["images"] = $images;
      
      // Get seller info with stats
      $userRs = $this->dbController->QueryDB("user", array("userId", "firstName", "lastName", "profilePic", "seo", "lastActive", "responseTime", "responseRate"), "query", "userId = " . $row["userId"], null, null, null, false);
      $row["seller"] = mysqli_fetch_array($userRs);
      
      return $row;
    }
    return null;
  }

  public function recordProductView($productId)
  {
    $userId = Session::get("userId") ? Session::get("userId") : "NULL";
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $now = date('Y-m-d H:i:s');
    
    // Insert view record
    $this->dbController->DirectQuery("INSERT INTO product_view (productId, userId, ipAddress, viewedDate) VALUES ($productId, $userId, '$ipAddress', '$now')");
    
    // Increment view count
    $this->dbController->DirectQuery("UPDATE product SET viewCount = viewCount + 1 WHERE productId = $productId");
  }

  public function getRecentlyViewed($userId, $limit = 8)
  {
    $fields = array(
      "DISTINCT p.productId",
      "p.refId",
      "p.listingTitle",
      "p.price",
      "p.status",
      "pv.viewedDate",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $condition = "pv.userId = $userId AND p.status = 1";
    $joinTables = array(
      " INNER JOIN product_view pv ON p.productId = pv.productId",
      " LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)"
    );
    $orderBy = " pv.viewedDate desc";
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, "p.productId", false);
    
    $products = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
      $count++;
    }
    return $products;
  }

  public function getSimilarProducts($productId, $fcId, $limit = 4)
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.listingTitle",
      "p.price",
      "p.status",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $condition = "p.fcId = $fcId AND p.productId != $productId AND p.status = 1";
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $orderBy = " RAND()";
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
    $products = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
      $count++;
    }
    return $products;
  }

  public function getTrendingProducts($limit = 8)
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.fcId",
      "p.scId",
      "p.listingTitle",
      "p.price",
      "p.createdDate",
      "p.condition",
      "p.status",
      "p.viewCount",
      "p.userId",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $condition = "p.status = 1";
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $orderBy = " p.viewCount desc, p.createdDate desc";
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, "p.productId", false);
    
    $products = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
      $count++;
    }
    return $products;
  }

  public function getMoreFromSeller($userId, $excludeProductId, $limit = 4)
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.listingTitle",
      "p.price",
      "p.status",
      "c.name_" . Session::get("lang") . " as category_name",
      "c.seo_" . Session::get("lang") . " as category_seo"
    );
    $condition = "p.userId = $userId AND p.productId != $excludeProductId AND p.status = 1";
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $orderBy = " p.createdDate desc";
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
    $products = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($products, $row);
      $count++;
    }
    return $products;
  }


  public function getProductsByUserId($userId, $status = -1)
  {
    $fields = array(
      "p.productId",
      "p.refId",
      "p.fcId",
      "p.scId",
      "p.listingTitle",
      "p.price",
      "p.createdDate",
      "p.condition",
      "p.status",
      "c.name_" . Session::get("lang") . " as category_name"
    );
    $condition = "p.userId = $userId";
    if ($status >= 0) {
      $condition .= " AND p.status = $status";
    }
    $joinTables = array(" LEFT JOIN category c ON (p.fcId = c.id OR p.scId = c.id)");
    $orderBy = " p.createdDate desc";
    $rs = $this->dbController->QueryDB("product p", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
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
    return $products;
  }

  public function createProduct($data, $images = array())
  {
    $refId = strtoupper(substr(md5(uniqid()), 0, 8));
    $now = date('Y-m-d H:i:s');
    
    $fields = array(
      "refId" => $refId,
      "fcId" => $data["fcId"],
      "scId" => $data["scId"],
      "listingTitle" => $data["listingTitle"],
      "condition" => $data["condition"],
      "brand" => $data["brand"],
      "price" => $data["price"],
      "description" => $data["description"],
      "keyword" => $data["keyword"],
      "createdDate" => $now,
      "status" => 1,
      "userId" => Session::get("userId")
    );
    
    $productId = $this->dbController->QueryDB("product", $fields, "insert");
    
    // Save images
    if (!empty($images)) {
      $orderId = 1;
      foreach ($images as $image) {
        $imagePath = $this->commonController->SaveImage($image, $productId, "images/products");
        if ($imagePath !== false) {
          $imgFields = array(
            "productId" => $productId,
            "path" => $imagePath,
            "orderId" => $orderId
          );
          $this->dbController->QueryDB("productImage", $imgFields, "insert");
          $orderId++;
        }
      }
    }
    
    return $refId;
  }

  public function updateProduct($productId, $data)
  {
    $fields = array();
    if (isset($data["listingTitle"])) $fields["listingTitle"] = $data["listingTitle"];
    if (isset($data["fcId"])) $fields["fcId"] = $data["fcId"];
    if (isset($data["scId"])) $fields["scId"] = $data["scId"];
    if (isset($data["condition"])) $fields["condition"] = $data["condition"];
    if (isset($data["brand"])) $fields["brand"] = $data["brand"];
    if (isset($data["price"])) $fields["price"] = $data["price"];
    if (isset($data["description"])) $fields["description"] = $data["description"];
    if (isset($data["keyword"])) $fields["keyword"] = $data["keyword"];
    if (isset($data["status"])) $fields["status"] = $data["status"];
    
    $condition = "productId = $productId AND userId = " . Session::get("userId");
    return $this->dbController->QueryDB("product", $fields, "update", $condition);
  }

  public function deleteProduct($productId)
  {
    $condition = "productId = $productId AND userId = " . Session::get("userId");
    return $this->dbController->QueryDB("product", array("status" => 0), "update", $condition);
  }

  public function toggleFavorite($productId)
  {
    $userId = Session::get("userId");
    $fields = array("favoriteId");
    $condition = "userId = $userId AND productId = $productId";
    $rs = $this->dbController->QueryDB("favorite", $fields, "query", $condition);
    
    if (mysqli_num_rows($rs) > 0) {
      $this->dbController->QueryDB("favorite", array("userId" => $userId, "productId" => $productId), "delete", $condition);
      return array("favorited" => false);
    } else {
      $now = date('Y-m-d H:i:s');
      $this->dbController->QueryDB("favorite", array(
        "userId" => $userId,
        "productId" => $productId,
        "createdDate" => $now
      ), "insert");
      return array("favorited" => true);
    }
  }

  public function getFavorites($userId)
  {
    $fields = array(
      "f.favoriteId",
      "f.productId",
      "f.createdDate",
      "p.refId",
      "p.listingTitle",
      "p.price",
      "p.status"
    );
    $condition = "f.userId = $userId AND p.status = 1";
    $joinTables = array(" LEFT JOIN product p ON f.productId = p.productId");
    $orderBy = " f.createdDate desc";
    $rs = $this->dbController->QueryDB("favorite f", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
    $favorites = array();
    while ($row = mysqli_fetch_array($rs)) {
      $imageRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $image = "";
      if ($imgRow = mysqli_fetch_array($imageRs)) {
        $image = $imgRow["path"];
      }
      $row["image"] = $image;
      array_push($favorites, $row);
    }
    return $favorites;
  }

  public function saveSearch($keyword, $fcId = 0, $scId = 0)
  {
    $userId = Session::get("userId");
    
    // Check limit (10 instead of Carousell's 3)
    $countRs = $this->dbController->QueryDB("saved_search", array("COUNT(*) as cnt"), "query", "userId = $userId", null, null, null, false);
    $countRow = mysqli_fetch_array($countRs);
    if ($countRow["cnt"] >= 10) {
      return array("success" => false, "message" => "savedSearchLimit");
    }
    
    $now = date('Y-m-d H:i:s');
    $this->dbController->QueryDB("saved_search", array(
      "userId" => $userId,
      "keyword" => $keyword,
      "fcId" => $fcId,
      "scId" => $scId,
      "createdDate" => $now
    ), "insert");
    
    return array("success" => true);
  }

  public function getSavedSearches($userId)
  {
    $fields = array("searchId", "keyword", "fcId", "scId", "createdDate");
    $condition = "userId = $userId";
    $orderBy = " createdDate desc";
    $rs = $this->dbController->QueryDB("saved_search", $fields, "query", $condition, null, $orderBy, null, false);
    
    $searches = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($searches, $row);
    }
    return $searches;
  }

  public function deleteSavedSearch($searchId)
  {
    $userId = Session::get("userId");
    $condition = "searchId = $searchId AND userId = $userId";
    return $this->dbController->QueryDB("saved_search", array("searchId" => $searchId), "delete", $condition);
  }
}
?>
