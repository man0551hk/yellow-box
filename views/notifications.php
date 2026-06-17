<?php $activePage = 'notifications'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang["notifications"] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0">
        <?= Lang::$lang["notifications"] ?>
        <?php if ($unreadCount > 0): ?><span class="badge badge-danger badge-shadow ml-2"><?= $unreadCount ?></span><?php endif; ?>
      </h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center pt-lg-3 pb-4 mb-3">
        <h6 class="font-size-base text-light mb-0"><?= count($notifications) ?> <?= $isTc ? "條通知" : "notifications" ?></h6>
        <?php if (!empty($notifications)): ?>
          <button class="btn btn-sm btn-outline-accent" onclick="markAllRead()">
            <i class="czi-check-double mr-1"></i><?= $isTc ? "全部標記為已讀" : "Mark all as read" ?>
          </button>
        <?php endif; ?>
      </div>

      <?php if (!empty($notifications)): ?>
        <div class="list-group box-shadow-sm">
          <?php foreach ($notifications as $notif):
            $icon = 'czi-bell';
            switch ($notif['type']) {
              case 'newFollower': $icon = 'czi-user'; break;
              case 'newMessage': $icon = 'czi-comment'; break;
              case 'newProduct': $icon = 'czi-bag'; break;
              case 'favorite': $icon = 'czi-heart'; break;
            }
          ?>
            <div class="list-group-item d-flex align-items-center<?= $notif['isRead'] ? '' : ' bg-secondary' ?>">
              <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3" style="width:40px;height:40px;">
                <i class="<?= $icon ?> text-accent"></i>
              </div>
              <div class="flex-grow-1 min-width-0">
                <p class="mb-1 font-size-sm"><?= htmlspecialchars($notif['message']) ?></p>
                <small class="text-muted"><i class="czi-time mr-1"></i><?= date('Y-m-d H:i', strtotime($notif['createdDate'])) ?></small>
              </div>
              <?php if (!$notif['isRead']): ?>
                <button class="btn btn-sm btn-primary ml-2" onclick="markRead(<?= $notif['notificationId'] ?>)">
                  <i class="czi-check"></i>
                </button>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-bell" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= $isTc ? "暫無通知" : "No notifications" ?></h5>
          <p class="text-muted"><?= $isTc ? "當有人關注你或發送訊息時，你會在這裡收到通知" : "You'll receive notifications when someone follows you or sends you a message" ?></p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<script>
function markRead(id) {
  $.post('<?= Url::getDomain() ?>api/mark-notification-read/', {notificationId: id}, function() { location.reload(); });
}
function markAllRead() {
  $.post('<?= Url::getDomain() ?>api/mark-all-notifications-read/', function() { location.reload(); });
}
</script>