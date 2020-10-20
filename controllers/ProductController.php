<?php
class ProductController
{
  private $dbController;
  private $commonController;
  public $pageName = "";
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function performSearch($fcId = 0, $scId = 0)
  {
    self::search(
      $fcId,
      $scId,
      isset($_POST["keyword"]) ? $_POST["keyword"] : "",
      isset($_POST["productCondition"]) ? $_POST["productCondition"] : 0,
      isset($_POST["sortBy"]) ? $_POST["sortBy"] : "",
    );
  }


  public function search($fcId = 0, $scId = 0, $keyword = "", $productCondition = 0, $sortBy = "")
  {
    $fields = array(
      "productId",
      "refId",
      "fcId",
      "scId",
      "listingTitle",
      "price",
      "createdDate"
    );
    $conditionArray = array();
    if ($fcId > 0) {
      array_push($conditionArray, "fcId = " . $fcId);
    }
    if ($scId > 0) {
      array_push($conditionArray, "scId = " . $scId);
    }
    if ($keyword != "") {
      array_push($conditionArray, "keyword like '%" . $keyword . "%'");
    }
    if ($productCondition > 0) {
      array_push($conditionArray, "condition = " . $productCondition);
    }
    $orderBy = "";
    switch ($sortBy) {
      case "lowToHigh":
        $orderBy = " price asc";
        break;
      case "hightToLow":
        $orderBy = " price desc";
        break;
      default:
        $orderBy = " createdDate desc";
    }
    $condition = implode(" and ", $conditionArray);
    $rs = $this->dbController->QueryDB("product", $fields, "query", $condition, null, $orderBy, null, false);
  }
}
