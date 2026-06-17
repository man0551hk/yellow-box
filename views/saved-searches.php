<div class="container py-4">
  <h4 class="section-title"><?= Lang::$lang['savedSearches'] ?></h4>
  <p class="text-muted mb-4"><?= Lang::$lang['savedSearchLimit'] ?></p>
  
  <?php if (!empty($searches)): ?>
    <div class="row">
      <?php foreach ($searches as $search): ?>
        <div class="col-md-4 mb-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
              <div>
                <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode($search['keyword']) ?>&fcId=<?= $search['fcId'] ?>&scId=<?= $search['scId'] ?>" class="text-dark font-weight-bold">
                  <i class="fas fa-search mr-2 text-warning"></i><?= htmlspecialchars($search['keyword']) ?>
                </a>
                <div class="small text-muted mt-1"><?= date('Y-m-d', strtotime($search['createdDate'])) ?></div>
              </div>
              <button class="btn btn-sm btn-outline-danger" onclick="deleteSearch(<?= $search['searchId'] ?>)">
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
