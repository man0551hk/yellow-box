<?php $activePage = 'inbox'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['myMessages'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['myMessages'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <!-- Tabs for Chat / Purchase Requests / My Purchases -->
  <ul class="nav nav-tabs mb-4" id="inboxTabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="true">
        <i class="czi-comment mr-1"></i><?= Lang::$lang['myMessages'] ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="purchase-requests-tab" data-toggle="tab" href="#purchase-requests" role="tab" aria-controls="purchase-requests" aria-selected="false">
        <i class="czi-bag mr-1"></i><?= Lang::$lang['purchaseRequests'] ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="my-purchases-tab" data-toggle="tab" href="#my-purchases" role="tab" aria-controls="my-purchases" aria-selected="false">
        <i class="czi-basket mr-1"></i><?= Lang::$lang['myPurchases'] ?>
      </a>
    </li>
  </ul>

  <div class="tab-content" id="inboxTabContent">
    <!-- Chat Tab -->
    <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 overflow-hidden">
            <div class="bg-secondary px-4 py-3">
              <h3 class="font-size-sm mb-0 text-muted"><i class="czi-comment mr-1"></i><?= Lang::$lang['myMessages'] ?></h3>
            </div>
            <div data-simplebar data-simplebar-auto-hide="false" style="max-height:28rem;">
              <?php if (!empty($conversations)): ?>
                <?php foreach ($conversations as $conv): ?>
                  <a href="<?= Url::getDomain() ?>inbox/<?= $conv['otherUserId'] ?>/" class="d-flex align-items-center px-4 py-3 text-dark text-decoration-none border-bottom<?= isset($activeConversation) && $activeConversation == $conv['otherUserId'] ? ' bg-secondary' : '' ?>">
                    <div class="mr-3 position-relative flex-shrink-0">
                      <?php if ($conv['user']['profilePic']): ?>
                        <img src="<?= $conv['user']['profilePic'] ?>" class="rounded-circle" width="44" height="44" alt="">
                      <?php else: ?>
                        <div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold" style="width:44px;height:44px;">
                          <?= strtoupper(substr($conv['user']['firstName'], 0, 1)) ?>
                        </div>
                      <?php endif; ?>
                      <?php if ($conv['unread'] > 0): ?>
                        <span class="badge badge-danger badge-pill position-absolute" style="top:-4px;right:-4px;"><?= $conv['unread'] ?></span>
                      <?php endif; ?>
                    </div>
                    <div class="flex-grow-1 min-width-0">
                      <div class="font-size-sm font-weight-medium"><?= htmlspecialchars($conv['user']['firstName'] . ' ' . $conv['user']['lastName']) ?></div>
                      <div class="font-size-xs text-muted text-truncate"><?= htmlspecialchars(mb_substr($conv['lastMessage'], 0, 50)) ?></div>
                    </div>
                  </a>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="text-center py-5 px-3">
                  <i class="czi-comment" style="font-size:3rem;color:#ccc;"></i>
                  <p class="text-muted mt-2 mb-0"><?= Lang::$lang['noMessages'] ?></p>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="bg-secondary rounded-lg box-shadow-lg overflow-hidden">
            <?php if (isset($otherUser)): ?>
              <div class="px-4 py-3 border-bottom d-flex align-items-center bg-light">
                <?php if ($otherUser['profilePic']): ?>
                  <img src="<?= $otherUser['profilePic'] ?>" class="rounded-circle mr-3" width="44" height="44" alt="">
                <?php else: ?>
                  <div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold mr-3" style="width:44px;height:44px;">
                    <?= strtoupper(substr($otherUser['firstName'], 0, 1)) ?>
                  </div>
                <?php endif; ?>
                <div>
                  <strong class="text-dark"><?= htmlspecialchars($otherUser['firstName'] . ' ' . $otherUser['lastName']) ?></strong>
                  <div class="font-size-xs text-muted"><i class="czi-check-circle text-success mr-1"></i><?= Lang::$lang['online'] ?></div>
                </div>
              </div>

              <div class="px-4 py-3 chat-messages" id="chatMessages" style="min-height:20rem;max-height:28rem;overflow-y:auto;" data-simplebar data-simplebar-auto-hide="false">
                <?php if (!empty($messages)): ?>
                  <?php foreach ($messages as $msg): ?>
                    <div class="mb-3 d-flex<?= $msg['fromUserId'] == Session::get('userId') ? ' justify-content-end' : '' ?>">
                      <div class="rounded-lg px-3 py-2 font-size-sm<?= $msg['fromUserId'] == Session::get('userId') ? ' bg-primary text-white' : ' bg-light' ?>" style="max-width:75%;">
                        <?= nl2br(htmlspecialchars($msg['content'])) ?>
                        <div class="font-size-xs opacity-75 text-right mt-1"><?= date('H:i', strtotime($msg['sentDate'])) ?></div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>

              <div class="px-4 py-3 border-top bg-light">
                <form method="POST" action="" class="input-group">
                  <input type="text" class="form-control" name="content" placeholder="<?= Lang::$lang['typeMessage'] ?>" required>
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary btn-shadow"><i class="czi-send mr-1"></i><?= Lang::$lang['send'] ?></button>
                  </div>
                </form>
              </div>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="czi-comment-dots" style="font-size:4rem;color:#ccc;"></i>
                <h5 class="mt-3"><?= Lang::$lang['inboxBanner'] ?></h5>
                <p class="text-muted"><?= $isTc ? "揀一個對話開始傾計" : "Select a conversation to start chatting" ?></p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Purchase Requests Tab (Seller view) -->
    <div class="tab-pane fade" id="purchase-requests" role="tabpanel" aria-labelledby="purchase-requests-tab">
      <div class="bg-secondary rounded-lg box-shadow-lg p-4">
        <h5 class="mb-3"><i class="czi-bag mr-1"></i><?= Lang::$lang['pendingPurchases'] ?></h5>
        <div id="pendingIntentsContainer">
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-muted mt-2"><?= Lang::$lang['loading'] ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- My Purchases Tab (Buyer view) -->
    <div class="tab-pane fade" id="my-purchases" role="tabpanel" aria-labelledby="my-purchases-tab">
      <div class="bg-secondary rounded-lg box-shadow-lg p-4">
        <h5 class="mb-3"><i class="czi-basket mr-1"></i><?= Lang::$lang['myPurchases'] ?></h5>
        <div id="buyerIntentsContainer">
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="text-muted mt-2"><?= Lang::$lang['loading'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var chatMessages = document.getElementById('chatMessages');
if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

// Load pending purchase intents (for seller)
function loadPendingIntents() {
  $.get('<?= Url::getDomain() ?>api/get-pending-intents/', function(data) {
    var container = document.getElementById('pendingIntentsContainer');
    if (!data || data.length === 0) {
      container.innerHTML = '<div class="text-center py-5"><i class="czi-bag" style="font-size:3rem;color:#ccc;"></i><p class="text-muted mt-2 mb-0"><?= Lang::$lang["noPendingPurchases"] ?></p></div>';
      return;
    }
    var html = '';
    data.forEach(function(intent) {
      html += '<div class="card mb-3 border-0 shadow-sm">';
      html += '<div class="card-body">';
      html += '<div class="d-flex align-items-center mb-2">';
      if (intent.buyerProfilePic) {
        html += '<img src="' + intent.buyerProfilePic + '" class="rounded-circle mr-2" width="36" height="36" alt="">';
      } else {
        html += '<div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold mr-2" style="width:36px;height:36px;font-size:0.875rem;">' + intent.buyerFirstName.charAt(0).toUpperCase() + '</div>';
      }
      html += '<div><strong class="font-size-sm">' + escapeHtml(intent.buyerFirstName + ' ' + intent.buyerLastName) + '</strong>';
      html += '<div class="font-size-xs text-muted"><?= Lang::$lang["wantsToBuy"] ?></div></div></div>';
      html += '<div class="d-flex align-items-center mb-2">';
      if (intent.productImage) {
        html += '<img src="' + intent.productImage + '" class="rounded mr-2" width="48" height="48" style="object-fit:cover;" alt="">';
      }
      html += '<div><a href="<?= Url::getDomain() ?>product/' + intent.productRefId + '/" class="font-size-sm font-weight-medium text-dark">' + escapeHtml(intent.productTitle) + '</a>';
      html += '<div class="font-size-xs text-muted">$' + parseFloat(intent.productPrice).toFixed(2) + '</div></div></div>';
      html += '<div class="d-flex">';
      html += '<button class="btn btn-success btn-sm mr-2" onclick="confirmIntent(' + intent.intentId + ')"><i class="czi-check mr-1"></i><?= Lang::$lang["confirmBuyer"] ?></button>';
      html += '<button class="btn btn-outline-secondary btn-sm" onclick="cancelIntent(' + intent.intentId + ')"><?= Lang::$lang["cancelIntent"] ?></button>';
      html += '</div></div></div>';
    });
    container.innerHTML = html;
  });
}

// Load buyer intents (for buyer)
function loadBuyerIntents() {
  $.get('<?= Url::getDomain() ?>api/get-buyer-intents/', function(data) {
    var container = document.getElementById('buyerIntentsContainer');
    if (!data || data.length === 0) {
      container.innerHTML = '<div class="text-center py-5"><i class="czi-basket" style="font-size:3rem;color:#ccc;"></i><p class="text-muted mt-2 mb-0"><?= $isTc ? "暫無購買記錄" : "No purchase records" ?></p></div>';
      return;
    }
    var html = '';
    data.forEach(function(intent) {
      var statusBadge = '';
      var reviewBtn = '';
      if (intent.status == 'pending') {
        statusBadge = '<span class="badge badge-warning"><?= $isTc ? "待確認" : "Pending" ?></span>';
      } else if (intent.status == 'confirmed') {
        statusBadge = '<span class="badge badge-success"><?= $isTc ? "已確認" : "Confirmed" ?></span>';
        reviewBtn = '<button class="btn btn-outline-primary btn-sm ml-2" onclick="openReviewModal(' + intent.intentId + ',' + intent.sellerId + ',' + intent.productId + ')"><i class="czi-star mr-1"></i><?= Lang::$lang["leaveReview"] ?></button>';
      } else if (intent.status == 'cancelled') {
        statusBadge = '<span class="badge badge-secondary"><?= $isTc ? "已取消" : "Cancelled" ?></span>';
      }
      
      html += '<div class="card mb-3 border-0 shadow-sm">';
      html += '<div class="card-body">';
      html += '<div class="d-flex align-items-center mb-2">';
      if (intent.sellerProfilePic) {
        html += '<img src="' + intent.sellerProfilePic + '" class="rounded-circle mr-2" width="36" height="36" alt="">';
      } else {
        html += '<div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold mr-2" style="width:36px;height:36px;font-size:0.875rem;">' + intent.sellerFirstName.charAt(0).toUpperCase() + '</div>';
      }
      html += '<div><strong class="font-size-sm">' + escapeHtml(intent.sellerFirstName + ' ' + intent.sellerLastName) + '</strong>';
      html += '<div class="font-size-xs text-muted">' + statusBadge + '</div></div></div>';
      html += '<div class="d-flex align-items-center mb-2">';
      if (intent.productImage) {
        html += '<img src="' + intent.productImage + '" class="rounded mr-2" width="48" height="48" style="object-fit:cover;" alt="">';
      }
      html += '<div><a href="<?= Url::getDomain() ?>product/' + intent.productRefId + '/" class="font-size-sm font-weight-medium text-dark">' + escapeHtml(intent.productTitle) + '</a>';
      html += '<div class="font-size-xs text-muted">$' + parseFloat(intent.productPrice).toFixed(2) + '</div></div></div>';
      html += '<div class="d-flex">';
      html += '<a href="<?= Url::getDomain() ?>inbox/' + intent.sellerId + '/" class="btn btn-outline-accent btn-sm"><i class="czi-comment mr-1"></i><?= Lang::$lang["chatNow"] ?></a>';
      html += reviewBtn;
      html += '</div></div></div>';
    });
    container.innerHTML = html;
  });
}

// Confirm purchase intent (seller)
function confirmIntent(intentId) {
  if (!confirm('<?= $isTc ? "確定確認呢個買家購買？確認後雙方可以互相評分。" : "Confirm this buyer's purchase? After confirmation, both parties can rate each other." ?>')) return;
  $.post('<?= Url::getDomain() ?>api/confirm-purchase-intent/', {intentId: intentId}, function(data) {
    if (data.success) {
      showToast(data.message, 'success');
      loadPendingIntents();
    } else {
      showToast(data.message, 'warning');
    }
  });
}

// Cancel purchase intent
function cancelIntent(intentId) {
  if (!confirm('<?= $isTc ? "確定取消此購買請求？" : "Cancel this purchase request?" ?>')) return;
  $.post('<?= Url::getDomain() ?>api/confirm-purchase-intent/', {intentId: intentId}, function(data) {
    if (data.success) {
      showToast(data.message, 'success');
      loadPendingIntents();
    } else {
      showToast(data.message, 'warning');
    }
  });
}

// Review Modal
function openReviewModal(intentId, toUserId, productId) {
  var modal = document.createElement('div');
  modal.className = 'modal fade show d-block';
  modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
  modal.id = 'reviewModal';
  modal.innerHTML = '<div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title"><?= Lang::$lang["writeAReview"] ?></h5><button type="button" class="close" onclick="closeReviewModal()">&times;</button></div><div class="modal-body"><div class="form-group"><label class="font-size-sm font-weight-medium"><?= Lang::$lang["rating"] ?></label><div class="star-rating mb-2" id="starRating">';
  for (var i = 1; i <= 5; i++) {
    modal.innerHTML += '<i class="czi-star text-muted font-size-lg mr-1" style="cursor:pointer;" data-star="' + i + '" onclick="setRating(' + i + ')"></i>';
  }
  modal.innerHTML += '</div><input type="hidden" id="reviewRating" value="0"></div><div class="form-group"><label class="font-size-sm font-weight-medium" for="reviewComment"><?= Lang::$lang["reviewComment"] ?></label><textarea class="form-control" id="reviewComment" rows="3" placeholder="<?= Lang::$lang["reviewComment"] ?>"></textarea></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" onclick="closeReviewModal()"><?= Lang::$lang["cancel"] ?></button><button type="button" class="btn btn-primary" onclick="submitReview(' + intentId + ',' + toUserId + ',' + productId + ')"><?= Lang::$lang["submitReview"] ?></button></div></div></div>';
  document.body.appendChild(modal);
  document.getElementById('reviewRating').value = 0;
}

function closeReviewModal() {
  var modal = document.getElementById('reviewModal');
  if (modal) modal.remove();
}

function setRating(val) {
  document.getElementById('reviewRating').value = val;
  var stars = document.querySelectorAll('#starRating i');
  stars.forEach(function(star, index) {
    if (index < val) {
      star.className = 'czi-star text-warning font-size-lg mr-1';
    } else {
      star.className = 'czi-star text-muted font-size-lg mr-1';
    }
  });
}

function submitReview(intentId, toUserId, productId) {
  var rating = document.getElementById('reviewRating').value;
  var comment = document.getElementById('reviewComment').value;
  
  if (rating == 0) {
    showToast('<?= $isTc ? "請選擇評分" : "Please select a rating" ?>', 'warning');
    return;
  }
  
  $.post('<?= Url::getDomain() ?>api/submit-review/', {
    intentId: intentId,
    toUserId: toUserId,
    productId: productId,
    rating: rating,
    comment: comment
  }, function(data) {
    if (data.success) {
      showToast(data.message, 'success');
      closeReviewModal();
      loadBuyerIntents();
    } else {
      showToast(data.message, 'warning');
    }
  });
}

$(document).ready(function() {
  loadPendingIntents();
  loadBuyerIntents();
});
</script>
