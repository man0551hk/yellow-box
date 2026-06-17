<div class="container pb-5 mb-2 mb-md-4">
  <div class="row justify-content-center pt-5">
    <div class="col-md-6">
      <div class="card border-0 box-shadow-lg">
        <div class="card-body p-4 p-md-5">
          <h3 class="text-center mb-4"><?= Lang::$lang["signup"] ?></h3>

          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-auto-hide"><?= $error ?></div>
          <?php endif; ?>
          <?php if (isset($success)): ?>
            <div class="alert alert-success alert-auto-hide"><?= $success ?></div>
          <?php endif; ?>

          <form class="needs-validation" method="POST" action="" id="signupForm" novalidate>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="signup-first"><?= Lang::$lang["firstName"] ?></label>
                <input class="form-control" type="text" id="signup-first" name="firstName" required>
              </div>
              <div class="form-group col-md-6">
                <label for="signup-last"><?= Lang::$lang["lastName"] ?></label>
                <input class="form-control" type="text" id="signup-last" name="lastName" required>
              </div>
            </div>
            <div class="form-group">
              <label for="signup-email"><?= Lang::$lang["email"] ?></label>
              <input class="form-control" type="email" id="signup-email" name="email" required>
            </div>
            <div class="form-group">
              <label for="signup-password"><?= Lang::$lang["password"] ?></label>
              <div class="password-toggle">
                <input class="form-control" type="password" id="password" name="password" required pattern="(?=.*[A-Za-z])(?=.*\d).{8,}">
                <label class="password-toggle-btn">
                  <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">Show password</span>
                </label>
              </div>
              <small class="form-text text-muted"><?= Lang::$lang["passwordNotice"] ?></small>
            </div>
            <div class="form-group">
              <label for="confirmPassword"><?= Lang::$lang["confirmPassword"] ?></label>
              <div class="password-toggle">
                <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" required>
                <label class="password-toggle-btn">
                  <input class="custom-control-input" type="checkbox"><i class="czi-eye password-toggle-indicator"></i><span class="sr-only">Show password</span>
                </label>
              </div>
              <small class="form-text text-danger d-none" id="passwordMatchError"><?= Lang::$lang["confirmPasswordError"] ?></small>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-shadow"><?= Lang::$lang["signup"] ?></button>
          </form>

          <div class="text-center mt-4 font-size-sm">
            <?= Lang::$lang["alreadyHaveAnAccount?"] ?>
            <a href="<?= Url::getDomain() ?>login/"><?= Lang::$lang["login"] ?></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('signupForm').addEventListener('submit', function(e) {
  if (document.getElementById('password').value !== document.getElementById('confirmPassword').value) {
    e.preventDefault();
    document.getElementById('passwordMatchError').classList.remove('d-none');
  }
});
document.getElementById('confirmPassword').addEventListener('input', function() {
  document.getElementById('passwordMatchError').classList.add('d-none');
});
</script>