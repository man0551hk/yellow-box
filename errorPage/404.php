<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 text-center">
      <div class="display-1 text-warning font-weight-bold">404</div>
      <h4 class="mb-3"><?= Session::get("lang") == "tc" ? "頁面未找到" : "Page Not Found" ?></h4>
      <p class="text-muted mb-4"><?= Session::get("lang") == "tc" ? "抱歉，您要尋找的頁面不存在。" : "Sorry, the page you're looking for doesn't exist." ?></p>
      <a href="<?= Url::getDomain() ?>" class="btn btn-yellow"><?= Lang::$lang['home'] ?></a>
    </div>
  </div>
</div>
