<?php $activePage = 'my-favorites'; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['myFavorites'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['myFavorites'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <div class="pt-lg-3 pb-4 mb-3">
        <h6 class="font-size-base text-light mb-0"><?= count($favorites) ?> <?= Session::get("lang") == "tc" ? "件收藏" : "favorites" ?></h6>
      </div>

      <?php if (!empty($favorites)): ?>
        <div class="row mx-n2">
          <?php foreach ($favorites as $fav):
            $product = $fav;
            $colClass = 'col-lg-3 col-md-4 col-6';
            $showWishlist = true;
            require 'views/partials/product-card.php';
          endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-heart" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= Lang::$lang['noProducts'] ?></h5>
          <p class="text-muted"><?= Session::get("lang") == "tc" ? "去瀏覽商品，點擊心形圖案加入收藏" : "Browse products and click the heart icon to add favorites" ?></p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<script>
function toggleFavorite(productId) {
  $.post('<?= Url::getDomain() ?>api/toggle-favorite/', {productId: productId}, function() {
    showToast('<?= Lang::$lang["favoriteRemoved"] ?>', 'info');
    location.reload();
  });
}
</script>