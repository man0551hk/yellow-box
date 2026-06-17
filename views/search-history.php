<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="font-weight-bold mb-0" style="color:#332c24;"><?= Lang::$lang["searchHistory"] ?></h4>
    <?php if (!empty($history)): ?>
      <button class="btn btn-sm btn-outline-danger" onclick="clearHistory()">
        <i class="fas fa-trash mr-1"></i><?= Session::get("lang") == "tc" ? "清除記錄" : "Clear history" ?>
      </button>
    <?php endif; ?>
  </div>

  <?php if (!empty($history)): ?>
    <div class="card border-0 shadow-sm">
      <div class="list-group list-group-flush">
        <?php foreach ($history as $item): ?>
          <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode($item['keyword']) ?>" class="list-group-item list-group-item-action history-item d-flex align-items-center">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3" style="width:40px;height:40px;">
              <i class="fas fa-history text-muted"></i>
            </div>
            <span class="flex-grow-1 font-weight-medium"><?= htmlspecialchars($item['keyword']) ?></span>
            <small class="text-muted"><i class="far fa-clock mr-1"></i><?= date('Y-m-d H:i', strtotime($item['createdDate'])) ?></small>
            <i class="fas fa-chevron-right text-muted ml-2"></i>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <i class="fas fa-history"></i>
      <h5><?= Session::get("lang") == "tc" ? "暫無搜尋記錄" : "No search history" ?></h5>
      <p class="text-muted"><?= Session::get("lang") == "tc" ? "你搜尋過的關鍵字會顯示在這裡" : "Your search keywords will appear here" ?></p>
    </div>
  <?php endif; ?>
</div>

<script>
function clearHistory() {
  if (confirm('<?= Session::get("lang") == "tc" ? "確定要清除所有搜尋記錄？" : "Clear all search history?" ?>')) {
    $.post('<?= Url::getDomain() ?>api/clear-search-history/', function() {
      location.reload();
    });
  }
}
</script>
