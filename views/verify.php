<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
          <?php if ($result['success']): ?>
            <i class="fas fa-check-circle text-success" style="font-size:4rem;"></i>
            <h4 class="mt-3"><?= Lang::$lang['verified'] ?></h4>
            <p><?= $result['message'] ?></p>
          <?php else: ?>
            <i class="fas fa-times-circle text-danger" style="font-size:4rem;"></i>
            <h4 class="mt-3"><?= Lang::$lang['notVerified'] ?></h4>
            <p><?= $result['message'] ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
