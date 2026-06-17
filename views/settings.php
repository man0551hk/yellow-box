<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <h4 class="mb-4"><?= Lang::$lang['settings'] ?></h4>
          
          <?php if (isset($success)): ?>
            <div class="alert alert-success alert-auto-hide"><?= $success ?></div>
          <?php endif; ?>
          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-auto-hide"><?= $error ?></div>
          <?php endif; ?>
          
          <form method="POST" action="">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><?= Lang::$lang['firstName'] ?></label>
                <input type="text" class="form-control" name="firstName" value="<?= Session::get('firstName') ?>" required>
              </div>
              <div class="form-group col-md-6">
                <label><?= Lang::$lang['lastName'] ?></label>
                <input type="text" class="form-control" name="lastName" value="<?= Session::get('lastName') ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label><?= Lang::$lang['email'] ?></label>
              <input type="email" class="form-control" value="<?= Session::get('email') ?>" disabled>
              <small class="form-text text-muted"><?= Lang::$lang['email'] ?> <?= Session::get('isVerify') ? '<span class="text-success">✓ ' . Lang::$lang['verified'] . '</span>' : '<span class="text-danger">✗ ' . Lang::$lang['notVerified'] . '</span>' ?></small>
            </div>
            <div class="form-group">
              <label><?= Lang::$lang['phone'] ?></label>
              <input type="text" class="form-control" name="phone" value="<?= Session::get('phone') ?>" placeholder="e.g. 91234567">
            </div>
            <button type="submit" class="btn btn-yellow btn-block"><?= Lang::$lang['save'] ?></button>
          </form>
          
          <hr>
          <div class="mt-4">
            <h6 class="font-weight-bold mb-3"><?= Session::get("lang") == "tc" ? "更多設定" : "More Settings" ?></h6>
            <a href="<?= Url::getDomain() ?>blocked-users/" class="btn btn-outline-danger btn-block">
              <i class="fas fa-ban mr-2"></i><?= Session::get("lang") == "tc" ? "已封鎖的用戶" : "Blocked Users" ?>
            </a>
            <a href="<?= Url::getDomain() ?>search-history/" class="btn btn-outline-secondary btn-block">
              <i class="fas fa-history mr-2"></i><?= Lang::$lang["searchHistory"] ?>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
