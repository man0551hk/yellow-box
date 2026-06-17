<?php $activePage = 'search-history'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang["searchHistory"] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang["searchHistory"] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center pt-lg-3 pb-4 mb-3">
        <h6 class="font-size-base text-light mb-0"><?= count($history) ?> <?= $isTc ? "條記錄" : "entries" ?></h6>
        <?php if (!empty($history)): ?>
          <button class="btn btn-sm btn-outline-danger" onclick="clearHistory()">
            <i class="czi-trash mr-1"></i><?= $isTc ? "清除記錄" : "Clear history" ?>
          </button>
        <?php endif; ?>
      </div>

      <?php if (!empty($history)): ?>
        <div class="list-group box-shadow-sm">
          <?php foreach ($history as $item): ?>
            <a href="<?= Url::getDomain() ?>search/?keyword=<?= urlencode($item['keyword']) ?>" class="list-group-item list-group-item-action d-flex align-items-center">
              <i class="czi-time text-muted mr-3"></i>
              <span class="flex-grow-1 font-weight-medium"><?= htmlspecialchars($item['keyword']) ?></span>
              <small class="text-muted"><i class="czi-time mr-1"></i><?= date('Y-m-d H:i', strtotime($item['createdDate'])) ?></small>
              <i class="czi-arrow-right text-muted ml-2"></i>
            </a>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-time" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= $isTc ? "暫無搜尋記錄" : "No search history" ?></h5>
          <p class="text-muted"><?= $isTc ? "你搜尋過的關鍵字會顯示在這裡" : "Your search keywords will appear here" ?></p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<script>
function clearHistory() {
  if (confirm('<?= $isTc ? "確定要清除所有搜尋記錄？" : "Clear all search history?" ?>')) {
    $.post('<?= Url::getDomain() ?>api/clear-search-history/', function() { location.reload(); });
  }
}
</script>