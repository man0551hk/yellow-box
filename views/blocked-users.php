<?php $activePage = 'blocked-users'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= $isTc ? "已封鎖的用戶" : "Blocked Users" ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= $isTc ? "已封鎖的用戶" : "Blocked Users" ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <div class="pt-lg-3 pb-4 mb-3">
        <h6 class="font-size-base text-light mb-0"><?= count($blocked) ?> <?= $isTc ? "位用戶" : "users" ?></h6>
      </div>

      <?php if (!empty($blocked)): ?>
        <div class="list-group box-shadow-sm">
          <?php foreach ($blocked as $user): ?>
            <div class="list-group-item d-flex align-items-center">
              <div class="mr-3">
                <?php if ($user['profilePic']): ?>
                  <img src="<?= $user['profilePic'] ?>" class="rounded-circle" width="48" height="48" alt="">
                <?php else: ?>
                  <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="czi-user text-muted"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="flex-grow-1">
                <a href="<?= Url::getDomain() ?>profile/<?= $user['seo'] ?>/" class="font-weight-medium text-dark">
                  <?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?>
                </a>
              </div>
              <button class="btn btn-sm btn-primary btn-shadow" onclick="unblockUser(<?= $user['blockedUserId'] ?>)">
                <i class="czi-check mr-1"></i><?= $isTc ? "解除封鎖" : "Unblock" ?>
              </button>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-close-circle" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= $isTc ? "暫無封鎖用戶" : "No blocked users" ?></h5>
          <p class="text-muted"><?= $isTc ? "你封鎖的用戶會顯示在這裡" : "Users you block will appear here" ?></p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<script>
function unblockUser(userId) {
  $.post('<?= Url::getDomain() ?>api/toggle-block/', {blockedUserId: userId}, function(data) {
    if (data.success) {
      showToast('<?= $isTc ? "已解除封鎖" : "User unblocked" ?>', 'success');
      location.reload();
    }
  });
}
</script>