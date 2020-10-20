<?php
class UrlController
{
  private $dbController;
  private $commonController;
  private $categoryController;
  public $pageName = "";
  public function __construct($dbController, $commonController, $categoryController)
  {
    $this->dbController = $dbController;
    $this->commonController = $commonController;
    $this->categoryController = $categoryController;
  }

  public function SetUrl()
  {
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link = str_replace("/en/", "/", $actual_link);
    $actual_link = str_replace(Url::getDomain(), "", $actual_link);
    $enLink = Url::getDomain() . "en/";
    $tcLink = Url::getDomain();
    $linkPattern = explode("/", $actual_link);
    $target_dir = Url::getPath('config');
    $fileName = "seoMapping.json";
    $seoMapping = json_decode(file_get_contents( $target_dir .  $fileName )) ;
    if ( $this->pageName != "product.php") {
      $results = array_keys ( array_column($seoMapping, "type") );
      foreach($linkPattern as $p) {
        if ($p != "") {
          foreach($results as $r) {
            if ($p == urlencode ( $seoMapping[$r]->seo_tc ) || $p == $seoMapping[$r]->seo_en ) {
              $enLink .= $seoMapping[$r]->seo_en . "/";
              $tcLink .= $seoMapping[$r]->seo_tc . "/";
              break;
            }
          }
        }
      }
    }
    return [$tcLink, $enLink];
  }
}
?>