<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0" style="color:#332c24;"><?= Lang::$lang["notifications"] ?>
      <?php if ($unreadCount > 0): ?>
        <span class="badge badge-danger badge-pill ml-2 notification-badge"><?= $unreadCount ?></span>
      <?php endif; ?>
    </h4>
    <?php if (!empty($notifications)): ?>
      <button class="btn btn-sm btn-outline-secondary" onclick="markAllRead()">
        <i class="fas fa-check-double mr-1"></i><?= Session::get("lang") == "tc" ? "全部標記為已讀" : "Mark all as read" ?>
      </button>
    <?php endif; ?>
  </div>

  <?php if (!empty($notifications)): ?>
    <div class="card border-0 shadow-sm">
      <div class="list-group list-group-flush">
        <?php foreach ($notifications as $notif): ?>
          <div class="list-group-item list-group-item-action notification-item <?= $notif['isRead'] ? '' : 'unread' ?> d-flex align-items-center">
            <div class="notification-icon mr-3">
              <?php
              $icon = 'fa-bell';
              switch ($notif['type']) {
                case 'newFollower': $icon = 'fa-user-plus'; break;
                case 'newMessage': $icon = 'fa-comment'; break;
                case 'newProduct': $icon = 'fa-box'; break;
                case 'favorite': $icon = 'fa-heart'; break;
              }
              ?>
              <i class="fas <?= $icon ?>"></i>
            </div>
            <div class="flex-grow-1 min-width-0">
              <p class="mb-1"><?= htmlspecialchars($notif['message']) ?></p>
              <small class="text-muted"><i class="far fa-clock mr-1"></i><?= date('Y-m-d H:i', strtotime($notif['createdDate'])) ?></small>
            </div>
            <?php if (!$notif['isRead']): ?>
              <button class="btn btn-sm btn-yellow ml-2" onclick="markRead(<?= $notif['notificationId'] ?>)">
                <i class="fas fa-check"></i>
              </button>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <i class="fas fa-bell"></i>
      <h5><?= Session::get("lang") == "tc" ? "暫無通知" : "No notifications" ?></h5>
      <p class="text-muted"><?= Session::get("lang") == "tc" ? "當有人關注你或發送訊息時，你會在這裡收到通知" : "You'll receive notifications when someone follows you or sends you a message" ?></p>
    </div>
  <?php endif; ?>
</div>

<script>
function markRead(id) {
  $.post('<?= Url::getDomain() ?>api/mark-notification-read/', {notificationId: id}, function() {
    location.reload();
  });
}

function markAllRead() {
  $.post('<?= Url::getDomain() ?>api/mark-all-notifications-read/', function() {
    location.reload();
  });
}
</script>
