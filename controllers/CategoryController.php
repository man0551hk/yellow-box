<?php
class CategoryController
{
  private $dbController;
  private $commonController;
  public function __construct($dbController, $commonController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
  }

  public function GetCategory()
  {
    $fields = array(
      "id", "name_" . Session::get("lang") . " as name", "seo_" . Session::get("lang") . " as seo"
    );
    $condition = " fcId = 0";
    $sortBy = " displayOrder asc";
    $fcRs = $this->dbController->QueryDB("category", $fields, "query", $condition, "", $sortBy, "", false);
    $categorys = array();
    while ($row = mysqli_fetch_array($fcRs)) {
      $id = $row["id"];
      $fc = array(
        "id" => $id,
        "category" => $row["name"],
        "seo" => $row["seo"],
        "subCategory" => array()
      );

      $fields2 = array(
        "id", "name_" . Session::get("lang") . " as name", "seo_" . Session::get("lang") . " as seo"
      );
      $condition2 = " fcId = $id";
      $sortBy2 = " displayOrder asc";
      $scRs = $this->dbController->QueryDB("category", $fields2, "query", $condition2, "", $sortBy2);
      while ($row2 = mysqli_fetch_array($scRs)) {
        $sc = array(
          "id" => $row2["id"],
          "category" => $row2["name"],
          "seo" => $row["seo"] . "/" . $row2["seo"],
        );
        array_push($fc["subCategory"], $sc);
      }

      array_push($categorys, $fc);
    }
    return $categorys;
  }

  public function GetSubCategory($fcId)
  {
    $fields = array(
      "id", "name_" . Session::get("lang") . " as name", "seo_" . Session::get("lang") . " as seo"
    );
    $condition = " fcId = $fcId";
    $sortBy = " displayOrder asc";
    $rs = $this->dbController->QueryDB("category", $fields, "query", $condition, "", $sortBy);
    $subs = array();
    while ($row = mysqli_fetch_array($rs)) {
      array_push($subs, array(
        "id" => $row["id"],
        "category" => $row["name"],
        "seo" => $row["seo"]
      ));
    }
    return $subs;
  }

  public function getCategoryBySeo($seo)
  {
    $fields = array(
      "id", "fcId", "name_" . Session::get("lang") . " as name", "seo_" . Session::get("lang") . " as seo"
    );
    $condition = " seo_" . Session::get("lang") . " = '" . $this->dbController->escapeString($seo) . "'";
    $rs = $this->dbController->QueryDB("category", $fields, "query", $condition);
    return mysqli_fetch_array($rs);
  }

  public function ReturnCategoryMenu($isMobile = false)
  {
    $categorys = $this->GetCategory();
    foreach ($categorys as $fc) {
      echo '<a class="nav-item nav-link active" href="' . Url::SetLink($fc["seo"]) . '">' . $fc["category"] . '</a>';
    }
  }

  public function ReturnCategorySeo($outputLang, $inputLang, $seo = "", $id = "")
  {
    $fields = array("name_" . $outputLang);
    $condition = "";
    if ($seo != "") {
      $condition = " seo_" . $inputLang . " = '$seo'";
    } else if ($id != "") {
      $condition = " id = $id";
    }
    $nameRs = $this->dbController->QueryDB("category", $fields, "query", $condition);
    return $this->commonController->ConvertResultToOneRecord($nameRs);
  }

  public function ReturnCategoryNameBySEO($seo)
  {
    $data = array();
    $linkPattern = explode("/", $seo);
    $conditionArray = array();
    foreach ($linkPattern as $p) {
      if ($p != "") {
        array_push($conditionArray,  " seo_" .  Session::get("lang") . " = '$p'");
      }
    }

    $fields = array("id", "name_" . Session::get("lang"));
    $condition = implode(" or ", $conditionArray);
    $nameRs = $this->dbController->QueryDB("category", $fields, "query", $condition, "", "", "", false);
    while ($row = mysqli_fetch_array($nameRs)) {
      $category = array(
        "id" => $row["id"],
        "name" => $row["name_" .  Session::get("lang")]
      );
      array_push($data, $category);
    }
    return $data;
  }

  public function ReturnParentCategoryIdByName($name)
  {
    $target_dir = Url::getPath('config');
    $fileName = "category.json";
    $categorys = json_decode(file_get_contents($target_dir .  $fileName));
    $fcId = 0;
    foreach ($categorys as $c) {
      if (isset($c->sub_category) && sizeof($c->sub_category) > 0) {
        foreach ($c->sub_category as $s) {
          if ($s->name_tc == $name || $s->name_en == $name) {
            $fcId = $c->id;
            break;
          }
        }
        if ($fcId != 0) {
          break;
        }
      }
    }
    return $fcId;
  }

  public function ReturnSubCategoryWithFcSeo($fcId)
  {
    $target_dir = Url::getPath('config');
    $fileName = "category.json";
    $categorys = json_decode(file_get_contents($target_dir .  $fileName));
    foreach ($categorys as $c) {
      if ($c->id == $fcId) {
        return array(
          "subCategory" => $c->sub_category,
          "seo_tc" => $c->seo_tc,
          "seo_en" => $c->seo_en
        );
      }
    }
  }

  public function ReturnFirstCategory()
  {
    $target_dir = Url::getPath('config');
    $fileName = "category.json";
    $categorys = json_decode(file_get_contents($target_dir .  $fileName));
    return $categorys;
  }
}
?>
