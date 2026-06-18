
<footer class="bg-fff pt-5 box-shadow-xl mt-5">
  <div class="container">
    <div class="row pb-2">
      <div class="col-md-3 col-sm-6">
        <div class="widget widget-links widget-dark pb-2 mb-4">
          <h3 class="widget-title text-dark"><?= Lang::$lang["categories"] ?></h3>
          <ul class="widget-list">
            <?php
            $footerCategorys = $this->categoryController->GetCategory();
            foreach ($footerCategorys as $fc):
            ?>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::SetLink($fc["seo"]) ?>"><?= htmlspecialchars($fc["category"]) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="widget widget-links widget-dark pb-2 mb-4">
          <h3 class="widget-title text-dark"><?= Session::get("lang") == "tc" ? "我的帳戶" : "My Account" ?></h3>
          <ul class="widget-list">
            <?php if ($isLoggedIn): ?>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>profile/<?= $currentProfileId ?>/"><?= Lang::$lang["myProfile"] ?></a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>my-products/"><?= Lang::$lang["myProducts"] ?></a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>my-favorites/"><?= Lang::$lang["myFavorites"] ?></a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>inbox/"><?= Lang::$lang["myMessages"] ?></a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>settings/"><?= Lang::$lang["settings"] ?></a></li>
            <?php else: ?>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>login/"><?= Lang::$lang["login"] ?></a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="<?= Url::getDomain() ?>signup/"><?= Lang::$lang["signup"] ?></a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="col-md-2 col-sm-6">
        <div class="widget widget-links widget-dark pb-2 mb-4">
          <h3 class="widget-title text-dark"><?= Lang::$lang["help"] ?></h3>
          <ul class="widget-list">
            <li class="widget-list-item"><a class="widget-list-link" href="#"><?= Lang::$lang["about"] ?></a></li>
            <li class="widget-list-item"><a class="widget-list-link" href="#"><?= Lang::$lang["contactUs"] ?></a></li>
            <li class="widget-list-item"><a class="widget-list-link" href="#"><?= Lang::$lang["terms"] ?></a></li>
            <li class="widget-list-item"><a class="widget-list-link" href="#"><?= Lang::$lang["privacyPolicy"] ?></a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="widget pb-2 mb-4">
          <h3 class="widget-title text-dark pb-1"><?= Lang::$lang["contactUs"] ?></h3>
          <ul class="widget-list">
            <li class="widget-list-item mb-2"><i class="czi-mail text-accent mr-2"></i> support@yellowhk.com</li>
            <li class="widget-list-item"><i class="czi-location text-accent mr-2"></i> Hong Kong</li>
          </ul>
          <div class="mt-3">
            <a class="social-btn sb-light sb-facebook ml-0 mb-2" href="#"><i class="czi-facebook"></i></a>
            <a class="social-btn sb-light sb-instagram ml-2 mb-2" href="#"><i class="czi-instagram"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="pt-5 bg-darker">
    <div class="container">
      <div class="row pb-3">
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="media">
            <i class="czi-delivery text-primary" style="font-size:2.25rem;"></i>
            <div class="media-body pl-3">
              <h6 class="font-size-base text-light mb-1"><?= Session::get("lang") == "tc" ? "面交交收" : "Meet & Exchange" ?></h6>
              <p class="mb-0 font-size-ms text-light opacity-50"><?= Session::get("lang") == "tc" ? "約好時間地點當面交收" : "Arrange a safe meetup" ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="media">
            <i class="czi-security-check text-primary" style="font-size:2.25rem;"></i>
            <div class="media-body pl-3">
              <h6 class="font-size-base text-light mb-1"><?= Session::get("lang") == "tc" ? "安全可靠" : "Safe & Secure" ?></h6>
              <p class="mb-0 font-size-ms text-light opacity-50"><?= Session::get("lang") == "tc" ? "用戶評價及舉報機制" : "User ratings and reporting" ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="media">
            <i class="czi-support text-primary" style="font-size:2.25rem;"></i>
            <div class="media-body pl-3">
              <h6 class="font-size-base text-light mb-1"><?= Session::get("lang") == "tc" ? "客戶支援" : "Customer Support" ?></h6>
              <p class="mb-0 font-size-ms text-light opacity-50"><?= Session::get("lang") == "tc" ? "隨時為你提供協助" : "We're here to help" ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="media">
            <i class="czi-mobile text-primary" style="font-size:2.25rem;"></i>
            <div class="media-body pl-3">
              <h6 class="font-size-base text-light mb-1"><?= Session::get("lang") == "tc" ? "手機刊登" : "List from Mobile" ?></h6>
              <p class="mb-0 font-size-ms text-light opacity-50"><?= Session::get("lang") == "tc" ? "影相幾步就刊登完成" : "Snap and list in minutes" ?></p>
            </div>
          </div>
        </div>
      </div>
      <hr class="hr-light pb-4 mb-3">
      <div class="row pb-2">
        <div class="col-md-6 text-center text-md-left mb-4">
          <div class="text-nowrap mb-4">
            <a class="d-inline-block align-middle mt-n1 mr-3" href="<?= Url::getDomain() ?>">
              <img class="d-block" width="117" src="<?= Url::getDomain() ?>images/logo.png" alt="Yellow Hub">
            </a>
          </div>
          <div class="widget widget-links widget-light">
            <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
              <li class="widget-list-item mr-4"><a class="widget-list-link" href="#"><?= Lang::$lang["help"] ?></a></li>
              <li class="widget-list-item mr-4"><a class="widget-list-link" href="#"><?= Lang::$lang["contactUs"] ?></a></li>
              <li class="widget-list-item mr-4"><a class="widget-list-link" href="#"><?= Lang::$lang["terms"] ?></a></li>
              <li class="widget-list-item mr-4"><a class="widget-list-link" href="#"><?= Lang::$lang["privacyPolicy"] ?></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 text-center text-md-right mb-4">
          <div class="mb-3">
            <a class="social-btn sb-light sb-facebook ml-2 mb-2" href="#"><i class="czi-facebook"></i></a>
            <a class="social-btn sb-light sb-instagram ml-2 mb-2" href="#"><i class="czi-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="pb-4 font-size-xs text-light opacity-50 text-center text-md-left">
        &copy; <?= date('Y') ?> deepYellow Limited. <?= Lang::$lang["allRightsReserved"] ?>.
      </div>
    </div>
  </div>
</footer>

<div class="cz-handheld-toolbar">
  <div class="d-table table-fixed w-100">
    <a class="d-table-cell cz-handheld-toolbar-item" href="<?= Url::getDomain() ?>search/">
      <span class="cz-handheld-toolbar-icon"><i class="czi-search"></i></span>
      <span class="cz-handheld-toolbar-label"><?= Lang::$lang["search"] ?></span>
    </a>
    <?php if ($isLoggedIn): ?>
      <a class="d-table-cell cz-handheld-toolbar-item" href="<?= Url::getDomain() ?>my-favorites/">
        <span class="cz-handheld-toolbar-icon"><i class="czi-heart"></i></span>
        <span class="cz-handheld-toolbar-label"><?= Lang::$lang["myFavorites"] ?></span>
      </a>
      <a class="d-table-cell cz-handheld-toolbar-item" href="#navbarCollapse" data-toggle="collapse" onclick="window.scrollTo(0,0)">
        <span class="cz-handheld-toolbar-icon"><i class="czi-menu"></i></span>
        <span class="cz-handheld-toolbar-label"><?= Session::get("lang") == "tc" ? "選單" : "Menu" ?></span>
      </a>
      <a class="d-table-cell cz-handheld-toolbar-item" href="<?= Url::getDomain() ?>sell/">
        <span class="cz-handheld-toolbar-icon"><i class="czi-add"></i></span>
        <span class="cz-handheld-toolbar-label"><?= Lang::$lang["sell"] ?></span>
      </a>
    <?php else: ?>
      <a class="d-table-cell cz-handheld-toolbar-item" href="<?= Url::getDomain() ?>login/">
        <span class="cz-handheld-toolbar-icon"><i class="czi-user"></i></span>
        <span class="cz-handheld-toolbar-label"><?= Lang::$lang["login"] ?></span>
      </a>
      <a class="d-table-cell cz-handheld-toolbar-item" href="#navbarCollapse" data-toggle="collapse" onclick="window.scrollTo(0,0)">
        <span class="cz-handheld-toolbar-icon"><i class="czi-menu"></i></span>
        <span class="cz-handheld-toolbar-label"><?= Session::get("lang") == "tc" ? "選單" : "Menu" ?></span>
      </a>
      <a class="d-table-cell cz-handheld-toolbar-item" href="<?= Url::getDomain() ?>signup/">
        <span class="cz-handheld-toolbar-icon"><i class="czi-user"></i></span>
        <span class="cz-handheld-toolbar-label"><?= Lang::$lang["signup"] ?></span>
      </a>
    <?php endif; ?>
  </div>
</div>

<a class="btn-scroll-top" href="#top" data-scroll>
  <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">Top</span>
  <i class="btn-scroll-top-icon czi-arrow-up"></i>
</a>

<script src="<?= Url::getDomain() ?>html/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= Url::getDomain() ?>html/vendor/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="<?= Url::getDomain() ?>html/vendor/simplebar/dist/simplebar.min.js"></script>
<script src="<?= Url::getDomain() ?>html/vendor/tiny-slider/dist/min/tiny-slider.js"></script>
<script src="<?= Url::getDomain() ?>html/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<script src="<?= Url::getDomain() ?>html/js/theme.min.js"></script>
<script>
  if (typeof bsCustomFileInput !== 'undefined') {
    bsCustomFileInput.init();
  }

  $('.alert-auto-hide').fadeTo(5000, 0).slideUp(500, function() {
    $(this).remove();
  });

  $('.btn-confirm-delete').on('click', function(e) {
    if (!confirm('<?= Lang::$lang["confirmDelete"] ?>')) {
      e.preventDefault();
    }
  });

  $('.price-format').on('input', function() {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });

  function checkNotifications() {
    $.get('<?= Url::getDomain() ?>api/get-notifications/', function(data) {
      if (data && data.unreadCount > 0) {
        $('#notificationBadge').text(data.unreadCount).show();
      } else {
        $('#notificationBadge').hide();
      }
    });
  }

  <?php if ($isLoggedIn): ?>
  checkNotifications();
  setInterval(checkNotifications, 30000);
  <?php endif; ?>
</script>
</body>
</html>