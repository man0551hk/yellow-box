<?php
class PurchaseController
{
  private $dbController;

  public function __construct($dbController)
  {
    $this->dbController = $dbController;
  }

  /**
   * Buyer expresses intent to purchase a product
   */
  public function createIntent($productId, $buyerId, $sellerId)
  {
    // Check if already has a pending intent for this product
    $rs = $this->dbController->QueryDB("purchase_intent", array("intentId", "status"), "query", 
      "productId = $productId AND buyerId = $buyerId AND status IN ('pending', 'confirmed')", null, null, null, false);
    
    if ($row = mysqli_fetch_array($rs)) {
      if ($row['status'] == 'pending') {
        return array("success" => false, "message" => Lang::$lang["purchasePending"]);
      } elseif ($row['status'] == 'confirmed') {
        return array("success" => false, "message" => Lang::$lang["purchaseAlreadyConfirmed"]);
      }
    }

    $now = date('Y-m-d H:i:s');
    $intentId = $this->dbController->QueryDB("purchase_intent", array(
      "productId" => $productId,
      "buyerId" => $buyerId,
      "sellerId" => $sellerId,
      "status" => "pending",
      "createdDate" => $now
    ), "insert");

    // Create notification for seller
    $buyerName = Session::get("firstName") . " " . Session::get("lastName");
    $this->createNotification($sellerId, "purchaseIntent", $buyerName . " " . Lang::$lang["wantsToBuy"], $productId);

    return array("success" => true, "intentId" => $intentId, "message" => Lang::$lang["purchaseIntentSent"]);
  }

  /**
   * Seller confirms the buyer's purchase intent
   */
  public function confirmIntent($intentId, $sellerId)
  {
    $rs = $this->dbController->QueryDB("purchase_intent", array("intentId", "buyerId", "productId", "status"), "query", 
      "intentId = $intentId AND sellerId = $sellerId", null, null, null, false);
    
    if (!$row = mysqli_fetch_array($rs)) {
      return array("success" => false, "message" => Lang::$lang["intentNotFound"]);
    }

    if ($row['status'] != 'pending') {
      return array("success" => false, "message" => Lang::$lang["intentAlreadyProcessed"]);
    }

    $now = date('Y-m-d H:i:s');
    $this->dbController->QueryDB("purchase_intent", array(
      "status" => "confirmed",
      "confirmedDate" => $now
    ), "update", "intentId = $intentId");

    // Mark product as sold
    $this->dbController->QueryDB("product", array("isSold" => 1, "status" => 2), "update", "productId = " . $row["productId"]);

    // Notify buyer
    $this->createNotification($row["buyerId"], "purchaseConfirmed", Lang::$lang["sellerConfirmedPurchase"], $row["productId"]);

    return array("success" => true, "message" => Lang::$lang["purchaseConfirmed"]);
  }

  /**
   * Get pending purchase intents for a seller
   */
  public function getSellerPendingIntents($sellerId)
  {
    $fields = array(
      "pi.intentId",
      "pi.productId",
      "pi.buyerId",
      "pi.status",
      "pi.createdDate",
      "p.refId",
      "p.listingTitle",
      "p.price"
    );
    $condition = "pi.sellerId = $sellerId AND pi.status = 'pending'";
    $joinTables = array(" LEFT JOIN product p ON pi.productId = p.productId");
    $orderBy = " pi.createdDate desc";
    $rs = $this->dbController->QueryDB("purchase_intent pi", $fields, "query", $condition, $joinTables, $orderBy, null, false);

    $intents = array();
    while ($row = mysqli_fetch_array($rs)) {
      // Get buyer info
      $buyerRs = $this->dbController->QueryDB("user", array("userId", "firstName", "lastName", "profilePic", "seo"), "query", "userId = " . $row["buyerId"], null, null, null, false);
      $buyer = mysqli_fetch_array($buyerRs);
      
      // Get product image
      $imgRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $productImage = "";
      if ($imgRow = mysqli_fetch_array($imgRs)) {
        $productImage = $imgRow["path"];
      }
      
      // Flatten for JSON response
      $intent = array(
        "intentId" => $row["intentId"],
        "productId" => $row["productId"],
        "buyerId" => $row["buyerId"],
        "status" => $row["status"],
        "createdDate" => $row["createdDate"],
        "productRefId" => $row["refId"],
        "productTitle" => $row["listingTitle"],
        "productPrice" => $row["price"],
        "productImage" => $productImage,
        "buyerFirstName" => $buyer["firstName"],
        "buyerLastName" => $buyer["lastName"],
        "buyerProfilePic" => $buyer["profilePic"],
        "buyerSeo" => $buyer["seo"]
      );
      
      array_push($intents, $intent);
    }
    return $intents;
  }

  /**
   * Get purchase intents for a buyer
   */
  public function getBuyerIntents($buyerId)
  {
    $fields = array(
      "pi.intentId",
      "pi.productId",
      "pi.sellerId",
      "pi.status",
      "pi.createdDate",
      "pi.confirmedDate",
      "p.refId",
      "p.listingTitle",
      "p.price"
    );
    $condition = "pi.buyerId = $buyerId";
    $joinTables = array(" LEFT JOIN product p ON pi.productId = p.productId");
    $orderBy = " pi.createdDate desc";
    $rs = $this->dbController->QueryDB("purchase_intent pi", $fields, "query", $condition, $joinTables, $orderBy, null, false);

    $intents = array();
    while ($row = mysqli_fetch_array($rs)) {
      // Get seller info
      $sellerRs = $this->dbController->QueryDB("user", array("userId", "firstName", "lastName", "profilePic", "seo"), "query", "userId = " . $row["sellerId"], null, null, null, false);
      $seller = mysqli_fetch_array($sellerRs);
      
      // Get product image
      $imgRs = $this->dbController->QueryDB("productImage", array("path"), "query", "productId = " . $row["productId"], null, "orderId asc", null, false);
      $productImage = "";
      if ($imgRow = mysqli_fetch_array($imgRs)) {
        $productImage = $imgRow["path"];
      }
      
      // Flatten for JSON response
      $intent = array(
        "intentId" => $row["intentId"],
        "productId" => $row["productId"],
        "sellerId" => $row["sellerId"],
        "status" => $row["status"],
        "createdDate" => $row["createdDate"],
        "confirmedDate" => isset($row["confirmedDate"]) ? $row["confirmedDate"] : null,
        "productRefId" => $row["refId"],
        "productTitle" => $row["listingTitle"],
        "productPrice" => $row["price"],
        "productImage" => $productImage,
        "sellerFirstName" => $seller["firstName"],
        "sellerLastName" => $seller["lastName"],
        "sellerProfilePic" => $seller["profilePic"],
        "sellerSeo" => $seller["seo"]
      );
      
      array_push($intents, $intent);
    }
    return $intents;
  }

  /**
   * Check if user has already expressed purchase intent for a product
   */
  public function hasPendingIntent($productId, $buyerId)
  {
    $rs = $this->dbController->QueryDB("purchase_intent", array("intentId", "status"), "query", 
      "productId = $productId AND buyerId = $buyerId AND status IN ('pending', 'confirmed')", null, null, null, false);
    return mysqli_fetch_array($rs);
  }

  /**
   * Get completed intents (for rating)
   */
  public function getCompletedIntentsForUser($userId)
  {
    $fields = array(
      "pi.intentId",
      "pi.productId",
      "pi.buyerId",
      "pi.sellerId",
      "pi.confirmedDate",
      "p.refId",
      "p.listingTitle"
    );
    $condition = "(pi.buyerId = $userId OR pi.sellerId = $userId) AND pi.status = 'confirmed'";
    $joinTables = array(" LEFT JOIN product p ON pi.productId = p.productId");
    $orderBy = " pi.confirmedDate desc";
    $rs = $this->dbController->QueryDB("purchase_intent pi", $fields, "query", $condition, $joinTables, $orderBy, null, false);

    $intents = array();
    while ($row = mysqli_fetch_array($rs)) {
      // Check if user already left a review
      $reviewRs = $this->dbController->QueryDB("review", array("reviewId"), "query", 
        "intentId = " . $row["intentId"] . " AND fromUserId = $userId", null, null, null, false);
      $row["hasReviewed"] = mysqli_num_rows($reviewRs) > 0;
      
      // Get the other user info
      $otherUserId = ($row["buyerId"] == $userId) ? $row["sellerId"] : $row["buyerId"];
      $otherRs = $this->dbController->QueryDB("user", array("userId", "firstName", "lastName", "profilePic", "seo"), "query", "userId = $otherUserId", null, null, null, false);
      $row["otherUser"] = mysqli_fetch_array($otherRs);
      
      array_push($intents, $row);
    }
    return $intents;
  }

  private function createNotification($userId, $type, $message, $relatedId = null)
  {
    $now = date('Y-m-d H:i:s');
    $relatedIdStr = $relatedId ? $relatedId : "NULL";
    $this->dbController->DirectQuery("INSERT INTO notification (userId, type, message, relatedId, isRead, createdDate) VALUES ($userId, '$type', '" . $this->dbController->escapeString($message) . "', $relatedIdStr, 0, '$now')");
  }
}
