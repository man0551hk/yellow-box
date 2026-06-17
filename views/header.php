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
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background-color: #f8f9fa;
    }
    .navbar-yellow {
      background: linear-gradient(135deg, var(--yellow-primary), var(--yellow-dark));
    }
    .navbar-yellow .nav-link, .navbar-yellow .navbar-brand {
      color: #333 !important;
    }
    .navbar-yellow .nav-link:hover {
      color: #000 !important;
    }
    .search-bar {
      border-radius: 25px;
      border: 2px solid #e0e0e0;
      padding: 8px 20px;
      transition: all 0.3s;
    }
    .search-bar:focus {
      border-color: var(--yellow-primary);
      box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    }
    .btn-yellow {
      background-color: var(--yellow-primary);
      border-color: var(--yellow-dark);
      color: #333;
      font-weight: 600;
    }
    .btn-yellow:hover {
      background-color: var(--yellow-dark);
      color: #333;
    }
    .product-card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.2s, box-shadow 0.2s;
      background: white;
      margin-bottom: 20px;
    }
    .product-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .product-card .card-img-top {
      height: 200px;
      object-fit: cover;
    }
    .product-price {
      font-size: 1.25rem;
      font-weight: 700;
      color: #e74c3c;
    }
    .category-badge {
      background-color: var(--yellow-light);
      color: #856404;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }
    .category-badge:hover {
      background-color: var(--yellow-primary);
      text-decoration: none;
      color: #333;
    }
    .footer-yellow {
      background-color: #2c3e50;
      color: #ecf0f1;
    }
    .footer-yellow a {
      color: #bdc3c7;
    }
    .footer-yellow a:hover {
      color: var(--yellow-primary);
      text-decoration: none;
    }
    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }
    .avatar-lg {
      width: 80px;
      height: 80px;
    }
    .avatar-xl {
      width: 120px;
      height: 120px;
    }
    .badge-yellow {
      background-color: var(--yellow-primary);
      color: #333;
    }
    .section-title {
      position: relative;
      padding-bottom: 10px;
      margin-bottom: 25px;
      font-weight: 700;
    }
    .section-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background: var(--yellow-primary);
    }
    .toast-container {
      position: fixed;
      top: 80px;
      right: 20px;
      z-index: 9999;
    }
    .saved-search-tag {
      display: inline-block;
      background: #e9ecef;
      padding: 5px 15px;
      border-radius: 20px;
      margin: 3px;
      font-size: 0.9rem;
    }
    .saved-search-tag .close-btn {
      margin-left: 8px;
      cursor: pointer;
      color: #999;
    }
    .saved-search-tag .close-btn:hover {
      color: #e74c3c;
    }
    .chat-sidebar {
      height: calc(100vh - 200px);
      overflow-y: auto;
    }
    .chat-messages {
      height: calc(100vh - 300px);
      overflow-y: auto;
    }
    .message-bubble {
      max-width: 70%;
      padding: 10px 15px;
      border-radius: 18px;
      margin-bottom: 10px;
    }
    .message-sent {
      background-color: var(--yellow-primary);
      margin-left: auto;
      border-bottom-right-radius: 4px;
    }
    .message-received {
      background-color: #e9ecef;
      margin-right: auto;
      border-bottom-left-radius: 4px;
    }
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #999;
    }
    .empty-state i {
      font-size: 4rem;
      margin-bottom: 20px;
      color: #ddd;
    }
    .price-input {
      max-width: 200px;
    }
    .filter-section {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
    }
    .product-detail-image {
      width: 100%;
      max-height: 500px;
      object-fit: contain;
      background: #f8f9fa;
      border-radius: 12px;
    }
    .thumbnail-list img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      cursor: pointer;
      margin: 5px;
      border: 2px solid transparent;
      transition: border-color 0.2s;
    }
    .thumbnail-list img.active, .thumbnail-list img:hover {
      border-color: var(--yellow-primary);
    }
    .seller-stats {
      font-size: 0.9rem;
      color: #666;
    }
    .seller-stats span {
      margin-right: 15px;
    }
    @media (max-width: 768px) {
      .product-card .card-img-top {
        height: 150px;
      }
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
