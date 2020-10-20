<?php
class Option {
  public $text = "";
  public $value = "";
  public function __construct(
    $text = "", $value = ""
  ) {
    $this->text = $text;
    $this->value = $value;
  }
}
?>