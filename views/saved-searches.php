<div class="container py-4">
  <h4 class="section-title"><?= Lang::$lang['savedSearches'] ?></h4>
  <p class="text-muted mb-4"><i class="fas fa-info-circle mr-1"></i><?= Lang::$lang['savedSearchLimit'] ?></p>
  
  <?php if (!empty($searches)): ?>
    <div class="row">
      <?php foreach ($searches as $search): ?>
        <div class="col-md-4 mb-3">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div class="min-width-0">
                <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode($search['keyword']) ?>&fcId=<?= $search['fcId'] ?>&scId=<?= $search['scId'] ?>" class="font-weight-bold" style="color:#332c24;">
                  <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-warning-light d-flex align-items-center justify-content-center mr-2" style="width:36px;height:36px;background:#FFF8DC;flex-shrink:0;">
                      <i class="fas fa-search" style="color:#DAA520;font-size:0.9rem;"></i>
                    </div>
                    <span class="text-truncate"><?= htmlspecialchars($search['keyword']) ?></span>
                  </div>
                </a>
                <div class="small text-muted mt-2 ml-5 pl-1"><i class="far fa-clock mr-1"></i><?= date('Y-m-d', strtotime($search['createdDate'])) ?></div>
              </div>
              <button class="btn btn-sm btn-outline-danger ml-2 flex-shrink-0" onclick="deleteSearch(<?= $search['searchId'] ?>)" title="<?= Lang::$lang['delete'] ?>">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <i class="fas fa-bookmark"></i>
      <h5><?= Lang::$lang['noSavedSearches'] ?></h5>
      <p><?= Session::get("lang") == "tc" ? "搜尋時點擊「儲存搜尋」按鈕，最多可儲存10個" : "Click 'Save Search' when searching, you can save up to 10" ?></p>
    </div>
  <?php endif; ?>
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
