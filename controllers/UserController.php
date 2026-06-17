<?php
class UserController
{
  private $dbController;

  public function __construct($dbController)
  {
    $this->dbController = $dbController;
  }

  public function login($email, $password)
  {
    $fields = array("userId", "firstName", "lastName", "password", "email", "isVerify", "profilePic", "seo", "phone");
    $condition = "email = '" . $this->dbController->escapeString($email) . "'";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    
    if ($row = mysqli_fetch_array($rs)) {
      if (Encrypt::verifyPassword($password, $row["password"])) {
        Session::set("userId", $row["userId"]);
        Session::set("firstName", $row["firstName"]);
        Session::set("lastName", $row["lastName"]);
        Session::set("email", $row["email"]);
        Session::set("isVerify", $row["isVerify"]);
        Session::set("profilePic", $row["profilePic"]);
        Session::set("profileId", $row["seo"]);
        Session::set("phone", $row["phone"]);
        
        return array("success" => true);
      }
    }
    return array("success" => false, "message" => Lang::$lang["invalidCredentials"]);
  }

  public function register($data)
  {
    // Check if email exists
    $fields = array("userId");
    $condition = "email = '" . $this->dbController->escapeString($data["email"]) . "'";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    if (mysqli_num_rows($rs) > 0) {
      return array("success" => false, "message" => Lang::$lang["emailExisted"]);
    }

    // Validate password
    if (strlen($data["password"]) < 8 || !preg_match('/[A-Za-z]/', $data["password"]) || !preg_match('/[0-9]/', $data["password"])) {
      return array("success" => false, "message" => Lang::$lang["passwordNotice"]);
    }

    // Check confirm password
    if ($data["password"] != $data["confirmPassword"]) {
      return array("success" => false, "message" => Lang::$lang["confirmPasswordError"]);
    }

    $hashedPassword = Encrypt::hashPassword($data["password"]);
    $verifyCode = substr(md5(uniqid()), 0, 16);
    $seo = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $data["firstName"] . $data["lastName"])) . rand(100, 999);

    $fields = array(
      "firstName" => $data["firstName"],
      "lastName" => $data["lastName"],
      "password" => $hashedPassword,
      "email" => $data["email"],
      "isVerify" => 0,
      "profilePic" => "",
      "verifyCode" => $verifyCode,
      "seo" => $seo
    );

    $userId = $this->dbController->QueryDB("user", $fields, "insert");
    
    // Send verification email
    $this->sendVerificationEmail($data["email"], $verifyCode);

    return array("success" => true, "message" => Lang::$lang["accountCreated"]);
  }

  public function verifyEmail($code)
  {
    $fields = array("userId", "email");
    $condition = "verifyCode = '" . $this->dbController->escapeString($code) . "' AND isVerify = 0";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    
    if ($row = mysqli_fetch_array($rs)) {
      $this->dbController->QueryDB("user", array("isVerify" => 1), "update", "userId = " . $row["userId"]);
      return array("success" => true, "message" => Lang::$lang["verifySuccess"]);
    }
    return array("success" => false, "message" => "Invalid or expired verification code");
  }

  public function updateProfile($data)
  {
    $userId = Session::get("userId");
    $fields = array();
    
    if (isset($data["firstName"])) $fields["firstName"] = $data["firstName"];
    if (isset($data["lastName"])) $fields["lastName"] = $data["lastName"];
    if (isset($data["phone"])) $fields["phone"] = $data["phone"];
    
    if (!empty($fields)) {
      $this->dbController->QueryDB("user", $fields, "update", "userId = $userId");
      
      // Update session
      if (isset($data["firstName"])) Session::set("firstName", $data["firstName"]);
      if (isset($data["lastName"])) Session::set("lastName", $data["lastName"]);
      if (isset($data["phone"])) Session::set("phone", $data["phone"]);
    }
    
    return array("success" => true, "message" => Lang::$lang["profileUpdated"]);
  }

  public function getUserById($userId)
  {
    $fields = array("userId", "firstName", "lastName", "email", "profilePic", "seo", "phone", "lastActive", "responseTime", "responseRate");
    $condition = "userId = $userId";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    return mysqli_fetch_array($rs);
  }

  public function getUserBySeo($seo)
  {
    $fields = array("userId", "firstName", "lastName", "email", "profilePic", "seo", "phone", "lastActive", "responseTime", "responseRate");
    $condition = "seo = '" . $this->dbController->escapeString($seo) . "'";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    return mysqli_fetch_array($rs);
  }

  public function updateLastActive()
  {
    $userId = Session::get("userId");
    if ($userId) {
      $now = date('Y-m-d H:i:s');
      $this->dbController->QueryDB("user", array("lastActive" => $now), "update", "userId = $userId");
    }
  }

  // Follow / Unfollow
  public function toggleFollow($followingId)
  {
    $userId = Session::get("userId");
    if ($userId == $followingId) {
      return array("success" => false, "message" => "Cannot follow yourself");
    }
    
    $rs = $this->dbController->QueryDB("user_follow", array("followId"), "query", "followerId = $userId AND followingId = $followingId");
    if (mysqli_num_rows($rs) > 0) {
      $this->dbController->QueryDB("user_follow", array("followerId" => $userId, "followingId" => $followingId), "delete", "followerId = $userId AND followingId = $followingId");
      return array("success" => true, "following" => false);
    } else {
      $now = date('Y-m-d H:i:s');
      $this->dbController->QueryDB("user_follow", array(
        "followerId" => $userId,
        "followingId" => $followingId,
        "createdDate" => $now
      ), "insert");
      
      // Create notification for followed user
      $this->createNotification($followingId, "newFollower", Session::get("firstName") . " " . Session::get("lastName") . " started following you", $userId);
      
      return array("success" => true, "following" => true);
    }
  }

  public function isFollowing($followerId, $followingId)
  {
    $rs = $this->dbController->QueryDB("user_follow", array("followId"), "query", "followerId = $followerId AND followingId = $followingId");
    return mysqli_num_rows($rs) > 0;
  }

  public function getFollowers($userId)
  {
    $fields = array("f.followerId", "u.firstName", "u.lastName", "u.profilePic", "u.seo");
    $condition = "f.followingId = $userId";
    $joinTables = array(" LEFT JOIN user u ON f.followerId = u.userId");
    $orderBy = " f.createdDate desc";
    $rs = $this->dbController->QueryDB("user_follow f", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
    $followers = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($followers, $row);
    }
    return $followers;
  }

  public function getFollowing($userId)
  {
    $fields = array("f.followingId", "u.firstName", "u.lastName", "u.profilePic", "u.seo");
    $condition = "f.followerId = $userId";
    $joinTables = array(" LEFT JOIN user u ON f.followingId = u.userId");
    $orderBy = " f.createdDate desc";
    $rs = $this->dbController->QueryDB("user_follow f", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
    $following = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($following, $row);
    }
    return $following;
  }

  public function getFollowerCount($userId)
  {
    $rs = $this->dbController->QueryDB("user_follow", array("COUNT(*) as cnt"), "query", "followingId = $userId");
    $row = mysqli_fetch_array($rs);
    return $row["cnt"];
  }

  public function getFollowingCount($userId)
  {
    $rs = $this->dbController->QueryDB("user_follow", array("COUNT(*) as cnt"), "query", "followerId = $userId");
    $row = mysqli_fetch_array($rs);
    return $row["cnt"];
  }

  // Block / Unblock
  public function toggleBlock($blockedUserId)
  {
    $userId = Session::get("userId");
    if ($userId == $blockedUserId) {
      return array("success" => false, "message" => "Cannot block yourself");
    }
    
    $rs = $this->dbController->QueryDB("user_block", array("blockId"), "query", "userId = $userId AND blockedUserId = $blockedUserId");
    if (mysqli_num_rows($rs) > 0) {
      $this->dbController->QueryDB("user_block", array("userId" => $userId, "blockedUserId" => $blockedUserId), "delete", "userId = $userId AND blockedUserId = $blockedUserId");
      return array("success" => true, "blocked" => false);
    } else {
      $now = date('Y-m-d H:i:s');
      $this->dbController->QueryDB("user_block", array(
        "userId" => $userId,
        "blockedUserId" => $blockedUserId,
        "createdDate" => $now
      ), "insert");
      return array("success" => true, "blocked" => true);
    }
  }

  public function isBlocked($userId, $blockedUserId)
  {
    $rs = $this->dbController->QueryDB("user_block", array("blockId"), "query", "userId = $userId AND blockedUserId = $blockedUserId");
    return mysqli_num_rows($rs) > 0;
  }

  public function getBlockedUsers($userId)
  {
    $fields = array("b.blockedUserId", "u.firstName", "u.lastName", "u.profilePic", "u.seo");
    $condition = "b.userId = $userId";
    $joinTables = array(" LEFT JOIN user u ON b.blockedUserId = u.userId");
    $orderBy = " b.createdDate desc";
    $rs = $this->dbController->QueryDB("user_block b", $fields, "query", $condition, $joinTables, $orderBy, null, false);
    
    $blocked = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($blocked, $row);
    }
    return $blocked;
  }

  // Notifications
  public function createNotification($userId, $type, $message, $relatedId = null)
  {
    $now = date('Y-m-d H:i:s');
    $relatedIdStr = $relatedId ? $relatedId : "NULL";
    $this->dbController->DirectQuery("INSERT INTO notification (userId, type, message, relatedId, isRead, createdDate) VALUES ($userId, '$type', '" . $this->dbController->escapeString($message) . "', $relatedIdStr, 0, '$now')");
  }

  public function getNotifications($userId, $limit = 20)
  {
    $fields = array("notificationId", "type", "message", "relatedId", "isRead", "createdDate");
    $condition = "userId = $userId";
    $orderBy = " createdDate desc";
    $rs = $this->dbController->QueryDB("notification", $fields, "query", $condition, null, $orderBy, null, false);
    
    $notifications = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      array_push($notifications, $row);
      $count++;
    }
    return $notifications;
  }

  public function getUnreadNotificationCount($userId)
  {
    $rs = $this->dbController->QueryDB("notification", array("COUNT(*) as cnt"), "query", "userId = $userId AND isRead = 0");
    $row = mysqli_fetch_array($rs);
    return $row["cnt"];
  }

  public function markNotificationRead($notificationId)
  {
    $userId = Session::get("userId");
    $this->dbController->QueryDB("notification", array("isRead" => 1), "update", "notificationId = $notificationId AND userId = $userId");
    return array("success" => true);
  }

  public function markAllNotificationsRead()
  {
    $userId = Session::get("userId");
    $this->dbController->QueryDB("notification", array("isRead" => 1), "update", "userId = $userId AND isRead = 0");
    return array("success" => true);
  }

  // Search History
  public function addSearchHistory($keyword)
  {
    $userId = Session::get("userId");
    if (!$userId || !$keyword) return;
    
    $now = date('Y-m-d H:i:s');
    $this->dbController->QueryDB("search_history", array(
      "userId" => $userId,
      "keyword" => $keyword,
      "createdDate" => $now
    ), "insert");
  }

  public function getSearchHistory($userId, $limit = 20)
  {
    $fields = array("historyId", "keyword", "createdDate");
    $condition = "userId = $userId";
    $orderBy = " createdDate desc";
    $rs = $this->dbController->QueryDB("search_history", $fields, "query", $condition, null, $orderBy, null, false);
    
    $history = array();
    $count = 0;
    while ($count < $limit && ($row = mysqli_fetch_array($rs))) {
      array_push($history, $row);
      $count++;
    }
    return $history;
  }

  public function clearSearchHistory()
  {
    $userId = Session::get("userId");
    $this->dbController->QueryDB("search_history", array("userId" => $userId), "delete", "userId = $userId");
    return array("success" => true);
  }

  // Product Report
  public function reportProduct($productId, $reason)
  {
    $userId = Session::get("userId");
    $now = date('Y-m-d H:i:s');
    $this->dbController->QueryDB("product_report", array(
      "productId" => $productId,
      "userId" => $userId,
      "reason" => $reason,
      "status" => 0,
      "createdDate" => $now
    ), "insert");
    return array("success" => true, "message" => Lang::$lang["reportSubmitted"]);
  }


  private function sendVerificationEmail($email, $code)
  {
    $subject = "Yellow Hub - Email Verification";
    $link = Url::getDomain() . "verify/" . $code . "/";
    $message = "
      <html>
      <body>
        <h2>Welcome to Yellow Hub!</h2>
        <p>Please click the link below to verify your email address:</p>
        <p><a href='$link'>$link</a></p>
        <p>If you did not create an account, please ignore this email.</p>
      </body>
      </html>
    ";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: noreply@yellowhk.com\r\n";
    
    mail($email, $subject, $message, $headers);
  }
}
?>
