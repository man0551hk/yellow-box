<div class="container-fluid p-0">
  <!-- Hero Banner -->
  <div class="hero-banner position-relative">
    <div class="container py-5 text-center position-relative" style="z-index:1;">
      <h1 class="display-4 font-weight-bold mb-3" style="color:#332c24;"><?= Session::get("lang") == "tc" ? "買賣·咁簡單" : "Buy & Sell. Made Simple." ?></h1>
      <p class="lead mb-4" style="color:#5a4a3a;"><?= Session::get("lang") == "tc" ? "香港人嘅網上買賣平台" : "Hong Kong's Online Marketplace" ?></p>
      <form class="form-inline justify-content-center" action="<?= Url::getDomain() ?>search/" method="GET">
        <div class="input-group" style="max-width:500px;width:100%;">
          <input class="form-control form-control-lg search-bar" type="search" name="keyword" placeholder="<?= Lang::$lang["search"] ?>..." required>
          <div class="input-group-append">
            <button class="btn btn-dark btn-lg btn-shadow" type="submit"><i class="fas fa-search mr-2"></i><?= Lang::$lang["search"] ?></button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Categories -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="section-title mb-0"><?= Lang::$lang["categories"] ?></h5>
      <a href="<?= Url::getDomain() ?>" class="text-muted small font-weight-medium"><?= Lang::$lang["viewAll"] ?> <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="row">
      <?php
      $homeCategorys = $this->categoryController->GetCategory();
      foreach ($homeCategorys as $cat):
      ?>
        <div class="col-4 col-md-2 mb-3">
          <a href="<?= Url::SetLink($cat["seo"]) ?>" class="text-decoration-none">
            <div class="card text-center py-3 h-100 border-0 shadow-sm category-card">
              <div class="card-body">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:50px;height:50px;background:#FFF8DC;">
                  <i class="fas fa-tag" style="color:#DAA520;font-size:1.3rem;"></i>
                </div>
                <p class="card-text small font-weight-bold mb-0 text-dark"><?= $cat["category"] ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Trending Products -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="section-title mb-0"><?= Session::get("lang") == "tc" ? "🔥 熱門商品" : "🔥 Trending Products" ?></h5>
      <a href="<?= Url::getDomain() ?>search/?sortBy=popular" class="text-muted small font-weight-medium"><?= Lang::$lang["viewAll"] ?> <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="row">
      <?php
      $trendingProducts = $this->productController->getTrendingProducts(8);
      if (!empty($trendingProducts)):
        foreach ($trendingProducts as $product):
      ?>
        <div class="col-lg-3 col-md-4 col-6 mb-3">
          <div class="card product-card h-100">
            <div class="position-relative">
              <span class="trending-badge badge badge-yellow"><i class="fas fa-fire mr-1"></i>Trending</span>
              <a href="<?= Url::getDomain() ?>product/<?= $product["refId"] ?>/">
                <img src="<?= $product["image"] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($product["listingTitle"]) ?>">
              </a>
            </div>
            <div class="card-body p-3">
              <p class="card-text small text-muted mb-1">
                <a href="<?= Url::SetLink($product["category_seo"]) ?>" class="category-badge"><?= $product["category_name"] ?></a>
              </p>
              <h6 class="card-title mb-1">
                <a href="<?= Url::getDomain() ?>product/<?= $product["refId"] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($product["listingTitle"], 0, 30)) ?></a>
              </h6>
              <p class="product-price mb-0">$<?= number_format($product["price"]) ?></p>
              <div class="d-flex justify-content-between align-items-center mt-1">
                <small class="text-muted"><i class="far fa-clock mr-1"></i><?= date('Y-m-d', strtotime($product["createdDate"])) ?></small>
                <small class="text-muted"><i class="fas fa-eye mr-1"></i><?= $product["viewCount"] ?></small>
              </div>
            </div>
          </div>
        </div>
      <?php 
        endforeach;
      endif;
      ?>
    </div>
  </div>

  <!-- Latest Products -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="section-title mb-0"><?= Lang::$lang["latest"] ?></h5>
      <a href="<?= Url::getDomain() ?>search/" class="text-muted small font-weight-medium"><?= Lang::$lang["viewAll"] ?> <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="row">
      <?php
      $latestProducts = $this->productController->getLatestProducts(12);
      if (!empty($latestProducts)):
        foreach ($latestProducts as $product):
      ?>
        <div class="col-lg-2 col-md-4 col-6 mb-3">
          <div class="card product-card h-100">
            <a href="<?= Url::getDomain() ?>product/<?= $product["refId"] ?>/">
              <img src="<?= $product["image"] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($product["listingTitle"]) ?>">
            </a>
            <div class="card-body p-3">
              <p class="card-text small text-muted mb-1">
                <a href="<?= Url::SetLink($product["category_seo"]) ?>" class="category-badge"><?= $product["category_name"] ?></a>
              </p>
              <h6 class="card-title mb-1">
                <a href="<?= Url::getDomain() ?>product/<?= $product["refId"] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($product["listingTitle"], 0, 30)) ?></a>
              </h6>
              <p class="product-price mb-0">$<?= number_format($product["price"]) ?></p>
              <small class="text-muted"><i class="far fa-clock mr-1"></i><?= date('Y-m-d', strtotime($product["createdDate"])) ?></small>
            </div>
          </div>
        </div>
      <?php 
        endforeach;
      else:
      ?>
        <?php for ($i = 0; $i < 12; $i++): ?>
          <div class="col-lg-2 col-md-4 col-6 mb-3">
            <div class="card product-card h-100">
              <img src="<?= Url::getDomain() ?>images/test.jpg" class="card-img-top" alt="Sample">
              <div class="card-body p-3">
                <p class="card-text small text-muted mb-1"><span class="category-badge"><?= Lang::$lang["categories"] ?></span></p>
                <h6 class="card-title mb-1 text-dark"><?= Session::get("lang") == "tc" ?"示例商品 - 點擊查看詳情" : "Sample Item - Click for details" ?></h6>
                <p class="product-price mb-0">$99</p>
                <small class="text-muted"><?= date('Y-m-d') ?></small>
              </div>
            </div>
          </div>
        <?php endfor; ?>
      <?php endif; ?>
    </div>
  </div>

  <!-- Recently Viewed (for logged in users) -->
  <?php if ($isLoggedIn): ?>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="section-title mb-0"><?= Session::get("lang") == "tc" ? "👁️ 最近瀏覽" : "👁️ Recently Viewed" ?></h5>
      <a href="<?= Url::getDomain() ?>search-history/" class="text-muted small font-weight-medium"><?= Session::get("lang") == "tc" ? "查看全部" : "View all" ?> <i class="fas fa-arrow-right ml-1"></i></a>
    </div>
    <div class="row" id="recentlyViewedContainer">
      <div class="col-12 text-center py-4">
        <div class="spinner-border text-warning" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- How It Works -->
  <div class="bg-white py-5">
    <div class="container">
      <h5 class="section-title text-center"><?= Session::get("lang") == "tc" ? "點樣運作" : "How It Works" ?></h5>
      <div class="row text-center">
        <div class="col-md-4 mb-4">
          <div class="p-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;background:#FFF8DC;">
              <i class="fas fa-camera" style="color:#DAA520;font-size:2rem;"></i>
            </div>
            <h5><?= Session::get("lang") == "tc" ? "影相刊登" : "Snap & List" ?></h5>
            <p class="text-muted"><?= Session::get("lang") == "tc" ? "用手機影低你想賣嘅物品，幾步就刊登完成" : "Take a photo of your item and list it in minutes" ?></p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="p-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;background:#FFF8DC;">
              <i class="fas fa-comments" style="color:#DAA520;font-size:2rem;"></i>
            </div>
            <h5><?= Session::get("lang") == "tc" ? "傾價錢" : "Chat & Negotiate" ?></h5>
            <p class="text-muted"><?= Session::get("lang") == "tc" ? "買賣雙方直接溝通，傾好價錢就成交" : "Buyers and sellers chat directly to agree on a price" ?></p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="p-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;background:#FFF8DC;">
              <i class="fas fa-handshake" style="color:#DAA520;font-size:2rem;"></i>
            </div>
            <h5><?= Session::get("lang") == "tc" ? "當面交收" : "Meet & Exchange" ?></h5>
            <p class="text-muted"><?= Session::get("lang") == "tc" ? "約好時間地點當面交收，安全又放心" : "Arrange a meetup for a safe and secure transaction" ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Load recently viewed products
$(document).ready(function() {
  <?php if ($isLoggedIn): ?>
  $.get('<?= Url::getDomain() ?>api/get-recently-viewed/', function(data) {
    var container = $('#recentlyViewedContainer');
    container.empty();
    if (data.products && data.products.length > 0) {
      $.each(data.products, function(i, product) {
        var col = $('<div class="col-lg-2 col-md-4 col-6 mb-3"></div>');
        var card = $('<div class="card product-card h-100"></div>');
        var link = $('<a href="<?= Url::getDomain() ?>product/' + product.refId + '/"></a>');
        var img = $('<img src="' + (product.image || '<?= Url::getDomain() ?>images/test.jpg') + '" class="card-img-top" alt="' + product.listingTitle + '">');
        link.append(img);
        var body = $('<div class="card-body p-3"></div>');
        body.append('<p class="card-text small text-muted mb-1"><span class="category-badge">' + (product.category_name || '') + '</span></p>');
        body.append('<h6 class="card-title mb-1"><a href="<?= Url::getDomain() ?>product/' + product.refId + '/" class="text-dark">' + product.listingTitle.substring(0, 30) + '</a></h6>');
        body.append('<p class="product-price mb-0">$' + Number(product.price).toLocaleString() + '</p>');
        body.append('<small class="text-muted"><i class="far fa-clock mr-1"></i>' + product.createdDate.substring(0, 10) + '</small>');
        card.append(link);
        card.append(body);
        col.append(card);
        container.append(col);
      });
    } else {
      container.html('<div class="col-12 text-center py-4"><i class="fas fa-history fa-3x text-muted mb-3"></i><p class="text-muted"><?= Session::get("lang") == "tc" ? "暫無瀏覽記錄" : "No recently viewed items" ?></p></div>');
    }
  });
  <?php endif; ?>
});
</script>
