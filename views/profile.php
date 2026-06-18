<?php
$isTc = Session::get("lang") == "tc";
$followerCount = $this->userController->getFollowerCount($profileUser['userId']);
$followingCount = $this->userController->getFollowingCount($profileUser['userId']);
?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= htmlspecialchars($profileUser['firstName'] . ' ' . $profileUser['lastName']) ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= htmlspecialchars($profileUser['firstName'] . ' ' . $profileUser['lastName']) ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <aside class="col-lg-3 pt-4 pt-lg-0">
      <div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 pb-0 mb-5 mb-lg-0">
        <div class="px-4 mb-4">
          <div class="media align-items-center flex-column text-center">
            <div class="img-thumbnail rounded-circle position-relative mb-3" style="width:6.375rem;">
              <?php if ($profileUser['profilePic']): ?>
                <img class="rounded-circle" src="<?= $profileUser['profilePic'] ?>" alt="">
              <?php else: ?>
                <div class="rounded-circle bg-secondary text-accent d-flex align-items-center justify-content-center font-weight-bold" style="width:6.375rem;height:6.375rem;font-size:2rem;">
                  <?= strtoupper(substr($profileUser['firstName'], 0, 1)) ?>
                </div>
              <?php endif; ?>
            </div>
            <h3 class="font-size-base mb-1"><?= htmlspecialchars($profileUser['firstName'] . ' ' . $profileUser['lastName']) ?></h3>
            <span class="text-muted font-size-sm"><i class="czi-time mr-1"></i><?= Lang::$lang['memberSince'] ?> <?= date('Y-m') ?></span>
            <?php if ($profileUser['ratingAvg'] > 0): ?>
              <div class="mt-2">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <i class="czi-star<?= $i <= round($profileUser['ratingAvg']) ? ' text-warning' : ' text-muted' ?> font-size-sm"></i>
                <?php endfor; ?>
                <span class="font-size-xs text-muted ml-1">(<?= (int)$profileUser['ratingCount'] ?>)</span>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="px-4 pb-3">
          <div class="row text-center">
            <div class="col-4">
              <div class="font-weight-medium text-dark"><?= count($products) ?></div>
              <div class="font-size-xs text-muted"><?= Lang::$lang['products'] ?></div>
            </div>
            <div class="col-4">
              <div class="font-weight-medium text-dark"><?= $followerCount ?></div>
              <div class="font-size-xs text-muted"><?= Lang::$lang['followers'] ?></div>
            </div>
            <div class="col-4">
              <div class="font-weight-medium text-dark"><?= $followingCount ?></div>
              <div class="font-size-xs text-muted"><?= $isTc ? "關注中" : "Following" ?></div>
            </div>
          </div>
        </div>

        <?php if (Session::get('userId')): ?>
          <div class="px-4 pb-4">
            <?php if (Session::get('userId') == $profileUser['userId']): ?>
              <a href="<?= Url::getDomain() ?>settings/" class="btn btn-outline-accent btn-block btn-sm">
                <i class="czi-settings mr-1"></i><?= Lang::$lang['settings'] ?>
              </a>
            <?php else: ?>
              <a href="<?= Url::getDomain() ?>inbox/<?= $profileUser['userId'] ?>/" class="btn btn-primary btn-block btn-shadow btn-sm mb-2">
                <i class="czi-comment mr-1"></i><?= Lang::$lang['chat'] ?>
              </a>
              <button class="btn btn-outline-accent btn-block btn-sm mb-2" onclick="toggleFollow(<?= $profileUser['userId'] ?>)">
                <i class="czi-user mr-1"></i><span id="followBtnText"><?= $isTc ? "關注" : "Follow" ?></span>
              </button>
              <button class="btn btn-outline-danger btn-block btn-sm" onclick="toggleBlock(<?= $profileUser['userId'] ?>)">
                <i class="czi-close-circle mr-1"></i><?= $isTc ? "封鎖" : "Block" ?>
              </button>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>
    </aside>

    <section class="col-lg-9">
      <!-- Tabs for Products / Reviews -->
      <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="products-tab" data-toggle="tab" href="#products" role="tab" aria-controls="products" aria-selected="true">
            <i class="czi-bag mr-1"></i><?= Lang::$lang['products'] ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">
            <i class="czi-star mr-1"></i><?= Lang::$lang['reviews'] ?>
          </a>
        </li>
      </ul>

      <div class="tab-content" id="profileTabContent">
        <!-- Products Tab -->
        <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
          <?php if (!empty($products)): ?>
            <div class="row mx-n2">
              <?php foreach ($products as $product):
                $colClass = 'col-lg-3 col-md-4 col-6';
                require 'views/partials/product-card.php';
              endforeach; ?>
            </div>
          <?php else: ?>
            <div class="text-center py-5">
              <i class="czi-bag" style="font-size:4rem;color:#ccc;"></i>
              <h5 class="mt-3"><?= Lang::$lang['noProducts'] ?></h5>
            </div>
          <?php endif; ?>
        </div>

        <!-- Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
          <div id="userReviewsContainer">
            <div class="text-center py-5">
              <div class="spinner-border text-primary" role="status"></div>
              <p class="text-muted mt-2"><?= Lang::$lang['loading'] ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<script>
function toggleFollow(userId) {
  $.post('<?= Url::getDomain() ?>api/toggle-follow/', {followingId: userId}, function(data) {
    if (data.success) {
      $('#followBtnText').text(data.following ? '<?= $isTc ? "已關注" : "Following" ?>' : '<?= $isTc ? "關注" : "Follow" ?>');
      showToast(data.following ? '<?= $isTc ? "已關注" : "Following" ?>' : '<?= $isTc ? "已取消關注" : "Unfollowed" ?>', 'success');
    }
  });
}
function toggleBlock(userId) {
  if (confirm('<?= $isTc ? "確定要封鎖此用戶？" : "Block this user?" ?>')) {
    $.post('<?= Url::getDomain() ?>api/toggle-block/', {blockedUserId: userId}, function(data) {
      if (data.success) showToast(data.blocked ? '<?= $isTc ? "已封鎖" : "Blocked" ?>' : '<?= $isTc ? "已解除封鎖" : "Unblocked" ?>', 'success');
    });
  }
}

// Load user reviews
function loadUserReviews() {
  $.get('<?= Url::getDomain() ?>api/get-user-reviews/', {userId: <?= $profileUser['userId'] ?>}, function(data) {
    var container = document.getElementById('userReviewsContainer');
    if (!data || data.length === 0) {
      container.innerHTML = '<div class="text-center py-5"><i class="czi-star" style="font-size:3rem;color:#ccc;"></i><p class="text-muted mt-2 mb-0"><?= Lang::$lang["noReviews"] ?></p></div>';
      return;
    }
    var html = '';
    data.forEach(function(review) {
      var stars = '';
      for (var i = 1; i <= 5; i++) {
        stars += '<i class="czi-star' + (i <= parseInt(review.rating) ? ' text-warning' : ' text-muted') + ' font-size-sm"></i>';
      }
      html += '<div class="card mb-3 border-0 shadow-sm">';
      html += '<div class="card-body">';
      html += '<div class="d-flex align-items-center mb-2">';
      if (review.profilePic) {
        html += '<img src="' + review.profilePic + '" class="rounded-circle mr-2" width="32" height="32" alt="">';
      } else {
        html += '<div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold mr-2" style="width:32px;height:32px;font-size:0.75rem;">' + review.firstName.charAt(0).toUpperCase() + '</div>';
      }
      html += '<div><strong class="font-size-sm">' + escapeHtml(review.firstName + ' ' + review.lastName) + '</strong>';
      html += '<div class="font-size-xs text-muted">' + review.createdDate + '</div></div>';
      html += '<div class="ml-auto">' + stars + '</div></div>';
      if (review.listingTitle) {
        html += '<div class="font-size-xs text-muted mb-1"><?= $isTc ? "商品：" : "Product: " ?> <a href="<?= Url::getDomain() ?>product/' + review.refId + '/" class="text-accent">' + escapeHtml(review.listingTitle) + '</a></div>';
      }
      if (review.comment) {
        html += '<p class="font-size-sm mb-0">' + escapeHtml(review.comment) + '</p>';
      }
      html += '</div></div>';
    });
    container.innerHTML = html;
  });
}

function escapeHtml(text) {
  var div = document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

$(document).ready(function() {
  <?php if (Session::get('userId') && Session::get('userId') != $profileUser['userId']): ?>
  $.get('<?= Url::getDomain() ?>api/is-following/', {followingId: <?= $profileUser['userId'] ?>}, function(data) {
    if (data.following) $('#followBtnText').text('<?= $isTc ? "已關注" : "Following" ?>');
  });
  <?php endif; ?>
  
  // Load reviews when tab is shown
  $('#reviews-tab').on('shown.bs.tab', function() {
    loadUserReviews();
  });
});
</script>
