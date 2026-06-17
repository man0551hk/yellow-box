<?php
class MessageController
{
  private $dbController;

  public function __construct($dbController)
  {
    $this->dbController = $dbController;
  }

  public function sendMessage($fromUserId, $toUserId, $content)
  {
    $now = date('Y-m-d H:i:s');
    $fields = array(
      "fromUserId" => $fromUserId,
      "toUserId" => $toUserId,
      "content" => $content,
      "status" => 0,
      "sentDate" => $now
    );
    $this->dbController->QueryDB("message", $fields, "insert");
    return array("success" => true, "message" => Lang::$lang["messageSent"]);
  }

  public function getMessages($userId, $otherUserId)
  {
    $fields = array("m.messageId", "m.fromUserId", "m.toUserId", "m.content", "m.status", "m.sentDate");
    $condition = "(m.fromUserId = $userId AND m.toUserId = $otherUserId) OR (m.fromUserId = $otherUserId AND m.toUserId = $userId)";
    $orderBy = " m.sentDate asc";
    $rs = $this->dbController->QueryDB("message m", $fields, "query", $condition, null, $orderBy, null, false);
    
    // Mark messages as read
    $this->dbController->QueryDB("message", array("status" => 1), "update", "fromUserId = $otherUserId AND toUserId = $userId AND status = 0");
    
    $messages = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($messages, $row);
    }
    return $messages;
  }

  public function getConversations($userId)
  {
    // Get unique conversation partners
    $sql = "SELECT DISTINCT 
              CASE WHEN m.fromUserId = $userId THEN m.toUserId ELSE m.fromUserId END as otherUserId,
              (SELECT content FROM message WHERE (fromUserId = $userId AND toUserId = otherUserId) OR (fromUserId = otherUserId AND toUserId = $userId) ORDER BY sentDate DESC LIMIT 1) as lastMessage,
              (SELECT sentDate FROM message WHERE (fromUserId = $userId AND toUserId = otherUserId) OR (fromUserId = otherUserId AND toUserId = $userId) ORDER BY sentDate DESC LIMIT 1) as lastDate,
              (SELECT COUNT(*) FROM message WHERE fromUserId = otherUserId AND toUserId = $userId AND status = 0) as unread
            FROM message m
            WHERE m.fromUserId = $userId OR m.toUserId = $userId";
    
    $rs = $this->dbController->QueryDB("($sql) as conv", array("*"), "query", null, null, "lastDate desc", null, false);
    
    $conversations = array();
    while ($row = mysqli_fetch_array($rs)) {
      $user = $this->dbController->QueryDB("user", array("userId", "firstName", "lastName", "profilePic", "seo"), "query", "userId = " . $row["otherUserId"], null, null, null, false);
      $userRow = mysqli_fetch_array($user);
      $row["user"] = $userRow;
      array_push($conversations, $row);
    }
    return $conversations;
  }

  public function getUnreadCount($userId)
  {
    $rs = $this->dbController->QueryDB("message", array("COUNT(*) as cnt"), "query", "toUserId = $userId AND status = 0", null, null, null, false);
    $row = mysqli_fetch_array($rs);
    return $row["cnt"];
  }
}
?>
