<?php $activePage = 'settings'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['settings'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['settings'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <div class="d-none d-lg-flex justify-content-between align-items-center pt-lg-3 pb-4 pb-lg-5 mb-lg-3">
        <h6 class="font-size-base text-light mb-0"><?= $isTc ? "更新你的個人資料" : "Update your profile details below:" ?></h6>
        <a class="btn btn-primary btn-sm" href="<?= Url::getDomain() ?>logout/"><i class="czi-sign-out mr-2"></i><?= Lang::$lang['logout'] ?></a>
      </div>

      <?php if (isset($success)): ?><div class="alert alert-success alert-auto-hide"><?= $success ?></div><?php endif; ?>
      <?php if (isset($error)): ?><div class="alert alert-danger alert-auto-hide"><?= $error ?></div><?php endif; ?>

      <form method="POST" action="">
        <div class="bg-secondary rounded-lg p-4 mb-4">
          <div class="form-row">
            <div class="form-group col-sm-6">
              <label for="settings-first"><?= Lang::$lang['firstName'] ?></label>
              <input class="form-control" type="text" id="settings-first" name="firstName" value="<?= htmlspecialchars(Session::get('firstName')) ?>" required>
            </div>
            <div class="form-group col-sm-6">
              <label for="settings-last"><?= Lang::$lang['lastName'] ?></label>
              <input class="form-control" type="text" id="settings-last" name="lastName" value="<?= htmlspecialchars(Session::get('lastName')) ?>" required>
            </div>
            <div class="form-group col-sm-6">
              <label for="settings-email"><?= Lang::$lang['email'] ?></label>
              <input class="form-control" type="email" id="settings-email" value="<?= htmlspecialchars(Session::get('email')) ?>" disabled>
              <small class="form-text text-muted"><?= Session::get('isVerify') ? '<span class="text-success"><i class="czi-check-circle"></i> ' . Lang::$lang['verified'] . '</span>' : '<span class="text-danger"><i class="czi-close-circle"></i> ' . Lang::$lang['notVerified'] . '</span>' ?></small>
            </div>
            <div class="form-group col-sm-6">
              <label for="settings-phone"><?= Lang::$lang['phone'] ?></label>
              <input class="form-control" type="text" id="settings-phone" name="phone" value="<?= htmlspecialchars(Session::get('phone')) ?>" placeholder="e.g. 91234567">
            </div>
            <div class="col-12">
              <hr class="mt-2 mb-3">
              <button class="btn btn-primary btn-shadow" type="submit"><i class="czi-check mr-1"></i><?= Lang::$lang['save'] ?></button>
            </div>
          </div>
        </div>
      </form>

      <div class="bg-secondary rounded-lg p-4">
        <h6 class="font-weight-medium mb-3"><?= $isTc ? "更多設定" : "More Settings" ?></h6>
        <a href="<?= Url::getDomain() ?>blocked-users/" class="btn btn-outline-danger btn-block mb-2">
          <i class="czi-close-circle mr-2"></i><?= $isTc ? "已封鎖的用戶" : "Blocked Users" ?>
        </a>
        <a href="<?= Url::getDomain() ?>search-history/" class="btn btn-outline-accent btn-block">
          <i class="czi-time mr-2"></i><?= Lang::$lang["searchHistory"] ?>
        </a>
      </div>
    </section>
  </div>
</div>