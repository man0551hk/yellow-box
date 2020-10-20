<?php
class UserController
{
  private $dbController;
  private $commonController;
  public $pageName = "";
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function CheckEamilExisted() {
    $data = array(
      "isExisted" => 1
    );
    if (isset($_POST["email"])) {
      $fields = array("userId");
      $email = $_POST["email"];
      $condition = " email = '$email'";
      $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
      $data["isExisted"] = mysqli_num_rows($rs);
    }
    $this->commonController->ReturnJson($data);
  }

  public function SaveUser() {
    $verifyCode = Cookie::RandomValue();
    $fields = array(
      "firstName" => $_POST["firstName"],
      "lastName" => $_POST["lastName"],
      "password" => Encrypt::encryptIt( $_POST["password"] ),
      "email" => $_POST["email"],
      "isVerify"  => 0,
      "profilePic" => "",
      "verifyCode" => $verifyCode
    );
    $userId = $this->dbController->QueryDB("user", $fields, "insert");

    $fields = array("seo");
    $seo = strtolower($_POST["firstName"].$_POST["lastName"]);
    $condition = " seo = '$seo'";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    if (mysqli_num_rows($rs) > 0) {
      $seo .= $userId;
    } 
    $fields = array("seo" => $seo);
    $condition = " userId = $userId";
    $this->dbController->QueryDB("user", $fields, "update", $condition);

    //send verify email
    $urlEn = "<a href = '" . Url::getDomain() . "en/verify/?key=" . $verifyCode . "&key2=" . Encrypt::encryptIt($userId) . "'>here</a>";
    $urlTc = "<a href = '" . Url::getDomain() . "verify/?key=" . $verifyCode . "&key2=" . Encrypt::encryptIt($userId) . "'>按此</a>";
    $content = "Dear, <br/>";
    $content .= "please click ". $urlEn . " to activiate your account<br/><br/>";
    $content .= "Regards,<br/>";
    $content .= "Yellow Hub<br/><br/><br/>";

    $content .= "你好, <br/>";
    $content .= "請" . $urlTc . "啟動帳戶<br/><br/>";
    $content .= "謹啟,<br/>";
    $content .= "黃盒<br/>";
    Email::SendEmail($content,  $_POST["email"], "啟動帳戶 Activiate Account");
  }

  public function Login() {
    $fields = array("userId", "firstName", "lastName", "profilePic", "password", "seo");
    $email = $_POST["email"];
    $password = $_POST["password"];
    $condition = " email = '$email'";
    $rs = $this->dbController->QueryDB("user", $fields, "query", $condition);
    if ($row = mysqli_fetch_array($rs)) {
      if (Encrypt::decryptIt($row["password"]) == $password) {
        Session::set("userId", $row["userId"]);
        Session::set("firstName", $row["firstName"]);
        Session::set("lastName", $row["lastName"]);
        Session::set("profilePic", $row["profilePic"]);
        Session::set("profileId", $row["seo"]);
        $user = array(
          "userId" => $row["userId"],
          "firstName" => $row["firstName"],
          "lastName" => $row["lastName"],
          "profilePic" => $row["profilePic"],
          "profileId" => $row["seo"]
        );
        Cookie::set("user", urlencode(JSON_encode($user)));
        Url::redirect("");
      }
    }
  }

  public function CookieLogin () {
    $cookieUser = Cookie::get("user");
    $cookieUser = urldecode($cookieUser);
    $cookieUser = json_decode($cookieUser);
    if (isset($cookieUser)) {
      Session::set("userId", $cookieUser->userId);
      Session::set("firstName", $cookieUser->firstName);
      Session::set("lastName", $cookieUser->lastName);
      Session::set("profilePic", $cookieUser->profilePic);
      Session::set("profileId", $cookieUser->profileId);
    }
  }
}
?>