<div class="container pb-5 mb-2 mb-md-4">
  <div class="row justify-content-center pt-5">
    <div class="col-md-5">
      <div class="card border-0 box-shadow-lg">
        <div class="card-body p-4 p-md-5">
          <h3 class="text-center mb-4"><?= Lang::$lang["login"] ?></h3>

          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-auto-hide"><?= $error ?></div>
          <?php endif; ?>

          <form class="needs-validation" method="POST" action="" novalidate>
            <div class="form-group">
              <label for="login-email"><?= Lang::$lang["email"] ?></label>
              <input class="form-control" type="email" id="login-email" name="email" required>
            </div>
            <div class="form-group">
              <label for="login-password"><?= Lang::$lang["password"] ?></label>
              <div class="password-toggle">
                <input class="form-control" type="password" id="login-password" name="password" required>
                <label class="password-toggle-btn">
                  <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">Show password</span>
                </label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-shadow"><?= Lang::$lang["login"] ?></button>
          </form>

          <div class="text-center mt-4 font-size-sm">
            <?= Lang::$lang["dontHaveAnAccount?"] ?>
            <a href="<?= Url::getDomain() ?>signup/"><?= Lang::$lang["signup"] ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>