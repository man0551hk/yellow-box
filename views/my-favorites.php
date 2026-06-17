<div class="container py-4">
  <h4 class="section-title"><?= Lang::$lang['myFavorites'] ?></h4>
  
  <?php if (!empty($favorites)): ?>
    <div class="row">
      <?php foreach ($favorites as $fav): ?>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
          <div class="card product-card h-100">
            <div class="position-relative">
              <button class="btn btn-sm btn-danger position-absolute" style="top:8px;right:8px;z-index:2;border-radius:50%;width:32px;height:32px;padding:0;opacity:0.9;" onclick="removeFavorite(<?= $fav['productId'] ?>)" title="<?= Session::get("lang") == "tc" ? "移除" : "Remove" ?>">
                <i class="fas fa-times"></i>
              </button>
              <a href="<?= Url::getDomain() ?>product/<?= $fav['refId'] ?>/">
                <img src="<?= $fav['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($fav['listingTitle']) ?>">
              </a>
            </div>
            <div class="card-body p-3">
              <p class="card-text small text-muted mb-1">
                <span class="category-badge"><?= $fav['category_name'] ?? Lang::$lang['categories'] ?></span>
              </p>
              <h6 class="card-title mb-1">
                <a href="<?= Url::getDomain() ?>product/<?= $fav['refId'] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($fav['listingTitle'], 0, 30)) ?></a>
              </h6>
              <p class="product-price mb-0">$<?= number_format($fav['price']) ?></p>
              <small class="text-muted"><i class="far fa-clock mr-1"></i><?= date('Y-m-d', strtotime($fav['createdDate'])) ?></small>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <i class="fas fa-heart"></i>
      <h5><?= Lang::$lang['noProducts'] ?></h5>
      <p><?= Session::get("lang") == "tc" ? "去瀏覽商品，點擊心形圖案加入收藏" : "Browse products and click the heart icon to add favorites" ?></p>
    </div>
  <?php endif; ?>
</div>

<script>
function removeFavorite(productId) {
  $.post('<?= Url::getDomain() ?>api/toggle-favorite/', {productId: productId}, function(data) {
    showToast('<?= Lang::$lang["favoriteRemoved"] ?>', 'info');
    location.reload();
  });
}
</script>
