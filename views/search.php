<?php $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i><?= Lang::$lang['home'] ?></a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['search'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['searchResults'] ?></h1>
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
          <div class="widget widget-categories mb-4 pb-4 border-bottom">
            <h3 class="widget-title"><?= Lang::$lang['filters'] ?></h3>
            <form method="GET" action="<?= Url::getDomain() ?>search/">
              <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">

              <div class="form-group">
                <label class="font-size-sm font-weight-medium"><?= Lang::$lang['category'] ?></label>
                <select class="form-control custom-select custom-select-sm" name="fcId" onchange="this.form.submit()">
                  <option value="0"><?= Lang::$lang['all'] ?></option>
                  <?php
                  $searchCategorys = $this->categoryController->GetCategory();
                  foreach ($searchCategorys as $cat):
                  ?>
                    <option value="<?= $cat['id'] ?>" <?= $fcId == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['category']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label class="font-size-sm font-weight-medium"><?= Lang::$lang['condition'] ?></label>
                <select class="form-control custom-select custom-select-sm" name="condition" onchange="this.form.submit()">
                  <option value="0"><?= Lang::$lang['allConditions'] ?></option>
                  <option value="1" <?= $condition == 1 ? 'selected' : '' ?>><?= Lang::$lang['brandnew'] ?></option>
                  <option value="2" <?= $condition == 2 ? 'selected' : '' ?>><?= Lang::$lang['secondhand'] ?></option>
                </select>
              </div>

              <div class="form-group">
                <label class="font-size-sm font-weight-medium"><?= Lang::$lang['sortBy'] ?></label>
                <select class="form-control custom-select custom-select-sm" name="sortBy" onchange="this.form.submit()">
                  <option value=""><?= Lang::$lang['defaultSorting'] ?></option>
                  <option value="lowToHigh" <?= $sortBy == 'lowToHigh' ? 'selected' : '' ?>><?= Lang::$lang['low2high'] ?></option>
                  <option value="hightToLow" <?= $sortBy == 'hightToLow' ? 'selected' : '' ?>><?= Lang::$lang['high2low'] ?></option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-sm btn-block btn-shadow"><?= Lang::$lang['filter'] ?></button>
            </form>
          </div>

          <?php if (Session::get('userId') && $keyword): ?>
            <button class="btn btn-outline-accent btn-sm btn-block" onclick="saveSearch()">
              <i class="czi-bookmark mr-1"></i><?= Lang::$lang['saveSearch'] ?>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </aside>

    <section class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 mb-3">
        <h6 class="font-size-base text-muted mb-0">
          <?php if ($keyword): ?>
            <?= Lang::$lang['searchResults'] ?>: "<span class="text-dark font-weight-medium"><?= htmlspecialchars($keyword) ?></span>"
          <?php else: ?>
            <?= Lang::$lang['all'] ?>
          <?php endif; ?>
          <span class="ml-1">(<?= count($products) ?>)</span>
        </h6>
        <a class="btn btn-outline-accent btn-sm d-lg-none" href="#shop-sidebar" data-toggle="sidebar">
          <i class="czi-filter-alt mr-1"></i><?= Lang::$lang['filters'] ?>
        </a>
      </div>

      <?php if (!empty($products)): ?>
        <div class="row mx-n2">
          <?php foreach ($products as $product):
            $colClass = 'col-lg-3 col-md-4 col-6';
            $showViews = false;
            require 'views/partials/product-card.php';
          endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-search" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= Lang::$lang['noResults'] ?> "<?= htmlspecialchars($keyword) ?>"</h5>
          <p class="text-muted"><?= Lang::$lang['tryDifferent'] ?></p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<script>
function saveSearch() {
  $.post('<?= Url::getDomain() ?>api/save-search/', {
    keyword: '<?= htmlspecialchars($keyword) ?>',
    fcId: <?= (int)$fcId ?>,
    scId: <?= (int)$scId ?>
  }, function(data) {
    showToast(data.success ? '<?= Lang::$lang["searchSaved"] ?>' : '<?= Lang::$lang["savedSearchLimit"] ?>', data.success ? 'success' : 'warning');
  });
}

$(document).ready(function() {
  <?php if ($keyword && Session::get('userId')): ?>
  $.post('<?= Url::getDomain() ?>api/save-search-history/', { keyword: '<?= htmlspecialchars($keyword) ?>' });
  <?php endif; ?>
});
</script>