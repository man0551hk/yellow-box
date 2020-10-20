<?php
class Lang {
  public static $en = array(
    "title" => "YellowHub",
    "categories" => "Categories",
    "login" => "Login",
    "signup" => "Sign Up",
    "profile" => "Profile",
    "user" => "User",
    "firstName" => "First Name",
    "lastName" => "Last Name",
    "email" => "Email",
    "password" => "Password",
    "confirmPassword" => "Re-enter Password",
    "forgotPassword" => "Forgot Password",
    "alreadyHaveAnAccount?" => "Already have an account?",
    "dontHaveAnAccount?" => "Don't have an account ?",
    "sell" => "Sell",
    "privacy" => "Privacy Settings",
    "sellBanner" => "What are you listing today?",
    "inboxBanner" => "Chat",
    "all" => "All",
    "keywords" => "Keywords",
    "price" => "Price",
    "status" => "Status",
    "brandnew" => "Brand New",
    "secondhand" => "Second Hand",
    "filters" => "Detail Filters",
    "update" => "Update",
    "defaultSorting" => "Default Sorting",
    "low2high" => "Price: low to high",
    "high2low" => "Price: high to low",
    "passwordNotice" => "Password must contain Minimum 8 characters at least 1 Alphabet and 1 Number",
    "confirmPasswordError" => "Confirm Password doesn\'t match",
    "thankSignUp" => "Thanks for your signup, the activate email will be sent to you soon",
    "emailExisted" => "Email already registered",
    "verifySuccess" => "Verify Successful, please click <a href = 'javascript:CloseModal(\"isVerify\");OpenModal(\"login\")'>here</a> to login",
    "editProfile" => "Edit profile",
    "latest" => "Latest Post",
    "hot" => "Most Favorite"
  );

  public static $tc = array(
    "title" => "黃盒",
    "categories" => "分類",
    "login" => "登入",
    "signup" => "成為會員",
    "profile" => "個人檔案",
    "user" => "用戶",
    "firstName" => "名",
    "lastName" => "姓",
    "email" => "電郵",
    "password" => "密碼",
    "forgotPassword" => "忘記密碼",
    "confirmPassword" => "確認密碼",
    "alreadyHaveAnAccount?" => "已有帳戶？",
    "dontHaveAnAccount?" => "沒有帳戶?",
    "sell" => "賣嘢",
    "privacy" => "隱私設置",
    "sellBanner" => "你今日想賣咩嘢呀？",
    "inboxBanner" => "傾下計",
    "all" => "所有分類",
    "keywords" => "搜尋關鍵字",
    "price" => "價錢",
    "status" => "狀態",
    "brandnew" => "全新",
    "secondhand" => "二手品",
    "filters" => "詳細分類",
    "update" => "更新",
    "defaultSorting" => "預設",
    "low2high" => "價錢: 低至高",
    "high2low" => "價錢: 高至低",
    "passwordNotice" => "密碼最少8個字元，包含1個字母及1個數字",
    "confirmPasswordError" => "確認密碼錯誤",
    "thankSignUp" => "感謝你的登記，啟動電郵將會很快發送給你",
    "emailExisted" => "電郵已登記",
    "verifySuccess" => "啟動成功, 請<a href = 'javascript:CloseModal(\"isVerify\");OpenModal(\"login\")'>按此登入</a>",
    "editProfile" => "修改個人資料",
    "latest" => "最新刊登",
    "hot" => "最多人喜愛"
  );

  public static $lang = array();

  public static function SetLang($L) {
    if ($L == 'tc') {
      self::$lang = self::$tc;
    } else {
      self::$lang = self::$en;
    }
  }

  public static $pageHeaderSet = array(
    "categoryList.php" => "Category List",
  );

  public static function GetPageTitle($pageName) {
    return self::$pageHeaderSet[$pageName];
  }

  public static function ReturnCorrectLang($tc, $en) {
    if (Session::get("lang") == "tc" ) {
      return $tc;
    }
    return $en;
  }
}
?>