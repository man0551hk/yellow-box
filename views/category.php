<div class="container py-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent pl-0">
      <li class="breadcrumb-item"><a href="<?= Url::getDomain() ?>"><?= Lang::$lang['home'] ?></a></li>
      <li class="breadcrumb-item active"><?= $category['name'] ?></li>
    </ol>
  </nav>
  
  <div class="row">
    <div class="col-lg-3 mb-4">
      <div class="filter-section">
        <h6 class="font-weight-bold mb-3"><?= Lang::$lang['filters'] ?></h6>
        <form method="GET" action="<?= Url::getDomain() ?>search/">
          <input type="hidden" name="fcId" value="<?= $fcId ?>">
          <?php if ($scId): ?>
            <input type="hidden" name="scId" value="<?= $scId ?>">
          <?php endif; ?>
          
          <div class="form-group">
            <label class="small font-weight-bold"><?= Lang::$lang['condition'] ?></label>
            <select class="form-control form-control-sm" name="condition" onchange="this.form.submit()">
              <option value="0"><?= Lang::$lang['allConditions'] ?></option>
              <option value="1"><?= Lang::$lang['brandnew'] ?></option>
              <option value="2"><?= Lang::$lang['secondhand'] ?></option>
            </select>
          </div>
          
          <div class="form-group">
            <label class="small font-weight-bold"><?= Lang::$lang['sortBy'] ?></label>
            <select class="form-control form-control-sm" name="sortBy" onchange="this.form.submit()">
              <option value=""><?= Lang::$lang['defaultSorting'] ?></option>
              <option value="lowToHigh"><?= Lang::$lang['low2high'] ?></option>
              <option value="hightToLow"><?= Lang::$lang['high2low'] ?></option>
            </select>
          </div>
          
          <button type="submit" class="btn btn-yellow btn-sm btn-block"><?= Lang::$lang['filter'] ?></button>
        </form>
      </div>
    </div>
    
    <div class="col-lg-9">
      <h4 class="section-title"><?= $category['name'] ?></h4>
      
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
                    <span class="category-badge"><?= $product['category_name'] ?></span>
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
          <i class="fas fa-box-open"></i>
          <h5><?= Lang::$lang['noProducts'] ?></h5>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
