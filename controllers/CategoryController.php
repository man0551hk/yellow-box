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
      "id", "name_" . Session::get("lang"),  "seo_" . Session::get("lang")
    );
    $condition = " fcId = 0";
    $sortBy = " displayOrder asc";
    $fcRs = $this->dbController->QueryDB("category", $fields, "query", $condition, "", $sortBy, "", false);
    $categorys = array();
    while ($row = mysqli_fetch_array($fcRs)) {
      $id = $row["id"];
      $seo =  $row["seo_" . Session::get("lang")];
      $fc = array(
        "id" => $id,
        "category" => $row["name_" . Session::get("lang")],
        "seo" => $row["seo_" . Session::get("lang")],
        "subCategory" => array()
      );

      $fields = array(
        "id", "name_" . Session::get("lang"),  "seo_" . Session::get("lang")
      );
      $condition = " fcId = $id";
      $sortBy = " displayOrder asc";
      $scRs = $this->dbController->QueryDB("category", $fields, "query", $condition, "", $sortBy);
      while ($row2 = mysqli_fetch_array($scRs)) {
        $sc = array(
          "id" => $id,
          "category" => $row2["name_" . Session::get("lang")],
          "seo" => $seo . "/" . $row2["seo_" . Session::get("lang")],
        );
        array_push($fc["subCategory"], $sc);
      }

      array_push($categorys, $fc);
    }
    return $categorys;
  }

  public function ReturnCategoryMenu($isMobile = false)
  {
    $target_dir = Url::getPath('config');
    $fileName = "category.json";
    $categorys = json_decode(file_get_contents($target_dir .  $fileName));
    foreach ($categorys as $fc) {
      // echo '<li ' . ($isMobile === true ? 'class="item-menu-mobile"' : '')  . '>';
      // echo '<a href="' . Url::SetLink(Lang::ReturnCorrectLang($fc->seo_tc, $fc->seo_en)) . '">' . Lang::ReturnCorrectLang($fc->name_tc, $fc->name_en) . '</a>';
      // if (!empty($fc->sub_category) && sizeof($fc->sub_category) > 0) {
      //   echo '<ul class="sub_menu">';
      //   foreach ($fc->sub_category as $sc) {
      //     echo '<a href="' . Url::SetLink(Lang::ReturnCorrectLang($fc->seo_tc, $fc->seo_en) . "/" . Lang::ReturnCorrectLang($sc->seo_tc, $sc->seo_en)) . '">' . Lang::ReturnCorrectLang($sc->name_tc, $sc->name_en) . '</a>';
      //   }
      //   echo '</ul>';
      // }
      // if ($isMobile === true) {
      //   echo '<i class="arrow-main-menu fa fa-angle-right" aria-hidden="true"></i>';
      // }
      // echo '</li>';
      echo '<a class="nav-item nav-link active" href="' . Url::SetLink(Lang::ReturnCorrectLang($fc->seo_tc, $fc->seo_en)). '">'. Lang::ReturnCorrectLang($fc->name_tc, $fc->name_en) .'</a>';
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
