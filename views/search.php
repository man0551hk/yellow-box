<div class="container py-4">
  <div class="row">
    <!-- Filters Sidebar -->
    <div class="col-lg-3 mb-4">
      <div class="filter-section">
        <h6 class="font-weight-bold mb-3"><?= Lang::$lang['filters'] ?></h6>
        <form method="GET" action="<?= Url::getDomain() ?>search/">
          <input type="hidden" name="keyword" value="<?= htmlspecialchars($keyword) ?>">
          
          <div class="form-group">
            <label class="small font-weight-bold"><?= Lang::$lang['category'] ?></label>
            <select class="form-control form-control-sm" name="fcId" onchange="this.form.submit()">
              <option value="0"><?= Lang::$lang['all'] ?></option>
              <?php
              $searchCategorys = $this->categoryController->GetCategory();
              foreach ($searchCategorys as $cat):
              ?>
                <option value="<?= $cat['id'] ?>" <?= $fcId == $cat['id'] ? 'selected' : '' ?>><?= $cat['category'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          
          <div class="form-group">
            <label class="small font-weight-bold"><?= Lang::$lang['condition'] ?></label>
            <select class="form-control form-control-sm" name="condition" onchange="this.form.submit()">
              <option value="0"><?= Lang::$lang['allConditions'] ?></option>
              <option value="1" <?= $condition == 1 ? 'selected' : '' ?>><?= Lang::$lang['brandnew'] ?></option>
              <option value="2" <?= $condition == 2 ? 'selected' : '' ?>><?= Lang::$lang['secondhand'] ?></option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="small font-weight-bold"><?= Lang::$lang['sortBy'] ?></label>
            <select class="form-control form-control-sm" name="sortBy" onchange="this.form.submit()">
              <option value=""><?= Lang::$lang['defaultSorting'] ?></option>
              <option value="lowToHigh" <?= $sortBy == 'lowToHigh' ? 'selected' : '' ?>><?= Lang::$lang['low2high'] ?></option>
              <option value="hightToLow" <?= $sortBy == 'hightToLow' ? 'selected' : '' ?>><?= Lang::$lang['high2low'] ?></option>
            </select>
          </div>
          
          <button type="submit" class="btn btn-yellow btn-sm btn-block"><?= Lang::$lang['filter'] ?></button>
        </form>
      </div>
      
      <!-- Save Search -->
      <?php if (Session::get('userId') && $keyword): ?>
        <div class="filter-section">
          <button class="btn btn-outline-warning btn-sm btn-block" onclick="saveSearch()">
            <i class="fas fa-bookmark mr-1"></i><?= Lang::$lang['saveSearch'] ?>
          </button>
        </div>
      <?php endif; ?>
    </div>
    
    <!-- Results -->
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
          <?php if ($keyword): ?>
            <?= Lang::$lang['searchResults'] ?>: "<?= htmlspecialchars($keyword) ?>"
          <?php else: ?>
            <?= Lang::$lang['all'] ?>
          <?php endif; ?>
          <small class="text-muted">(<?= count($products) ?>)</small>
        </h5>
      </div>
      
      <?php if (!empty($products)): ?>
        <div class="row">
          <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-md-4 col-6 mb-3">
              <div class="card product-card h-100">
                <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/">
                  <img src="<?= $product['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" class="card-img-top" alt="<?= htmlspecialchars($product['listingTitle']) ?>">
                </a>
                <div class="card-body p-3">
                  <p class="card-text small text-muted mb-1">
                    <a href="<?= Url::SetLink($product['category_seo']) ?>" class="category-badge"><?= $product['category_name'] ?></a>
                  </p>
                  <h6 class="card-title mb-1">
                    <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/" class="text-dark"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 30)) ?></a>
                  </h6>
                  <p class="product-price mb-0">$<?= number_format($product['price']) ?></p>
                  <small class="text-muted"><?= date('Y-m-d', strtotime($product['createdDate'])) ?></small>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="fas fa-search"></i>
          <h5><?= Lang::$lang['noResults'] ?> "<?= htmlspecialchars($keyword) ?>"</h5>
          <p><?= Lang::$lang['tryDifferent'] ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function saveSearch() {
  $.post('<?= Url::getDomain() ?>api/save-search/', {
    keyword: '<?= htmlspecialchars($keyword) ?>',
    fcId: <?= $fcId ?>,
    scId: <?= $scId ?>
  }, function(data) {
    if (data.success) {
      showToast('<?= Lang::$lang["searchSaved"] ?>', 'success');
    } else {
      showToast('<?= Lang::$lang["savedSearchLimit"] ?>', 'warning');
    }
  });
}

// Record search history
$(document).ready(function() {
  <?php if ($keyword && Session::get('userId')): ?>
  $.post('<?= Url::getDomain() ?>api/save-search-history/', {
    keyword: '<?= htmlspecialchars($keyword) ?>'
  });
  <?php endif; ?>
});
</script>

