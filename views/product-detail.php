<div class="container py-4">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= Url::getDomain() ?>" class="text-muted"><i class="fas fa-home mr-1"></i>Home</a></li>
      <li class="breadcrumb-item"><a href="<?= Url::SetLink($product['category_seo']) ?>" class="text-muted"><?= $product['category_name'] ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 30)) ?>...</li>
    </ol>
  </nav>

  <div class="row">
    <!-- Product Images -->
    <div class="col-lg-7 mb-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
          <div class="position-relative">
            <?php if ($product['isSold']): ?>
              <span class="badge badge-danger position-absolute" style="top:10px;left:10px;z-index:2;font-size:1rem;padding:8px 16px;"><?= Session::get("lang") == "tc" ? "已售出" : "Sold" ?></span>
            <?php endif; ?>
            <img id="mainImage" src="<?= !empty($product['images']) ? $product['images'][0] : Url::getDomain() . 'images/test.jpg' ?>" class="product-detail-image mb-3" alt="<?= htmlspecialchars($product['listingTitle']) ?>">
          </div>
          <?php if (!empty($product['images']) && count($product['images']) > 1): ?>
            <div class="thumbnail-list text-center">
              <?php foreach ($product['images'] as $i => $img): ?>
                <img src="<?= $img ?>" class="<?= $i == 0 ? 'active' : '' ?>" onclick="document.getElementById('mainImage').src=this.src;document.querySelectorAll('.thumbnail-list img').forEach(function(e){e.classList.remove('active')});this.classList.add('active');">
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Product Info -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
              <a href="<?= Url::SetLink($product['category_seo']) ?>" class="category-badge"><?= $product['category_name'] ?></a>
            </div>
            <div>
              <?php if (Session::get('userId')): ?>
                <button class="btn btn-sm btn-outline-danger rounded-circle" style="width:36px;height:36px;" onclick="toggleFavorite(<?= $product['productId'] ?>)">
                  <i class="far fa-heart"></i>
                </button>
              <?php endif; ?>
              <button class="btn btn-sm btn-outline-secondary rounded-circle" style="width:36px;height:36px;" onclick="shareProduct()">
                <i class="fas fa-share-alt"></i>
              </button>
            </div>
          </div>
          
          <h4 class="font-weight-bold mb-2" style="color:#332c24;"><?= htmlspecialchars($product['listingTitle']) ?></h4>
          <h3 class="product-price mb-3">$<?= number_format($product['price']) ?></h3>
          
          <div class="mb-3">
            <span class="badge badge-<?= $product['condition'] == 1 ? 'success' : 'info' ?> mr-2">
              <?= $product['condition'] == 1 ? Lang::$lang['brandnew'] : Lang::$lang['secondhand'] ?>
            </span>
            <?php if ($product['brand']): ?>
              <span class="badge badge-secondary"><?= htmlspecialchars($product['brand']) ?></span>
            <?php endif; ?>
          </div>
          
          <div class="seller-stats mb-3">
            <span class="mr-3"><i class="far fa-clock mr-1"></i><?= Lang::$lang['postedOn'] ?> <?= date('Y-m-d', strtotime($product['createdDate'])) ?></span>
            <span><i class="fas fa-eye mr-1"></i><?= $product['viewCount'] ?> <?= Session::get("lang") == "tc" ? "次瀏覽" : "views" ?></span>
          </div>
          
          <hr>
          
          <!-- Seller Info -->
          <?php if ($product['seller']): ?>
            <div class="seller-info-card mb-3">
              <div class="d-flex align-items-center">
                <div class="mr-3">
                  <?php if ($product['seller']['profilePic']): ?>
                    <img src="<?= $product['seller']['profilePic'] ?>" class="avatar avatar-lg">
                  <?php else: ?>
                    <div class="avatar avatar-lg d-flex align-items-center justify-content-center text-white font-weight-bold" style="font-size:1.5rem;background:linear-gradient(135deg,#FFD700,#FFA500);">
                      <?= strtoupper(substr($product['seller']['firstName'], 0, 1)) ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1">
                  <a href="<?= Url::getDomain() ?>profile/<?= $product['seller']['seo'] ?>/" class="font-weight-bold" style="color:#332c24;">
                    <?= htmlspecialchars($product['seller']['firstName'] . ' ' . $product['seller']['lastName']) ?>
                  </a>
                  <div class="small text-muted mt-1">
                    <?php if ($product['seller']['responseRate'] > 0): ?>
                      <span class="mr-3"><i class="fas fa-reply mr-1" style="color:#42d697;"></i><?= $product['seller']['responseRate'] ?>% <?= Session::get("lang") == "tc" ? "回覆率" : "response rate" ?></span>
                    <?php endif; ?>
                    <?php if ($product['seller']['responseTime']): ?>
                      <span><i class="fas fa-clock mr-1" style="color:#69b3fe;"></i><?= $product['seller']['responseTime'] ?></span>
                    <?php endif; ?>
                    <?php if ($product['seller']['lastActive']): ?>
                      <span class="ml-2"><i class="fas fa-circle mr-1" style="color:#42d697;font-size:8px;vertical-align:middle;"></i><?= $product['seller']['lastActive'] ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            
            <?php if (Session::get('userId')): ?>
              <?php if (Session::get('userId') != $product['seller']['userId']): ?>
                <a href="<?= Url::getDomain() ?>inbox/<?= $product['seller']['userId'] ?>/" class="btn btn-yellow btn-block mb-2 btn-shadow">
                  <i class="fas fa-comment mr-2"></i><?= Lang::$lang['chatWithSeller'] ?>
                </a>
                <div class="d-flex">
                  <button class="btn btn-sm btn-outline-primary mr-2 flex-grow-1" onclick="toggleFollow(<?= $product['seller']['userId'] ?>)">
                    <i class="fas fa-user-plus mr-1"></i><span id="followBtnText"><?= Session::get("lang") == "tc" ? "關注" : "Follow" ?></span>
                  </button>
                  <button class="btn btn-sm btn-outline-danger mr-2" onclick="reportProduct(<?= $product['productId'] ?>)" title="<?= Session::get("lang") == "tc" ? "舉報" : "Report" ?>">
                    <i class="fas fa-flag"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-secondary" onclick="toggleBlock(<?= $product['seller']['userId'] ?>)" title="<?= Session::get("lang") == "tc" ? "封鎖" : "Block" ?>">
                    <i class="fas fa-ban"></i>
                  </button>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Description & Similar Products -->
  <div class="row">
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <h5 class="font-weight-bold mb-3" style="color:#332c24;"><?= Lang::$lang['description'] ?></h5>
          <p class="text-muted" style="white-space: pre-wrap;line-height:1.8;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
          
          <?php if ($product['keyword']): ?>
            <hr>
            <h6 class="font-weight-bold mb-2" style="color:#332c24;"><?= Lang::$lang['keywords'] ?></h6>
            <div>
              <?php foreach (explode(',', $product['keyword']) as $kw): ?>
                <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode(trim($kw)) ?>" class="saved-search-tag text-decoration-none"><?= trim($kw) ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
      
      <!-- Similar Products -->
      <?php if (!empty($similarProducts)): ?>
      <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-4">
          <h5 class="font-weight-bold mb-3" style="color:#332c24;"><?= Session::get("lang") == "tc" ? "類似商品" : "Similar Products" ?></h5>
          <div class="row">
            <?php foreach ($similarProducts as $sp): ?>
              <div class="col-lg-3 col-md-4 col-6 mb-3">
                <div class="card similar-product-card h-100">
                  <a href="<?= Url::getDomain() ?>product/<?= $sp['refId'] ?>/">
                    <img src="<?= $sp['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($sp['listingTitle']) ?>" style="height:140px;object-fit:cover;">
                  </a>
                  <div class="card-body p-2">
                    <h6 class="card-title mb-1 small">
                      <a href="<?= Url::getDomain() ?>product/<?= $sp['refId'] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($sp['listingTitle'], 0, 20)) ?></a>
                    </h6>
                    <p class="product-price mb-0" style="font-size:1rem;">$<?= number_format($sp['price']) ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
    
    <div class="col-lg-5">
      <!-- Save Search -->
      <?php if (Session::get('userId')): ?>
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-body p-4">
            <button class="btn btn-outline-warning btn-block" onclick="saveCurrentSearch()">
              <i class="fas fa-bookmark mr-2"></i><?= Lang::$lang['saveSearch'] ?>
            </button>
          </div>
        </div>
      <?php endif; ?>
      
      <!-- More from this seller -->
      <?php if (!empty($moreFromSeller)): ?>
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <h5 class="font-weight-bold mb-3" style="color:#332c24;"><?= Session::get("lang") == "tc" ? "賣家其他商品" : "More from this seller" ?></h5>
          <div class="row">
            <?php foreach ($moreFromSeller as $sp): ?>
              <div class="col-6 mb-3">
                <div class="card similar-product-card h-100">
                  <a href="<?= Url::getDomain() ?>product/<?= $sp['refId'] ?>/">
                    <img src="<?= $sp['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($sp['listingTitle']) ?>" style="height:120px;object-fit:cover;">
                  </a>
                  <div class="card-body p-2">
                    <h6 class="card-title mb-1 small">
                      <a href="<?= Url::getDomain() ?>product/<?= $sp['refId'] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($sp['listingTitle'], 0, 20)) ?></a>
                    </h6>
                    <p class="product-price mb-0" style="font-size:1rem;">$<?= number_format($sp['price']) ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function toggleFavorite(productId) {
  $.post('<?= Url::getDomain() ?>api/toggle-favorite/', {productId: productId}, function(data) {
    if (data.favorited) {
      showToast('<?= Lang::$lang["favoriteAdded"] ?>', 'success');
    } else {
      showToast('<?= Lang::$lang["favoriteRemoved"] ?>', 'info');
    }
  });
}

function shareProduct() {
  var url = window.location.href;
  if (navigator.clipboard) {
    navigator.clipboard.writeText(url).then(function() {
      showToast('<?= Lang::$lang["copyLink"] ?>', 'success');
    });
  }
}

function saveCurrentSearch() {
  $.post('<?= Url::getDomain() ?>api/save-search/', {
    keyword: '<?= htmlspecialchars($product['listingTitle']) ?>',
    fcId: <?= $product['fcId'] ?>,
    scId: <?= $product['scId'] ?>
  }, function(data) {
    if (data.success) {
      showToast('<?= Lang::$lang["searchSaved"] ?>', 'success');
    } else {
      showToast('<?= Lang::$lang["savedSearchLimit"] ?>', 'warning');
    }
  });
}

function toggleFollow(userId) {
  $.post('<?= Url::getDomain() ?>api/toggle-follow/', {followingId: userId}, function(data) {
    if (data.success) {
      if (data.following) {
        $('#followBtnText').text('<?= Session::get("lang") == "tc" ? "已關注" : "Following" ?>');
        showToast('<?= Session::get("lang") == "tc" ? "已關注賣家" : "Following seller" ?>', 'success');
      } else {
        $('#followBtnText').text('<?= Session::get("lang") == "tc" ? "關注" : "Follow" ?>');
        showToast('<?= Session::get("lang") == "tc" ? "已取消關注" : "Unfollowed" ?>', 'info');
      }
    }
  });
}

function reportProduct(productId) {
  var reason = prompt('<?= Session::get("lang") == "tc" ? "請輸入舉報原因：" : "Please enter the reason for reporting:" ?>');
  if (reason) {
    $.post('<?= Url::getDomain() ?>api/report-product/', {productId: productId, reason: reason}, function(data) {
      if (data.success) {
        showToast(data.message, 'success');
      }
    });
  }
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

// Check if already following
$(document).ready(function() {
  <?php if (Session::get('userId') && isset($product['seller']) && Session::get('userId') != $product['seller']['userId']): ?>
  $.get('<?= Url::getDomain() ?>api/is-following/', {followingId: <?= $product['seller']['userId'] ?>}, function(data) {
    if (data.following) {
      $('#followBtnText').text('<?= Session::get("lang") == "tc" ? "已關注" : "Following" ?>');
    }
  });
  <?php endif; ?>
});
</script>
