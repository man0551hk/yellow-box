<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm border-0">
        <div class="card-body p-5">
          <h3 class="text-center mb-4"><?= Lang::$lang["login"] ?></h3>
          
          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-auto-hide"><?= $error ?></div>
          <?php endif; ?>
          
          <form method="POST" action="">
            <div class="form-group">
              <label><?= Lang::$lang["email"] ?></label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
              <label><?= Lang::$lang["password"] ?></label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-yellow btn-block btn-lg"><?= Lang::$lang["login"] ?></button>
          </form>
          
          <div class="text-center mt-3">
            <small><?= Lang::$lang["dontHaveAnAccount?"] ?> <a href="<?= Url::getDomain() ?>signup/"><?= Lang::$lang["signup"] ?></a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
