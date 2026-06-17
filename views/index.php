<?php $isTc = Session::get("lang") == "tc"; ?>

<!-- Hero -->
<div class="page-title-overlap bg-img pt-4">
  <div class="container py-5 text-center">
    <h1 class="display-4 text-light font-weight-bold mb-3"><?= $isTc ? "買賣·咁簡單" : "Buy & Sell. Made Simple." ?></h1>
    <p class="lead text-light opacity-75 mb-4"><?= $isTc ? "香港人嘅網上買賣平台" : "Hong Kong's Online Marketplace" ?></p>
    <form class="mx-auto" action="<?= Url::getDomain() ?>search/" method="GET" style="max-width:32rem;">
      <div class="input-group-overlay">
        <input class="form-control form-control-lg appended-form-control" type="search" name="keyword" placeholder="<?= Lang::$lang["search"] ?>..." required>
        <div class="input-group-append-overlay"><span class="input-group-text"><i class="czi-search"></i></span></div>
      </div>
    </form>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <!-- Categories -->
  <div class="pt-4 pb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 pb-4">
      <h2 class="h3 mb-0"><?= Lang::$lang["categories"] ?></h2>
      <a class="font-size-sm text-accent" href="<?= Url::getDomain() ?>search/"><?= Lang::$lang["viewAll"] ?><i class="czi-arrow-right font-size-xs align-middle ml-1"></i></a>
    </div>
    <div class="row">
      <?php
      $homeCategorys = $this->categoryController->GetCategory();
      $htmlBase = Url::getDomain() . 'html/';
      foreach ($homeCategorys as $i => $cat):
        $imgNum = str_pad(($i % 6) + 1, 2, '0', STR_PAD_LEFT);
      ?>
        <div class="col-6 col-md-4 col-lg-2 mb-4">
          <a class="d-block text-center text-decoration-none" href="<?= Url::SetLink($cat["seo"]) ?>">
            <div class="card border-0 box-shadow-sm h-100">
              <div class="card-body p-3">
                <div class="d-block overflow-hidden rounded-lg mb-2">
                  <img src="<?= $htmlBase ?>img/shop/category/<?= $imgNum ?>.jpg" alt="<?= htmlspecialchars($cat["category"]) ?>">
                </div>
                <p class="font-size-sm font-weight-medium text-dark mb-0"><?= htmlspecialchars($cat["category"]) ?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Trending -->
  <div class="pt-2 pb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 pb-4">
      <h2 class="h3 mb-0"><i class="czi-flame text-accent mr-1"></i><?= $isTc ? "熱門商品" : "Trending Products" ?></h2>
      <a class="font-size-sm text-accent" href="<?= Url::getDomain() ?>search/?sortBy=popular"><?= Lang::$lang["viewAll"] ?><i class="czi-arrow-right font-size-xs align-middle ml-1"></i></a>
    </div>
    <div class="row mx-n2">
      <?php
      $trendingProducts = $this->productController->getTrendingProducts(8);
      if (!empty($trendingProducts)):
        foreach ($trendingProducts as $product):
          $badge = $isTc ? "熱門" : "Trending";
          $colClass = 'col-lg-3 col-md-4 col-6';
          $showViews = true;
          require 'views/partials/product-card.php';
        endforeach;
      endif;
      ?>
    </div>
  </div>

  <!-- Latest -->
  <div class="pt-2 pb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 pb-4">
      <h2 class="h3 mb-0"><?= Lang::$lang["latest"] ?></h2>
      <a class="font-size-sm text-accent" href="<?= Url::getDomain() ?>search/"><?= Lang::$lang["viewAll"] ?><i class="czi-arrow-right font-size-xs align-middle ml-1"></i></a>
    </div>
    <div class="row mx-n2">
      <?php
      $latestProducts = $this->productController->getLatestProducts(12);
      if (!empty($latestProducts)):
        foreach ($latestProducts as $product):
          $colClass = 'col-lg-2 col-md-4 col-6';
          $showViews = false;
          require 'views/partials/product-card.php';
        endforeach;
      else:
        for ($i = 0; $i < 12; $i++):
          $product = [
            'refId' => 0,
            'image' => '',
            'listingTitle' => $isTc ? "示例商品" : "Sample Item",
            'price' => 99,
            'category_name' => Lang::$lang["categories"],
          ];
          $colClass = 'col-lg-2 col-md-4 col-6';
          $showViews = false;
          require 'views/partials/product-card.php';
        endfor;
      endif;
      ?>
    </div>
  </div>

  <?php if ($isLoggedIn): ?>
  <div class="pt-2 pb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 pb-4">
      <h2 class="h3 mb-0"><i class="czi-eye text-accent mr-1"></i><?= $isTc ? "最近瀏覽" : "Recently Viewed" ?></h2>
      <a class="font-size-sm text-accent" href="<?= Url::getDomain() ?>search-history/"><?= $isTc ? "查看全部" : "View all" ?><i class="czi-arrow-right font-size-xs align-middle ml-1"></i></a>
    </div>
    <div class="row mx-n2" id="recentlyViewedContainer">
      <div class="col-12 text-center py-4">
        <div class="spinner-border text-accent" role="status"><span class="sr-only">Loading...</span></div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- How It Works -->
  <div class="bg-secondary rounded-lg p-4 p-md-5 mt-4">
    <h2 class="h3 text-center mb-4"><?= $isTc ? "點樣運作" : "How It Works" ?></h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="media d-block d-md-flex flex-md-column align-items-center">
          <i class="czi-camera text-primary mb-3" style="font-size:2.5rem;"></i>
          <div class="media-body">
            <h5 class="text-dark"><?= $isTc ? "影相刊登" : "Snap & List" ?></h5>
            <p class="font-size-sm text-muted mb-0"><?= $isTc ? "用手機影低你想賣嘅物品，幾步就刊登完成" : "Take a photo and list in minutes" ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="media d-block d-md-flex flex-md-column align-items-center">
          <i class="czi-comment text-primary mb-3" style="font-size:2.5rem;"></i>
          <div class="media-body">
            <h5 class="text-dark"><?= $isTc ? "傾價錢" : "Chat & Negotiate" ?></h5>
            <p class="font-size-sm text-muted mb-0"><?= $isTc ? "買賣雙方直接溝通，傾好價錢就成交" : "Chat directly to agree on a price" ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="media d-block d-md-flex flex-md-column align-items-center">
          <i class="czi-delivery text-primary mb-3" style="font-size:2.5rem;"></i>
          <div class="media-body">
            <h5 class="text-dark"><?= $isTc ? "當面交收" : "Meet & Exchange" ?></h5>
            <p class="font-size-sm text-muted mb-0"><?= $isTc ? "約好時間地點當面交收，安全又放心" : "Arrange a safe meetup" ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  <?php if ($isLoggedIn): ?>
  $.get('<?= Url::getDomain() ?>api/get-recently-viewed/', function(data) {
    var container = $('#recentlyViewedContainer');
    container.empty();
    if (data.products && data.products.length > 0) {
      $.each(data.products, function(i, product) {
        var price = Number(product.price).toLocaleString();
        var img = product.image || '<?= Url::getDomain() ?>images/test.jpg';
        var html = '<div class="col-lg-2 col-md-4 col-6 px-2 mb-4">' +
          '<div class="card product-card">' +
          '<a class="card-img-top d-block overflow-hidden" href="<?= Url::getDomain() ?>product/' + product.refId + '/"><img src="' + img + '" alt=""></a>' +
          '<div class="card-body py-2">' +
          '<h3 class="product-title font-size-sm"><a href="<?= Url::getDomain() ?>product/' + product.refId + '/">' + product.listingTitle.substring(0, 30) + '</a></h3>' +
          '<div class="product-price"><span class="text-accent">$' + price + '</span></div>' +
          '</div></div><hr class="d-sm-none"></div>';
        container.append(html);
      });
    } else {
      container.html('<div class="col-12 text-center py-4"><i class="czi-time" style="font-size:3rem;color:#ccc;"></i><p class="text-muted mt-3"><?= $isTc ? "暫無瀏覽記錄" : "No recently viewed items" ?></p></div>');
    }
  });
  <?php endif; ?>
});
</script>