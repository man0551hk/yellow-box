<?php $activePage = 'saved-searches'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['savedSearches'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['savedSearches'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <p class="font-size-sm text-muted pt-lg-3 pb-3"><i class="czi-announcement mr-1"></i><?= Lang::$lang['savedSearchLimit'] ?></p>

      <?php if (!empty($searches)): ?>
        <div class="row">
          <?php foreach ($searches as $search): ?>
            <div class="col-md-6 mb-3">
              <div class="card border-0 box-shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div class="min-width-0">
                    <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode($search['keyword']) ?>&fcId=<?= $search['fcId'] ?>&scId=<?= $search['scId'] ?>" class="font-weight-medium text-dark d-flex align-items-center">
                      <i class="czi-search text-accent mr-2"></i>
                      <span class="text-truncate"><?= htmlspecialchars($search['keyword']) ?></span>
                    </a>
                    <div class="font-size-xs text-muted mt-2 ml-4"><i class="czi-time mr-1"></i><?= date('Y-m-d', strtotime($search['createdDate'])) ?></div>
                  </div>
                  <button class="btn btn-sm btn-outline-danger flex-shrink-0 ml-2" onclick="deleteSearch(<?= $search['searchId'] ?>)" title="<?= Lang::$lang['delete'] ?>">
                    <i class="czi-trash"></i>
                  </button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-bookmark" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= Lang::$lang['noSavedSearches'] ?></h5>
          <p class="text-muted"><?= $isTc ? "搜尋時點擊「儲存搜尋」按鈕，最多可儲存10個" : "Click 'Save Search' when searching, you can save up to 10" ?></p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<script>
function deleteSearch(searchId) {
  if (confirm('<?= Lang::$lang["confirmDelete"] ?>')) {
    $.post('<?= Url::getDomain() ?>api/delete-search/', {searchId: searchId}, function(data) {
      if (data.success) {
        showToast('<?= Lang::$lang["searchDeleted"] ?>', 'success');
        location.reload();
      }
    });
  }
}
</script>