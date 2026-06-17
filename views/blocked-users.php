<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0" style="color:#332c24;"><?= Session::get("lang") == "tc" ? "已封鎖的用戶" : "Blocked Users" ?></h4>
  </div>

  <?php if (!empty($blocked)): ?>
    <div class="card border-0 shadow-sm">
      <div class="list-group list-group-flush">
        <?php foreach ($blocked as $user): ?>
          <div class="list-group-item blocked-user-item d-flex align-items-center">
            <div class="mr-3">
              <?php if ($user['profilePic']): ?>
                <img src="<?= $user['profilePic'] ?>" class="avatar">
              <?php else: ?>
                <div class="avatar d-flex align-items-center justify-content-center" style="background:#f3f5f9;">
                  <i class="fas fa-user-circle fa-2x text-muted"></i>
                </div>
              <?php endif; ?>
            </div>
            <div class="flex-grow-1">
              <a href="<?= Url::getDomain() ?>profile/<?= $user['seo'] ?>/" class="font-weight-bold" style="color:#332c24;">
                <?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?>
              </a>
            </div>
            <button class="btn btn-sm btn-yellow" onclick="unblockUser(<?= $user['blockedUserId'] ?>)">
              <i class="fas fa-unlock mr-1"></i><?= Session::get("lang") == "tc" ? "解除封鎖" : "Unblock" ?>
            </button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <i class="fas fa-ban"></i>
      <h5><?= Session::get("lang") == "tc" ? "暫無封鎖用戶" : "No blocked users" ?></h5>
      <p class="text-muted"><?= Session::get("lang") == "tc" ? "你封鎖的用戶會顯示在這裡" : "Users you block will appear here" ?></p>
    </div>
  <?php endif; ?>
</div>

<script>
function unblockUser(userId) {
  $.post('<?= Url::getDomain() ?>api/toggle-block/', {blockedUserId: userId}, function(data) {
    if (data.success) {
      showToast('<?= Session::get("lang") == "tc" ? "已解除封鎖" : "User unblocked" ?>', 'success');
      location.reload();
    }
  });
}
</script>
