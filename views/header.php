<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= Lang::$lang["title"] ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

  <link rel="stylesheet" href="<?= Url::getDomain() ?>dist/style.css?v=<?= time(); ?>" />
  <?php
  $urls = $this->urlController->SetUrl();
  ?>
  <script>
    function redirect(lang) {
      if (lang == "tc") {
        window.location = '<?= $urls[0] ?>';
      } else {
        window.location = '<?= $urls[1] ?>';
      }
    }
  </script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#"><img src="<?= Url::getDomain() ?>images/logo.png" style="height:60px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-toggle" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbar-toggle" id="navbarNavAltMarkup">

      <form class="form-inline mr-auto mt-2 mt-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <!-- <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
      </form>

      <ul class="navbar-nav my-2 my-lg-0">
        <li class="nav-item active">
          <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
          <a class="nav-link" href="<?= Url::getDomain() ?>login/"><?= Lang::$lang["login"] ?></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?= Url::getDomain() ?>login/"><?= Lang::$lang["signup"] ?></a>
        </li>
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= Session::get("lang") == "tc" ? "繁體" : "EN" ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="javascript:redirect('tc')">繁體</a>
            <a class="dropdown-item" href="javascript:redirect('en')">EN</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <nav class="navbar navbar-expand-lg navbar-light py-0 bg-light px-lg-2 ml-auto">
    <div class="collapse navbar-collapse navbar-toggle" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <!-- <a class="nav-item nav-link active" href="#">Link</a>
        <a class="nav-item nav-link" href="#">Link</a>
        <a class="nav-item nav-link" href="#">Link</a>
        <a class="nav-item nav-link disabled" href="#">Link</a> -->
        <?php
        $this->categoryController->ReturnCategoryMenu(false);
        ?>
      </div>
    </div>
  </nav>