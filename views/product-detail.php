<?php
$isTc = Session::get("lang") == "tc";
$priceParts = explode('.', number_format((float)$product['price'], 2, '.', ''));
$isOwner = Session::get('userId') && Session::get('userId') == $product['seller']['userId'];
?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="<?= Url::SetLink($product['category_seo']) ?>"><?= htmlspecialchars($product['category_name']) ?></a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 30)) ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 50)) ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="bg-light box-shadow-lg rounded-lg px-4 py-3 mb-4">
    <div class="px-lg-3">
      <div class="row">
        <div class="col-lg-7 pr-lg-0 pt-lg-2 mb-4 mb-lg-0">
          <?php if ($product['isSold']): ?>
            <span class="badge badge-danger badge-shadow mb-2"><?= $isTc ? "已售出" : "Sold" ?></span>
          <?php endif; ?>
          <?php if (!empty($product['images']) && count($product['images']) > 1): ?>
            <div class="cz-product-gallery">
              <div class="cz-preview order-sm-2">
                <?php foreach ($product['images'] as $i => $img): ?>
                  <div class="cz-preview-item<?= $i == 0 ? ' active' : '' ?>" id="img-<?= $i ?>">
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['listingTitle']) ?>">
                  </div>
                <?php endforeach; ?>
              </div>
              <div class="cz-thumblist order-sm-1">
                <?php foreach ($product['images'] as $i => $img): ?>
                  <a class="cz-thumblist-item<?= $i == 0 ? ' active' : '' ?>" href="#img-<?= $i ?>"><img src="<?= $img ?>" alt="thumb"></a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php else: ?>
            <img class="rounded-lg w-100" id="mainImage" src="<?= !empty($product['images']) ? $product['images'][0] : Url::getDomain() . 'images/test.jpg' ?>" alt="<?= htmlspecialchars($product['listingTitle']) ?>">
          <?php endif; ?>
        </div>

        <div class="col-lg-5 pt-lg-4">
          <div class="product-details ml-auto pb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <a class="product-meta d-block font-size-sm pb-1" href="<?= Url::SetLink($product['category_seo']) ?>"><?= htmlspecialchars($product['category_name']) ?></a>
              <div>
                <?php if (Session::get('userId')): ?>
                  <button class="btn-wishlist" type="button" onclick="toggleFavorite(<?= $product['productId'] ?>)" data-toggle="tooltip" title="<?= Lang::$lang['myFavorites'] ?>"><i class="czi-heart"></i></button>
                <?php endif; ?>
                <button class="btn-wishlist ml-1" type="button" onclick="shareProduct()" data-toggle="tooltip" title="<?= $isTc ? "分享" : "Share" ?>"><i class="czi-share"></i></button>
              </div>
            </div>

            <h2 class="h3 mb-3"><?= htmlspecialchars($product['listingTitle']) ?></h2>
            <div class="mb-3">
              <span class="h3 font-weight-normal text-accent mr-1">$<?= $priceParts[0] ?>.<small><?= $priceParts[1] ?? '00' ?></small></span>
            </div>

            <div class="mb-3">
              <span class="badge badge-<?= $product['condition'] == 1 ? 'success' : 'info' ?> badge-shadow mr-2">
                <?= $product['condition'] == 1 ? Lang::$lang['brandnew'] : Lang::$lang['secondhand'] ?>
              </span>
              <?php if ($product['brand']): ?>
                <span class="badge badge-secondary badge-shadow"><?= htmlspecialchars($product['brand']) ?></span>
              <?php endif; ?>
            </div>

            <div class="font-size-sm mb-4">
              <span class="text-heading font-weight-medium mr-1"><i class="czi-time mr-1"></i><?= Lang::$lang['postedOn'] ?>:</span>
              <span class="text-muted"><?= date('Y-m-d', strtotime($product['createdDate'])) ?></span>
              <span class="text-muted ml-3"><i class="czi-eye mr-1"></i><?= (int)$product['viewCount'] ?> <?= $isTc ? "次瀏覽" : "views" ?></span>
            </div>

            <?php if ($product['seller']): ?>
              <div class="bg-secondary rounded-lg p-3 mb-4">
                <div class="media align-items-center">
                  <?php if ($product['seller']['profilePic']): ?>
                    <img src="<?= $product['seller']['profilePic'] ?>" class="rounded-circle mr-3" width="56" height="56" alt="">
                  <?php else: ?>
                    <div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center mr-3 font-weight-bold" style="width:56px;height:56px;">
                      <?= strtoupper(substr($product['seller']['firstName'], 0, 1)) ?>
                    </div>
                  <?php endif; ?>
                  <div class="media-body">
                    <a href="<?= Url::getDomain() ?>profile/<?= $product['seller']['seo'] ?>/" class="font-weight-medium text-dark">
                      <?= htmlspecialchars($product['seller']['firstName'] . ' ' . $product['seller']['lastName']) ?>
                    </a>
                    <div class="font-size-xs text-muted mt-1">
                      <?php if ($product['seller']['responseRate'] > 0): ?>
                        <span class="mr-2"><i class="czi-check-circle text-success mr-1"></i><?= $product['seller']['responseRate'] ?>%</span>
                      <?php endif; ?>
                      <?php if ($product['seller']['lastActive']): ?>
                        <span><i class="czi-time mr-1"></i><?= $product['seller']['lastActive'] ?></span>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <?php if (Session::get('userId') && !$isOwner): ?>
                <!-- Chatbox - Direct chat on product page -->
                <div class="bg-secondary rounded-lg p-3 mb-3">
                  <h6 class="font-size-sm font-weight-medium mb-2">
                    <i class="czi-comment mr-1"></i><?= $isTc ? "即時對話" : "Live Chat" ?>
                  </h6>
                  <div id="productChatMessages" class="mb-2" style="max-height:150px;overflow-y:auto;font-size:0.8125rem;">
                    <div class="text-center text-muted py-3 font-size-xs"><?= $isTc ? "開始與賣家對話..." : "Start chatting with seller..." ?></div>
                  </div>
                  <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="productChatInput" placeholder="<?= Lang::$lang['typeMessage'] ?>" onkeypress="if(event.key==='Enter')sendProductChat()">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm" onclick="sendProductChat()"><i class="czi-send"></i></button>
                    </div>
                  </div>
                </div>

                <!-- Confirm Purchase Button -->
                <?php if (!$product['isSold']): ?>
                  <button class="btn btn-success btn-block btn-shadow mb-2" id="confirmPurchaseBtn" onclick="confirmPurchase(<?= $product['productId'] ?>, <?= $product['seller']['userId'] ?>)">
                    <i class="czi-bag mr-2"></i><?= Lang::$lang['confirmPurchase'] ?>
                  </button>
                <?php else: ?>
                  <button class="btn btn-secondary btn-block mb-2" disabled>
                    <i class="czi-check mr-2"></i><?= $isTc ? "已售出" : "Sold" ?>
                  </button>
                <?php endif; ?>

                <div class="d-flex flex-wrap">
                  <button class="btn btn-outline-accent btn-sm flex-grow-1 mr-2 mb-2" onclick="toggleFollow(<?= $product['seller']['userId'] ?>)">
                    <i class="czi-user mr-1"></i><span id="followBtnText"><?= $isTc ? "關注" : "Follow" ?></span>
                  </button>
                  <button class="btn btn-outline-danger btn-sm mr-2 mb-2" onclick="reportProduct(<?= $product['productId'] ?>)" title="<?= $isTc ? "舉報" : "Report" ?>">
                    <i class="czi-flag"></i>
                  </button>
                  <button class="btn btn-outline-secondary btn-sm mb-2" onclick="toggleBlock(<?= $product['seller']['userId'] ?>)" title="<?= $isTc ? "封鎖" : "Block" ?>">
                    <i class="czi-close-circle"></i>
                  </button>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="bg-secondary rounded-lg p-4 mb-4">
        <h3 class="h5 mb-3"><?= Lang::$lang['description'] ?></h3>
        <p class="font-size-sm text-muted mb-0" style="white-space:pre-wrap;line-height:1.8;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <?php if ($product['keyword']): ?>
          <hr class="border-light">
          <h6 class="font-weight-medium mb-2"><?= Lang::$lang['keywords'] ?></h6>
          <div>
            <?php foreach (explode(',', $product['keyword']) as $kw): ?>
              <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode(trim($kw)) ?>" class="badge badge-secondary badge-shadow mr-1 mb-1"><?= trim($kw) ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <?php if (!empty($similarProducts)): ?>
        <h3 class="h5 mb-3"><?= $isTc ? "類似商品" : "Similar Products" ?></h3>
        <div class="row mx-n2 mb-4">
          <?php foreach ($similarProducts as $sp):
            $product = $sp;
            $colClass = 'col-lg-3 col-md-4 col-6';
            require 'views/partials/product-card.php';
          endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="col-lg-4">
      <?php if (Session::get('userId')): ?>
        <div class="bg-secondary rounded-lg p-4 mb-4">
          <button class="btn btn-outline-accent btn-block" onclick="saveCurrentSearch()">
            <i class="czi-bookmark mr-2"></i><?= Lang::$lang['saveSearch'] ?>
          </button>
        </div>
      <?php endif; ?>

      <?php if (!empty($moreFromSeller)): ?>
        <div class="bg-secondary rounded-lg p-4">
          <h3 class="h6 mb-3"><?= $isTc ? "賣家其他商品" : "More from this seller" ?></h3>
          <div class="row mx-n2">
            <?php foreach ($moreFromSeller as $sp):
              $product = $sp;
              $colClass = 'col-6';
              require 'views/partials/product-card.php';
            endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
var sellerUserId = <?= isset($product['seller']) ? $product['seller']['userId'] : 0 ?>;
var currentUserId = <?= Session::get('userId') ? Session::get('userId') : 0 ?>;

function toggleFavorite(productId) {
  $.post('<?= Url::getDomain() ?>api/toggle-favorite/', {productId: productId}, function(data) {
    showToast(data.favorited ? '<?= Lang::$lang["favoriteAdded"] ?>' : '<?= Lang::$lang["favoriteRemoved"] ?>', data.favorited ? 'success' : 'info');
  });
}
function shareProduct() {
  if (navigator.clipboard) {
    navigator.clipboard.writeText(window.location.href).then(function() {
      showToast('<?= Lang::$lang["copyLink"] ?>', 'success');
    });
  }
}
function saveCurrentSearch() {
  $.post('<?= Url::getDomain() ?>api/save-search/', {
    keyword: '<?= htmlspecialchars($product['listingTitle']) ?>',
    fcId: <?= (int)$product['fcId'] ?>,
    scId: <?= (int)$product['scId'] ?>
  }, function(data) {
    showToast(data.success ? '<?= Lang::$lang["searchSaved"] ?>' : '<?= Lang::$lang["savedSearchLimit"] ?>', data.success ? 'success' : 'warning');
  });
}
function toggleFollow(userId) {
  $.post('<?= Url::getDomain() ?>api/toggle-follow/', {followingId: userId}, function(data) {
    if (data.success) {
      $('#followBtnText').text(data.following ? '<?= $isTc ? "已關注" : "Following" ?>' : '<?= $isTc ? "關注" : "Follow" ?>');
      showToast(data.following ? '<?= $isTc ? "已關注賣家" : "Following seller" ?>' : '<?= $isTc ? "已取消關注" : "Unfollowed" ?>', 'success');
    }
  });
}
function reportProduct(productId) {
  var reason = prompt('<?= $isTc ? "請輸入舉報原因：" : "Please enter the reason for reporting:" ?>');
  if (reason) {
    $.post('<?= Url::getDomain() ?>api/report-product/', {productId: productId, reason: reason}, function(data) {
      if (data.success) showToast(data.message, 'success');
    });
  }
}
function toggleBlock(userId) {
  if (confirm('<?= $isTc ? "確定要封鎖此用戶？" : "Block this user?" ?>')) {
    $.post('<?= Url::getDomain() ?>api/toggle-block/', {blockedUserId: userId}, function(data) {
      if (data.success) showToast(data.blocked ? '<?= $isTc ? "已封鎖" : "Blocked" ?>' : '<?= $isTc ? "已解除封鎖" : "Unblocked" ?>', 'success');
    });
  }
}

// Chatbox on product page
function sendProductChat() {
  var input = document.getElementById('productChatInput');
  var content = input.value.trim();
  if (!content || !sellerUserId) return;
  
  $.post('<?= Url::getDomain() ?>api/send-message/', {
    toUserId: sellerUserId,
    content: content
  }, function(data) {
    if (data.success) {
      addChatMessage(content, true);
      input.value = '';
    }
  });
}

function addChatMessage(content, isMine) {
  var container = document.getElementById('productChatMessages');
  // Remove empty state
  var emptyState = container.querySelector('.text-center.text-muted');
  if (emptyState) emptyState.remove();
  
  var now = new Date();
  var time = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
  
  var div = document.createElement('div');
  div.className = 'mb-2 d-flex' + (isMine ? ' justify-content-end' : '');
  div.innerHTML = '<div class="rounded-lg px-2 py-1 ' + (isMine ? 'bg-primary text-white' : 'bg-light') + '" style="max-width:85%;font-size:0.8125rem;">' + 
    escapeHtml(content) + 
    '<div class="font-size-xs opacity-75 text-right mt-1">' + time + '</div></div>';
  container.appendChild(div);
  container.scrollTop = container.scrollHeight;
}

function escapeHtml(text) {
  var div = document.createElement('div');
  div.appendChild(document.createTextNode(text));
  return div.innerHTML;
}

// Load recent chat messages
function loadProductChat() {
  if (!sellerUserId || !currentUserId) return;
  $.get('<?= Url::getDomain() ?>api/get-messages/', {otherUserId: sellerUserId}, function(data) {
    if (data && data.length > 0) {
      var container = document.getElementById('productChatMessages');
      container.innerHTML = '';
      data.forEach(function(msg) {
        addChatMessage(msg.content, msg.fromUserId == currentUserId);
      });
    }
  });
}

// Confirm Purchase
function confirmPurchase(productId, sellerId) {
  if (!confirm('<?= $isTc ? "確定要購買此商品？賣家確認後，雙方可以互相評分。" : "Confirm purchase? After seller confirms, both parties can rate each other." ?>')) return;
  
  $.post('<?= Url::getDomain() ?>api/create-purchase-intent/', {
    productId: productId,
    sellerId: sellerId
  }, function(data) {
    if (data.success) {
      showToast(data.message, 'success');
      $('#confirmPurchaseBtn').prop('disabled', true).text('<?= $isTc ? "已發送購買請求" : "Request Sent" ?>').removeClass('btn-success').addClass('btn-secondary');
    } else {
      showToast(data.message, 'warning');
    }
  });
}

// Check if user already has a pending intent
function checkPendingIntent() {
  <?php if (Session::get('userId') && !$isOwner && !$product['isSold']): ?>
  $.get('<?= Url::getDomain() ?>api/check-pending-intent/', {productId: <?= $product['productId'] ?>}, function(data) {
    if (data && data.status && data.status != 'none') {
      $('#confirmPurchaseBtn').prop('disabled', true).text('<?= $isTc ? "已發送購買請求" : "Request Sent" ?>').removeClass('btn-success').addClass('btn-secondary');
    }
  });
  <?php endif; ?>
}

$(document).ready(function() {
  <?php if (Session::get('userId') && isset($product['seller']) && !$isOwner): ?>
  $.get('<?= Url::getDomain() ?>api/is-following/', {followingId: <?= $product['seller']['userId'] ?>}, function(data) {
    if (data.following) $('#followBtnText').text('<?= $isTc ? "已關注" : "Following" ?>');
  });
  loadProductChat();
  // Poll for new messages every 10 seconds
  setInterval(loadProductChat, 10000);
  checkPendingIntent();
  <?php endif; ?>
});
</script>
