<?php
if (isset($_GET["type"]) && $_GET["type"] == "checkEmail") {
  $this->userController->CheckEamilExisted();
} 
?>