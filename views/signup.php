<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm border-0">
        <div class="card-body p-5">
          <h3 class="text-center mb-4"><?= Lang::$lang["signup"] ?></h3>
          
          <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-auto-hide"><?= $error ?></div>
          <?php endif; ?>
          <?php if (isset($success)): ?>
            <div class="alert alert-success alert-auto-hide"><?= $success ?></div>
          <?php endif; ?>
          
          <form method="POST" action="" id="signupForm">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><?= Lang::$lang["firstName"] ?></label>
                <input type="text" class="form-control" name="firstName" required>
              </div>
              <div class="form-group col-md-6">
                <label><?= Lang::$lang["lastName"] ?></label>
                <input type="text" class="form-control" name="lastName" required>
              </div>
            </div>
            <div class="form-group">
              <label><?= Lang::$lang["email"] ?></label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
              <label><?= Lang::$lang["password"] ?></label>
              <input type="password" class="form-control" name="password" id="password" required pattern="(?=.*[A-Za-z])(?=.*\d).{8,}">
              <small class="form-text text-muted"><?= Lang::$lang["passwordNotice"] ?></small>
            </div>
            <div class="form-group">
              <label><?= Lang::$lang["confirmPassword"] ?></label>
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required>
              <small class="form-text text-danger d-none" id="passwordMatchError"><?= Lang::$lang["confirmPasswordError"] ?></small>
            </div>
            <button type="submit" class="btn btn-yellow btn-block btn-lg"><?= Lang::$lang["signup"] ?></button>
          </form>
          
          <div class="text-center mt-3">
            <small><?= Lang::$lang["alreadyHaveAnAccount?"] ?> <a href="<?= Url::getDomain() ?>login/"><?= Lang::$lang["login"] ?></a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('signupForm').addEventListener('submit', function(e) {
  var password = document.getElementById('password').value;
  var confirm = document.getElementById('confirmPassword').value;
  if (password !== confirm) {
    e.preventDefault();
    document.getElementById('passwordMatchError').classList.remove('d-none');
  }
});
document.getElementById('confirmPassword').addEventListener('input', function() {
  document.getElementById('passwordMatchError').classList.add('d-none');
});
</script>
