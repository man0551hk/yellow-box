<div class="container pb-5 mb-2 mb-md-4">
  <div class="row justify-content-center pt-5">
    <div class="col-md-6">
      <div class="card border-0 box-shadow-lg">
        <div class="card-body p-5 text-center">
          <?php if ($result['success']): ?>
            <i class="czi-check-circle text-success" style="font-size:4rem;"></i>
            <h4 class="mt-3"><?= Lang::$lang['verified'] ?></h4>
            <p class="text-muted"><?= $result['message'] ?></p>
          <?php else: ?>
            <i class="czi-close-circle text-danger" style="font-size:4rem;"></i>
            <h4 class="mt-3"><?= Lang::$lang['notVerified'] ?></h4>
            <p class="text-muted"><?= $result['message'] ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>