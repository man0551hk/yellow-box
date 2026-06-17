<!DOCTYPE html>
<html lang="<?= Session::get("lang") == "tc" ? "zh-HK" : "en" ?>">
<head>
  <title>Yellow Hub - <?= Lang::$lang["title"] ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Yellow Hub - Hong Kong's marketplace for buying and selling">
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= Url::getDomain() ?>html/css/theme.min.css">
  <link rel="stylesheet" href="<?= Url::getDomain() ?>dist/style.css?v=<?= time(); ?>">
  
  <style>
    :root {
      --yellow-primary: #FFD700;
      --yellow-dark: #DAA520;
      --yellow-light: #FFF8DC;
    }
    body {
      font-family: 'Rubik', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background-color: #f8f9fa;
      color: #4b566b;
    }
    .toast-container {
      position: fixed;
      top: 80px;
      right: 20px;
      z-index: 9999;
    }
    @media (max-width: 768px) {
      .navbar-brand img {
        height: 40px !important;
      }
    }
  </style>
</head>
<body>
  <?php
  $urls = $this->urlController->SetUrl();
  $isLoggedIn = Session::get("userId") != "";
  $currentUserId = Session::get("userId");
  $currentFirstName = Session::get("firstName");
  $currentLastName = Session::get("lastName");
  $currentProfilePic = Session::get("profilePic");
  $currentProfileId = Session::get("profileId");
  ?>
  
  <!-- Toast Container -->
  <div class="toast-container" id="toastContainer"></div>

  <!-- Top Bar -->
  <div class="topbar bg-dark text-white py-1 d-none d-md-block">
    <div class="container">
      <div class="row">

        <div class="col text-right">
          <div class="dropdown d-inline-block">
            <a class="text-white dropdown-toggle small" href="#" data-toggle="dropdown">
              <img src="<?= Url::getDomain() ?>html/img/flags/hk.png" width="16" class="mr-1">
              <?= Session::get("lang") == "tc" ? "繁體中文" : "English" ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="javascript:redirect('tc')"><img src="<?= Url::getDomain() ?>html/img/flags/hk.png" width="16" class="mr-2">繁體中文</a>
              <a class="dropdown-item" href="javascript:redirect('en')"><img src="<?= Url::getDomain() ?>html/img/flags/tw.png" width="16" class="mr-2">English</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Navigation -->
  <nav class="navbar navbar-expand-lg navbar-yellow sticky-top">
    <div class="container">
      <a class="navbar-brand" href="<?= Url::getDomain() ?>">
        <img src="<?= Url::getDomain() ?>images/logo.png" style="height:50px;" alt="Yellow Hub">
      </a>
      
      <div class="d-flex order-lg-last ml-auto">
        <?php if ($isLoggedIn): ?>
          <a class="nav-link text-dark mr-2 position-relative" href="<?= Url::getDomain() ?>sell/" title="<?= Lang::$lang["sell"] ?>">
            <i class="fas fa-plus-circle fa-lg"></i>
          </a>
          <a class="nav-link text-dark mr-2 position-relative" href="<?= Url::getDomain() ?>notifications/" title="<?= Lang::$lang["notifications"] ?>" id="notificationBell">
            <i class="fas fa-bell fa-lg"></i>
            <span class="badge badge-danger badge-pill notification-badge" style="position:absolute;top:0;right:-5px;font-size:10px;display:none;" id="notificationBadge">0</span>
          </a>
          <a class="nav-link text-dark mr-2" href="<?= Url::getDomain() ?>inbox/" title="<?= Lang::$lang["myMessages"] ?>">
            <i class="fas fa-comment-dots fa-lg"></i>
          </a>
          <div class="dropdown">
            <a class="nav-link text-dark dropdown-toggle" href="#" data-toggle="dropdown">
              <?php if ($currentProfilePic): ?>
                <img src="<?= $currentProfilePic ?>" class="avatar">
              <?php else: ?>
                <i class="fas fa-user-circle fa-lg"></i>
              <?php endif; ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <h6 class="dropdown-header"><?= $currentFirstName ?> <?= $currentLastName ?></h6>
              <a class="dropdown-item" href="<?= Url::getDomain() ?>profile/<?= $currentProfileId ?>/">
                <i class="fas fa-user mr-2"></i><?= Lang::$lang["myProfile"] ?>
              </a>
              <a class="dropdown-item" href="<?= Url::getDomain() ?>my-products/">
                <i class="fas fa-box mr-2"></i><?= Lang::$lang["myProducts"] ?>
              </a>
              <a class="dropdown-item" href="<?= Url::getDomain() ?>my-favorites/">
                <i class="fas fa-heart mr-2"></i><?= Lang::$lang["myFavorites"] ?>
              </a>
              <a class="dropdown-item" href="<?= Url::getDomain() ?>saved-searches/">
                <i class="fas fa-search mr-2"></i><?= Lang::$lang["savedSearches"] ?>
              </a>
              <a class="dropdown-item" href="<?= Url::getDomain() ?>search-history/">
                <i class="fas fa-history mr-2"></i><?= Lang::$lang["searchHistory"] ?>
              </a>
              <a class="dropdown-item" href="<?= Url::getDomain() ?>settings/">
                <i class="fas fa-cog mr-2"></i><?= Lang::$lang["settings"] ?>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" href="<?= Url::getDomain() ?>logout/">
                <i class="fas fa-sign-out-alt mr-2"></i><?= Lang::$lang["logout"] ?>
              </a>
            </div>
          </div>
        <?php else: ?>
          <a class="btn btn-outline-dark btn-sm mr-2" href="<?= Url::getDomain() ?>login/">
            <i class="fas fa-sign-in-alt mr-1"></i><?= Lang::$lang["login"] ?>
          </a>
          <a class="btn btn-dark btn-sm" href="<?= Url::getDomain() ?>signup/">
            <i class="fas fa-user-plus mr-1"></i><?= Lang::$lang["signup"] ?>
          </a>
        <?php endif; ?>
        <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#mainNav">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>


      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              <i class="fas fa-th-large mr-1"></i><?= Lang::$lang["categories"] ?>
            </a>
            <div class="dropdown-menu">
              <?php
              $categorys = $this->categoryController->GetCategory();
              foreach ($categorys as $fc):
              ?>
                <div class="dropdown-submenu">
                  <a class="dropdown-item" href="<?= Url::SetLink($fc["seo"]) ?>">
                    <?= $fc["category"] ?>
                  </a>
                  <?php if (!empty($fc["subCategory"])): ?>
                    <div class="dropdown-menu">
                      <?php foreach ($fc["subCategory"] as $sc): ?>
                        <a class="dropdown-item" href="<?= Url::SetLink($sc["seo"]) ?>"><?= $sc["category"] ?></a>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </li>
        </ul>
        
        <!-- Search Form -->
        <form class="form-inline my-2 my-lg-0 mx-auto" action="<?= Url::getDomain() ?>search/" method="GET" style="flex:1;max-width:500px;">
          <div class="input-group w-100">
            <input class="form-control search-bar" type="search" name="keyword" placeholder="<?= Lang::$lang["search"] ?>..." aria-label="Search" value="<?= isset($_GET["keyword"]) ? htmlspecialchars($_GET["keyword"]) : '' ?>">
            <div class="input-group-append">
              <button class="btn btn-dark" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </nav>

  <script>
    function redirect(lang) {
      if (lang == "tc") {
        window.location = '<?= $urls[0] ?>';
      } else {
        window.location = '<?= $urls[1] ?>';
      }
    }
    
    function showToast(message, type = 'success') {
      const container = document.getElementById('toastContainer');
      const bgClass = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-warning';
      const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
      const toast = document.createElement('div');
      toast.className = `toast ${bgClass} text-white show`;
      toast.role = 'alert';
      toast.innerHTML = `
        <div class="toast-header ${bgClass} text-white">
          <i class="fas ${icon} mr-2"></i>
          <strong class="mr-auto">Yellow Hub</strong>
          <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">${message}</div>
      `;
      container.appendChild(toast);
      setTimeout(() => { toast.remove(); }, 3000);
    }
  </script>
