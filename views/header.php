<!DOCTYPE html>
<html lang="<?= Session::get("lang") == "tc" ? "zh-HK" : "en" ?>">
<head>
  <meta charset="utf-8">
  <title>Yellow Hub - <?= Lang::$lang["title"] ?></title>
  <meta name="description" content="Yellow Hub - Hong Kong's marketplace for buying and selling">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= Url::getDomain() ?>html/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= Url::getDomain() ?>html/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= Url::getDomain() ?>html/favicon-16x16.png">
  <link rel="manifest" href="<?= Url::getDomain() ?>html/site.webmanifest">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" media="screen" href="<?= Url::getDomain() ?>html/vendor/simplebar/dist/simplebar.min.css">
  <link rel="stylesheet" media="screen" href="<?= Url::getDomain() ?>html/vendor/tiny-slider/dist/tiny-slider.css">
  <link rel="stylesheet" media="screen" href="<?= Url::getDomain() ?>html/css/theme.css">
  <link rel="stylesheet" href="<?= Url::getDomain() ?>dist/style.css?v=<?= time(); ?>">
  <script src="<?= Url::getDomain() ?>html/vendor/jquery/dist/jquery.min.js"></script>
</head>
<body class="toolbar-enabled">
<?php
$urls = $this->urlController->SetUrl();
$isLoggedIn = Session::get("userId") != "";
$currentUserId = Session::get("userId");
$currentFirstName = Session::get("firstName");
$currentLastName = Session::get("lastName");
$currentProfilePic = Session::get("profilePic");
$currentProfileId = Session::get("profileId");
$htmlBase = Url::getDomain() . 'html/';
$searchKeyword = isset($_GET["keyword"]) ? htmlspecialchars($_GET["keyword"]) : '';
$navCategorys = $this->categoryController->GetCategory();
$isTc = Session::get("lang") == "tc";
?>

<div class="toast-container" id="toastContainer" style="position:fixed;top:80px;right:20px;z-index:9999;"></div>

<header class="box-shadow-sm">
  <div class="topbar topbar-dark bg-dark">
    <div class="container">
      <div class="topbar-text text-nowrap d-none d-md-inline-block">
        <i class="czi-support"></i>
        <span class="text-muted mr-1"><?= $isTc ? "客戶服務" : "Support" ?></span>
        <a class="topbar-link" href="mailto:support@yellowhk.com">support@yellowhk.com</a>
      </div>
      <div class="cz-carousel cz-controls-static d-none d-md-block">
        <div class="cz-carousel-inner" data-carousel-options='{"mode": "gallery", "nav": false}'>
          <div class="topbar-text"><?= $isTc ? "香港人嘅網上買賣平台" : "Hong Kong's Online Marketplace" ?></div>
          <div class="topbar-text"><?= $isTc ? "買賣·咁簡單" : "Buy & Sell. Made Simple." ?></div>
          <div class="topbar-text"><?= $isTc ? "安全、方便、快捷" : "Safe, convenient, and fast" ?></div>
        </div>
      </div>
      <div class="ml-3 text-nowrap">
        <div class="topbar-text dropdown disable-autohide">
          <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
            <img class="mr-2" width="20" src="<?= $htmlBase ?>img/flags/hk.png" alt="Language">
            <?= $isTc ? "繁體中文" : "English" ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a class="dropdown-item pb-1" href="javascript:redirect('tc')"><img class="mr-2" width="20" src="<?= $htmlBase ?>img/flags/hk.png" alt="tc-hk">繁體中文</a></li>
            <li><a class="dropdown-item pb-1" href="javascript:redirect('en')"><img class="mr-2" width="20" src="<?= $htmlBase ?>img/flags/tw.png" alt="en">English</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="navbar-sticky bg-light">
    <div class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <a class="navbar-brand d-none d-sm-block mr-3 flex-shrink-0" href="<?= Url::getDomain() ?>" style="min-width:7rem;">
          <img width="142" src="<?= Url::getDomain() ?>images/logo.png" alt="Yellow Hub">
        </a>
        <a class="navbar-brand d-sm-none mr-2" href="<?= Url::getDomain() ?>" style="min-width:4.625rem;">
          <img width="74" src="<?= Url::getDomain() ?>images/logo.png" alt="Yellow Hub">
        </a>

        <form class="input-group-overlay d-none d-lg-flex mx-4 flex-grow-1" action="<?= Url::getDomain() ?>search/" method="GET" style="max-width:32rem;">
          <input class="form-control appended-form-control" type="search" name="keyword" placeholder="<?= Lang::$lang["search"] ?>..." value="<?= $searchKeyword ?>" required>
          <div class="input-group-append-overlay"><span class="input-group-text"><i class="czi-search"></i></span></div>
        </form>

        <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>

          <?php if ($isLoggedIn): ?>
            <a class="navbar-tool d-none d-lg-flex" href="<?= Url::getDomain() ?>sell/" data-toggle="tooltip" title="<?= Lang::$lang["sell"] ?>">
              <span class="navbar-tool-tooltip"><?= Lang::$lang["sell"] ?></span>
              <div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-add"></i></div>
            </a>
            <a class="navbar-tool d-none d-lg-flex" href="<?= Url::getDomain() ?>my-favorites/" data-toggle="tooltip" title="<?= Lang::$lang["myFavorites"] ?>">
              <span class="navbar-tool-tooltip"><?= Lang::$lang["myFavorites"] ?></span>
              <div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-heart"></i></div>
            </a>
            <div class="navbar-tool dropdown">
              <a class="navbar-tool-icon-box" href="<?= Url::getDomain() ?>notifications/" id="notificationBell">
                <span class="navbar-tool-label notification-badge" id="notificationBadge" style="display:none;">0</span>
                <i class="navbar-tool-icon czi-bell"></i>
              </a>
            </div>
            <a class="navbar-tool" href="<?= Url::getDomain() ?>inbox/" data-toggle="tooltip" title="<?= Lang::$lang["myMessages"] ?>">
              <span class="navbar-tool-tooltip"><?= Lang::$lang["myMessages"] ?></span>
              <div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-message"></i></div>
            </a>
            <div class="navbar-tool dropdown ml-3">
              <a class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2" href="#" data-toggle="dropdown">
                <div class="navbar-tool-icon-box">
                  <?php if ($currentProfilePic): ?>
                    <img src="<?= $currentProfilePic ?>" class="rounded-circle" width="36" height="36" alt="<?= htmlspecialchars($currentFirstName) ?>">
                  <?php else: ?>
                    <i class="navbar-tool-icon czi-user"></i>
                  <?php endif; ?>
                </div>
                <div class="navbar-tool-text ml-n3 d-none d-lg-block">
                  <small><?= $isTc ? "你好，" : "Hello, " ?><?= htmlspecialchars($currentFirstName) ?></small>
                  <?= Lang::$lang["myProfile"] ?>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right" style="min-width:14rem;">
                <h6 class="dropdown-header"><?= htmlspecialchars($currentFirstName . ' ' . $currentLastName) ?></h6>
                <a class="dropdown-item" href="<?= Url::getDomain() ?>profile/<?= $currentProfileId ?>/"><i class="czi-user opacity-60 mr-2"></i><?= Lang::$lang["myProfile"] ?></a>
                <a class="dropdown-item" href="<?= Url::getDomain() ?>my-products/"><i class="czi-bag opacity-60 mr-2"></i><?= Lang::$lang["myProducts"] ?></a>
                <a class="dropdown-item" href="<?= Url::getDomain() ?>my-favorites/"><i class="czi-heart opacity-60 mr-2"></i><?= Lang::$lang["myFavorites"] ?></a>
                <a class="dropdown-item" href="<?= Url::getDomain() ?>saved-searches/"><i class="czi-search opacity-60 mr-2"></i><?= Lang::$lang["savedSearches"] ?></a>
                <a class="dropdown-item" href="<?= Url::getDomain() ?>search-history/"><i class="czi-time opacity-60 mr-2"></i><?= Lang::$lang["searchHistory"] ?></a>
                <a class="dropdown-item" href="<?= Url::getDomain() ?>settings/"><i class="czi-settings opacity-60 mr-2"></i><?= Lang::$lang["settings"] ?></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="<?= Url::getDomain() ?>logout/"><i class="czi-sign-out opacity-60 mr-2"></i><?= Lang::$lang["logout"] ?></a>
              </div>
            </div>
          <?php else: ?>
            <a class="navbar-tool ml-1 ml-lg-0 mr-n1 mr-lg-2" href="<?= Url::getDomain() ?>login/">
              <div class="navbar-tool-icon-box"><i class="navbar-tool-icon czi-user"></i></div>
              <div class="navbar-tool-text ml-n3 d-none d-lg-block">
                <small><?= $isTc ? "你好，登入" : "Hello, Sign in" ?></small>
                <?= Lang::$lang["myProfile"] ?>
              </div>
            </a>
            <a class="btn btn-primary btn-sm btn-shadow ml-2 d-none d-lg-inline-block" href="<?= Url::getDomain() ?>signup/">
              <i class="czi-user mr-1"></i><?= Lang::$lang["signup"] ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0 pb-2">
      <div class="container">
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <form class="input-group-overlay d-lg-none my-3" action="<?= Url::getDomain() ?>search/" method="GET">
            <div class="input-group-prepend-overlay"><span class="input-group-text"><i class="czi-search"></i></span></div>
            <input class="form-control prepended-form-control" type="search" name="keyword" placeholder="<?= Lang::$lang["search"] ?>..." value="<?= $searchKeyword ?>" required>
          </form>

          <ul class="navbar-nav mega-nav pr-lg-2 mr-lg-2">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle pl-0" href="#" data-toggle="dropdown">
                <i class="czi-view-grid mr-2"></i><?= Lang::$lang["categories"] ?>
              </a>
              <div class="dropdown-menu px-2 pl-0 pb-4" style="min-width:48rem;">
                <?php
                $catChunks = array_chunk($navCategorys, 3);
                foreach ($catChunks as $chunk):
                ?>
                  <div class="d-flex flex-wrap flex-md-nowrap">
                    <?php foreach ($chunk as $i => $fc):
                      $imgNum = str_pad((($fc['id'] ?? $i) % 6) + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                      <div class="mega-dropdown-column pt-4 px-3">
                        <div class="widget widget-links">
                          <a class="d-block overflow-hidden rounded-lg mb-3" href="<?= Url::SetLink($fc["seo"]) ?>">
                            <img src="<?= $htmlBase ?>img/shop/category/<?= $imgNum ?>.jpg" alt="<?= htmlspecialchars($fc["category"]) ?>">
                          </a>
                          <h6 class="font-size-base mb-2">
                            <a href="<?= Url::SetLink($fc["seo"]) ?>"><?= htmlspecialchars($fc["category"]) ?></a>
                          </h6>
                          <?php if (!empty($fc["subCategory"])): ?>
                            <ul class="widget-list">
                              <?php foreach (array_slice($fc["subCategory"], 0, 5) as $sc): ?>
                                <li class="widget-list-item">
                                  <a class="widget-list-link" href="<?= Url::SetLink($sc["seo"]) ?>"><?= htmlspecialchars($sc["category"]) ?></a>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="<?= Url::getDomain() ?>search/?sortBy=popular">
                <i class="czi-flame mr-1"></i><?= $isTc ? "熱門商品" : "Trending" ?>
              </a>
            </li>
            <?php if ($isLoggedIn): ?>
              <li class="nav-item d-lg-none">
                <a class="nav-link" href="<?= Url::getDomain() ?>sell/"><i class="czi-add mr-1"></i><?= Lang::$lang["sell"] ?></a>
              </li>
            <?php else: ?>
              <li class="nav-item d-lg-none">
                <a class="nav-link" href="<?= Url::getDomain() ?>login/"><i class="czi-user mr-1"></i><?= Lang::$lang["login"] ?></a>
              </li>
              <li class="nav-item d-lg-none">
                <a class="nav-link" href="<?= Url::getDomain() ?>signup/"><i class="czi-user mr-1"></i><?= Lang::$lang["signup"] ?></a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>

<script>
function redirect(lang) {
  window.location = lang === 'tc' ? '<?= $urls[0] ?>' : '<?= $urls[1] ?>';
}

function showToast(message, type) {
  type = type || 'success';
  var container = document.getElementById('toastContainer');
  var bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-warning';
  var icon = type === 'success' ? 'czi-check-circle' : type === 'error' ? 'czi-close-circle' : 'czi-announcement';
  var toast = document.createElement('div');
  toast.className = 'toast ' + bgClass + ' text-white show';
  toast.setAttribute('role', 'alert');
  toast.innerHTML = '<div class="toast-body d-flex align-items-center"><i class="' + icon + ' mr-2"></i>' + message + '<button type="button" class="close text-white ml-auto mb-1" onclick="this.closest(\'.toast\').remove()">&times;</button></div>';
  container.appendChild(toast);
  setTimeout(function() { toast.remove(); }, 3000);
}
</script>