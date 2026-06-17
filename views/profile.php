<div class="container py-4">
  <div class="row">
    <div class="col-lg-3 mb-4">
      <div class="card border-0 shadow-sm text-center">
        <div class="card-body p-4">
          <?php if ($profileUser['profilePic']): ?>
            <img src="<?= $profileUser['profilePic'] ?>" class="avatar avatar-xl mb-3">
          <?php else: ?>
            <div class="avatar avatar-xl bg-warning d-flex align-items-center justify-content-center text-white font-weight-bold mx-auto mb-3" style="font-size:2.5rem;">
              <?= strtoupper(substr($profileUser['firstName'], 0, 1)) ?>
            </div>
          <?php endif; ?>
          <h5 class="font-weight-bold"><?= htmlspecialchars($profileUser['firstName'] . ' ' . $profileUser['lastName']) ?></h5>
          <p class="text-muted small"><?= Lang::$lang['memberSince'] ?> <?= date('Y-m') ?></p>
          
          <?php
          $followerCount = $this->userController->getFollowerCount($profileUser['userId']);
          $followingCount = $this->userController->getFollowingCount($profileUser['userId']);
          ?>
          <div class="d-flex justify-content-around mt-3">
            <div>
              <div class="font-weight-bold"><?= count($products) ?></div>
              <small class="text-muted"><?= Lang::$lang['products'] ?></small>
            </div>
            <div>
              <div class="font-weight-bold"><?= $followerCount ?></div>
              <small class="text-muted"><?= Lang::$lang['followers'] ?></small>
            </div>
            <div>
              <div class="font-weight-bold"><?= $followingCount ?></div>
              <small class="text-muted"><?= Session::get("lang") == "tc" ? "關注中" : "Following" ?></small>
            </div>
          </div>
          
          <?php if ($profileUser['responseRate'] > 0 || $profileUser['responseTime']): ?>
            <div class="mt-3 small text-muted">
              <?php if ($profileUser['responseRate'] > 0): ?>
                <div><i class="fas fa-reply mr-1"></i><?= $profileUser['responseRate'] ?>% <?= Session::get("lang") == "tc" ? "回覆率" : "response rate" ?></div>
              <?php endif; ?>
              <?php if ($profileUser['responseTime']): ?>
                <div><i class="fas fa-clock mr-1"></i><?= $profileUser['responseTime'] ?></div>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          
          <?php if (Session::get('userId')): ?>
            <?php if (Session::get('userId') == $profileUser['userId']): ?>
              <a href="<?= Url::getDomain() ?>settings/" class="btn btn-outline-secondary btn-block mt-3">
                <i class="fas fa-cog mr-2"></i><?= Lang::$lang['settings'] ?>
              </a>
            <?php else: ?>
              <a href="<?= Url::getDomain() ?>inbox/<?= $profileUser['userId'] ?>/" class="btn btn-yellow btn-block mt-3">
                <i class="fas fa-comment mr-2"></i><?= Lang::$lang['chat'] ?>
              </a>
              <button class="btn btn-outline-primary btn-block mt-2" onclick="toggleFollow(<?= $profileUser['userId'] ?>)">
                <i class="fas fa-user-plus mr-1"></i><span id="followBtnText"><?= Session::get("lang") == "tc" ? "關注" : "Follow" ?></span>
              </button>
              <button class="btn btn-outline-danger btn-block mt-2" onclick="toggleBlock(<?= $profileUser['userId'] ?>)">
                <i class="fas fa-ban mr-1"></i><?= Session::get("lang") == "tc" ? "封鎖" : "Block" ?>
              </button>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <div class="col-lg-9">
      <h5 class="section-title"><?= Lang::$lang['products'] ?></h5>
      
      <?php if (!empty($products)): ?>
        <div class="row">
          <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-md-4 col-6 mb-3">
              <div class="card product-card h-100">
                <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/">
                  <img src="<?= $product['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($product['listingTitle']) ?>">
                </a>
                <div class="card-body p-3">
                  <p class="card-text small text-muted mb-1">
                    <span class="category-badge"><?= $product['category_name'] ?></span>
                  </p>
                  <h6 class="card-title mb-1">
                    <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 30)) ?></a>
                  </h6>
                  <p class="product-price mb-0">$<?= number_format($product['price']) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="fas fa-box-open"></i>
          <h5><?= Lang::$lang['noProducts'] ?></h5>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function toggleFollow(userId) {
  $.post('<?= Url::getDomain() ?>api/toggle-follow/', {followingId: userId}, function(data) {
    if (data.success) {
      if (data.following) {
        $('#followBtnText').text('<?= Session::get("lang") == "tc" ? "已關注" : "Following" ?>');
        showToast('<?= Session::get("lang") == "tc" ? "已關注" : "Following" ?>', 'success');
      } else {
        $('#followBtnText').text('<?= Session::get("lang") == "tc" ? "關注" : "Follow" ?>');
        showToast('<?= Session::get("lang") == "tc" ? "已取消關注" : "Unfollowed" ?>', 'info');
      }
    }
  });
}

function toggleBlock(userId) {
  if (confirm('<?= Session::get("lang") == "tc" ? "確定要封鎖此用戶？" : "Block this user?" ?>')) {
    $.post('<?= Url::getDomain() ?>api/toggle-block/', {blockedUserId: userId}, function(data) {
      if (data.success) {
        showToast(data.blocked ? '<?= Session::get("lang") == "tc" ? "已封鎖" : "Blocked" ?>' : '<?= Session::get("lang") == "tc" ? "已解除封鎖" : "Unblocked" ?>', 'success');
      }
    });
  }
}

$(document).ready(function() {
  <?php if (Session::get('userId') && Session::get('userId') != $profileUser['userId']): ?>
  $.get('<?= Url::getDomain() ?>api/is-following/', {followingId: <?= $profileUser['userId'] ?>}, function(data) {
    if (data.following) {
      $('#followBtnText').text('<?= Session::get("lang") == "tc" ? "已關注" : "Following" ?>');
    }
  });
  <?php endif; ?>
});
</script>
