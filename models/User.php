<?php
class User {
  public $userId = 0;
  public $name = "";
  public $positionId = 0;
  public function __construct(
    $userId = 0, 
    $name = "",
    $positionId = 0
  ) {
    $this->userId = $userId;
    $this->name = $name;
    $this->positionId = $positionId;
  }
}
?>