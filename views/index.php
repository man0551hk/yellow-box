<div class="container-fluid">
  <img src="<?= Url::getDomain() ?>images/heading-pages-06.png" class="img-fluid" />
</div>

<div class="container-fluid" style = "background-color:#F5F5F5;padding-top:30px;">
  <h5><?= Lang::$lang["latest"] ?></h5>
  <div class="card-deck">
    <?php
    for ($i = 0; $i < 12; $i++) { ?>
      <div class="col-lg-2 col-md-6 col-sm-12" style="padding-bottom:20px;">
        <div class="card h-100">
          <img src="<?= Url::getDomain() ?>images/test.jpg" class="card-img-top" >
          <div class="card-body">
            <h5 class="card-title">Kumamon</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <h5><?= Lang::$lang["hot"] ?></h5>
  <div class="card-deck">
    <?php
    for ($i = 0; $i < 12; $i++) { ?>
      <div class="col-lg-2 col-md-6 col-sm-12" style="padding-bottom:20px;">
        <div class="card h-100">
          <img src="<?= Url::getDomain() ?>images/test.jpg" class="card-img-top" >
          <div class="card-body">
            <h5 class="card-title">Kumamon</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>