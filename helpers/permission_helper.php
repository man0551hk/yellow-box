<?php
class Permission {
  public static function GetXApiKey() {
    include 'config/config.php';
    return $xApiKey;
  }

  private static $functionPermission = array (
    //functionName => permissionId
    'top' => [1],
  );

  private static $pagePermission = array(
    //pageName => permissionId
    'top.php' => [1],
  );

  private static function EnablePermissionCheck() {
    include 'config/config.php';
    return $enablePermissionCheck;
  }

  public static function PermissionCheck($function, $permissionId, $type ) {
    if (self::EnablePermissionCheck() == true) {
      if ($type == "func") {
        if (in_array($permissionId, self::$functionPermission[$function])) {
          return true;
        }
        return false;
      } else if ($type == "page") {
        if (in_array($permissionId, self::$pagePermission[$function])) {
          return true;
        }
        return false;
      }
    }
    return true;
  }
}

?>