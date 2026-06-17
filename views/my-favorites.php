<div class="container py-4">
  <h4 class="section-title"><?= Lang::$lang['myFavorites'] ?></h4>
  
  <?php if (!empty($favorites)): ?>
    <div class="row">
      <?php foreach ($favorites as $fav): ?>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
          <div class="card product-card h-100">
            <a href="<?= Url::getDomain() ?>product/<?= $fav['refId'] ?>/">
              <img src="<?= $fav['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($fav['listingTitle']) ?>">
            </a>
            <div class="card-body p-3">
              <h6 class="card-title mb-1">
                <a href="<?= Url::getDomain() ?>product/<?= $fav['refId'] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($fav['listingTitle'], 0, 30)) ?></a>
              </h6>
              <p class="product-price mb-0">$<?= number_format($fav['price']) ?></p>
              <small class="text-muted"><?= date('Y-m-d', strtotime($fav['createdDate'])) ?></small>
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
