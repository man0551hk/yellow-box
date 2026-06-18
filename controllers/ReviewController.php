<?php
class ReviewController
{
  private $dbController;

  public function __construct($dbController)
  {
    $this->dbController = $dbController;
  }

  /**
   * Submit a review for a completed purchase
   */
  public function submitReview($intentId, $fromUserId, $toUserId, $productId, $rating, $comment = '')
  {
    // Validate rating
    $rating = intval($rating);
    if ($rating < 1 || $rating > 5) {
      return array("success" => false, "message" => Lang::$lang["invalidRating"]);
    }

    // Check if intent exists and is confirmed
    $rs = $this->dbController->QueryDB("purchase_intent", array("intentId", "status"), "query", 
      "intentId = $intentId AND status = 'confirmed'", null, null, null, false);
    
    if (!$row = mysqli_fetch_array($rs)) {
      return array("success" => false, "message" => Lang::$lang["intentNotFound"]);
    }

    // Check if already reviewed
    $checkRs = $this->dbController->QueryDB("review", array("reviewId"), "query", 
      "intentId = $intentId AND fromUserId = $fromUserId", null, null, null, false);
    if (mysqli_num_rows($checkRs) > 0) {
      return array("success" => false, "message" => Lang::$lang["alreadyReviewed"]);
    }

    $now = date('Y-m-d H:i:s');
    $this->dbController->QueryDB("review", array(
      "productId" => $productId,
      "fromUserId" => $fromUserId,
      "toUserId" => $toUserId,
      "intentId" => $intentId,
      "rating" => $rating,
      "comment" => $comment,
      "createdDate" => $now
    ), "insert");

    // Update user's average rating
    $this->updateUserRating($toUserId);

    return array("success" => true, "message" => Lang::$lang["reviewSubmitted"]);
  }

  /**
   * Get reviews for a user
   */
  public function getUserReviews($userId)
  {
    $fields = array(
      "r.reviewId",
      "r.rating",
      "r.comment",
      "r.createdDate",
      "r.fromUserId",
      "r.productId",
      "u.firstName",
      "u.lastName",
      "u.profilePic",
      "u.seo",
      "p.refId",
      "p.listingTitle"
    );
    $condition = "r.toUserId = $userId";
    $joinTables = array(
      " LEFT JOIN user u ON r.fromUserId = u.userId",
      " LEFT JOIN product p ON r.productId = p.productId"
    );
    $orderBy = " r.createdDate desc";
    $rs = $this->dbController->QueryDB("review r", $fields, "query", $condition, $joinTables, $orderBy, null, false);

    $reviews = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($reviews, $row);
    }
    return $reviews;
  }

  /**
   * Update user's average rating
   */
  private function updateUserRating($userId)
  {
    $rs = $this->dbController->QueryDB("review", array("AVG(rating) as avgRating", "COUNT(*) as total"), "query", 
      "toUserId = $userId", null, null, null, false);
    
    if ($row = mysqli_fetch_array($rs)) {
      $avg = round($row["avgRating"], 2);
      $count = $row["total"];
      $this->dbController->QueryDB("user", array(
        "ratingAvg" => $avg,
        "ratingCount" => $count
      ), "update", "userId = $userId");
    }
  }
}
