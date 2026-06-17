<?php
$activePage = $activePage ?? '';
$profilePic = Session::get('profilePic');
$firstName = Session::get('firstName');
$lastName = Session::get('lastName');
$email = Session::get('email');
?>
<aside class="col-lg-3 pt-4 pt-lg-0">
  <div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
    <div class="px-4 mb-4">
      <div class="media align-items-center">
        <div class="img-thumbnail rounded-circle position-relative" style="width: 6.375rem;">
          <?php if ($profilePic): ?>
            <img class="rounded-circle" src="<?= $profilePic ?>" alt="<?= htmlspecialchars($firstName) ?>">
          <?php else: ?>
            <div class="rounded-circle d-flex align-items-center justify-content-center bg-secondary text-accent font-weight-bold" style="width:6.375rem;height:6.375rem;font-size:2rem;">
              <?= strtoupper(substr($firstName, 0, 1)) ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="media-body pl-3">
          <h3 class="font-size-base mb-0"><?= htmlspecialchars($firstName . ' ' . $lastName) ?></h3>
          <span class="text-accent font-size-sm"><?= htmlspecialchars($email) ?></span>
        </div>
      </div>
    </div>
    <div class="bg-secondary px-4 py-3">
      <h3 class="font-size-sm mb-0 text-muted"><?= Session::get("lang") == "tc" ? "我的帳戶" : "My Account" ?></h3>
    </div>
    <ul class="list-unstyled mb-0">
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'my-products' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>my-products/">
          <i class="czi-bag opacity-60 mr-2"></i><?= Lang::$lang['myProducts'] ?>
        </a>
      </li>
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'my-favorites' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>my-favorites/">
          <i class="czi-heart opacity-60 mr-2"></i><?= Lang::$lang['myFavorites'] ?>
        </a>
      </li>
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'inbox' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>inbox/">
          <i class="czi-comment opacity-60 mr-2"></i><?= Lang::$lang['myMessages'] ?>
        </a>
      </li>
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'notifications' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>notifications/">
          <i class="czi-bell opacity-60 mr-2"></i><?= Lang::$lang['notifications'] ?>
        </a>
      </li>
      <li class="mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'saved-searches' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>saved-searches/">
          <i class="czi-search opacity-60 mr-2"></i><?= Lang::$lang['savedSearches'] ?>
        </a>
      </li>
    </ul>
    <div class="bg-secondary px-4 py-3">
      <h3 class="font-size-sm mb-0 text-muted"><?= Lang::$lang['settings'] ?></h3>
    </div>
    <ul class="list-unstyled mb-0">
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'settings' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>settings/">
          <i class="czi-user opacity-60 mr-2"></i><?= Lang::$lang['settings'] ?>
        </a>
      </li>
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'search-history' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>search-history/">
          <i class="czi-time opacity-60 mr-2"></i><?= Lang::$lang['searchHistory'] ?>
        </a>
      </li>
      <li class="border-bottom mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3<?= $activePage === 'blocked-users' ? ' active' : '' ?>" href="<?= Url::getDomain() ?>blocked-users/">
          <i class="czi-close-circle opacity-60 mr-2"></i><?= Session::get("lang") == "tc" ? "已封鎖的用戶" : "Blocked Users" ?>
        </a>
      </li>
      <li class="d-lg-none border-top mb-0">
        <a class="nav-link-style d-flex align-items-center px-4 py-3" href="<?= Url::getDomain() ?>logout/">
          <i class="czi-sign-out opacity-60 mr-2"></i><?= Lang::$lang['logout'] ?>
        </a>
      </li>
    </ul>
  </div>
</aside>