<?php
class DbConnection {

  public $link;

  public function __construct() {
    $this->link = $this->Getconnection();
  }

  public function GetConnection() {  
    include 'config/config.php';
    $link = mysqli_connect($hostName, $userName, $password, $dbName);
    mysqli_query($link, "SET NAMES 'utf8'");
    mysqli_query($link, "SET time_zone = '+8:00';");
    return $link;
  }

  public function DoQuery($link, $query) {
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)){
      mysqli_error($link);
    } else {
      return $result;
    }
  }

  public function DoQueryInsertId($link, $query) {
    mysqli_query($link, $query);
    if (mysqli_errno($link)){
      echo mysqli_error($link);
    } else {
      return mysqli_insert_id($link);
    }
  }
}

?>
