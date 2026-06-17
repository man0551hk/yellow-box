<?php
$colClass = $colClass ?? 'col-md-3 col-sm-6';
$showWishlist = $showWishlist ?? false;
$showDate = $showDate ?? true;
$showViews = $showViews ?? false;
$badge = $badge ?? '';
$productId = $product['productId'] ?? 0;

$img = !empty($product['image'])
  ? (strpos($product['image'], 'http') === 0 ? $product['image'] : Url::getDomain() . ltrim($product['image'], '/'))
  : Url::getDomain() . 'images/test.jpg';

$priceParts = explode('.', number_format((float)$product['price'], 2, '.', ''));
$priceMain = $priceParts[0];
$priceCents = $priceParts[1] ?? '00';

$categoryLink = !empty($product['category_seo']) ? Url::SetLink($product['category_seo']) : '#';
$categoryName = $product['category_name'] ?? '';
?>
<div class="<?= $colClass ?> px-2 mb-4">
  <div class="card product-card">
    <?php if ($badge): ?><span class="badge badge-danger badge-shadow"><?= $badge ?></span><?php endif; ?>
    <?php if ($showWishlist && $productId): ?>
      <button class="btn-wishlist btn-sm" type="button" onclick="toggleFavorite(<?= (int)$productId ?>)" data-toggle="tooltip" data-placement="left" title="<?= Lang::$lang['myFavorites'] ?>"><i class="czi-heart"></i></button>
    <?php endif; ?>
    <a class="card-img-top d-block overflow-hidden" href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/">
      <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['listingTitle']) ?>">
    </a>
    <div class="card-body py-2">
      <?php if ($categoryName): ?>
        <a class="product-meta d-block font-size-xs pb-1" href="<?= $categoryLink ?>"><?= htmlspecialchars($categoryName) ?></a>
      <?php endif; ?>
      <h3 class="product-title font-size-sm">
        <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 40)) ?></a>
      </h3>
      <div class="d-flex justify-content-between align-items-center">
        <div class="product-price"><span class="text-accent">$<?= $priceMain ?>.<small><?= $priceCents ?></small></span></div>
        <?php if ($showDate || $showViews): ?>
          <span class="font-size-xs text-muted">
            <?php if ($showDate && !empty($product['createdDate'])): ?>
              <i class="czi-time mr-1"></i><?= date('Y-m-d', strtotime($product['createdDate'])) ?>
            <?php endif; ?>
            <?php if ($showViews && isset($product['viewCount'])): ?>
              <i class="czi-eye ml-2 mr-1"></i><?= (int)$product['viewCount'] ?>
            <?php endif; ?>
          </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <hr class="d-sm-none">
</div>