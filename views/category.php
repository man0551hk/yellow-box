<?php $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i><?= Lang::$lang['home'] ?></a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= htmlspecialchars($category['name']) ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= htmlspecialchars($category['name']) ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <aside class="col-lg-3">
      <div class="cz-sidebar rounded-lg box-shadow-lg" id="shop-sidebar">
        <div class="cz-sidebar-header box-shadow-sm">
          <button class="close ml-auto" type="button" data-dismiss="sidebar" aria-label="Close">
            <span class="d-inline-block font-size-xs font-weight-normal align-middle"><?= $isTc ? "關閉" : "Close" ?></span>
            <span class="d-inline-block align-middle ml-2" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="cz-sidebar-body" data-simplebar data-simplebar-auto-hide="true">
          <div class="widget widget-categories mb-4 pb-4">
            <h3 class="widget-title"><?= Lang::$lang['filters'] ?></h3>
            <form method="GET" action="<?= Url::getDomain() ?>search/">
              <input type="hidden" name="fcId" value="<?= (int)$fcId ?>">
              <?php if ($scId): ?><input type="hidden" name="scId" value="<?= (int)$scId ?>"><?php endif; ?>

              <div class="form-group">
                <label class="font-size-sm font-weight-medium"><?= Lang::$lang['condition'] ?></label>
                <select class="form-control custom-select custom-select-sm" name="condition" onchange="this.form.submit()">
                  <option value="0"><?= Lang::$lang['allConditions'] ?></option>
                  <option value="1"><?= Lang::$lang['brandnew'] ?></option>
                  <option value="2"><?= Lang::$lang['secondhand'] ?></option>
                </select>
              </div>

              <div class="form-group">
                <label class="font-size-sm font-weight-medium"><?= Lang::$lang['sortBy'] ?></label>
                <select class="form-control custom-select custom-select-sm" name="sortBy" onchange="this.form.submit()">
                  <option value=""><?= Lang::$lang['defaultSorting'] ?></option>
                  <option value="lowToHigh"><?= Lang::$lang['low2high'] ?></option>
                  <option value="hightToLow"><?= Lang::$lang['high2low'] ?></option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-sm btn-block btn-shadow"><?= Lang::$lang['filter'] ?></button>
            </form>
          </div>
        </div>
      </div>
    </aside>

    <section class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 mb-3">
        <h6 class="font-size-base text-muted mb-0"><?= count($products) ?> <?= $isTc ? "件商品" : "products" ?></h6>
        <a class="btn btn-outline-accent btn-sm d-lg-none" href="#shop-sidebar" data-toggle="sidebar">
          <i class="czi-filter-alt mr-1"></i><?= Lang::$lang['filters'] ?>
        </a>
      </div>

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
    </section>
  </div>
</div>