<?php $activePage = 'my-products'; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['myProducts'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['myProducts'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require 'views/partials/account-sidebar.php'; ?>
    <section class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center pt-lg-2 pb-4 pb-lg-5 mb-lg-3">
        <h6 class="font-size-base text-light mb-0"><?= count($products) ?> <?= Lang::$lang['products'] ?></h6>
        <a class="btn btn-primary btn-sm btn-shadow" href="<?= Url::getDomain() ?>sell/"><i class="czi-add mr-2"></i><?= Lang::$lang['sell'] ?></a>
      </div>

      <?php if (!empty($products)): ?>
        <div class="table-responsive bg-secondary rounded-lg">
          <table class="table table-hover mb-0">
            <thead>
              <tr class="bg-darker">
                <th class="border-0 text-light"><?= Lang::$lang['listingTitle'] ?></th>
                <th class="border-0 text-light"><?= Lang::$lang['price'] ?></th>
                <th class="border-0 text-light"><?= Lang::$lang['category'] ?></th>
                <th class="border-0 text-light"><?= Lang::$lang['status'] ?></th>
                <th class="border-0 text-light"><?= Lang::$lang['postedOn'] ?></th>
                <th class="border-0 text-light"><?= Lang::$lang['edit'] ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product): ?>
                <tr>
                  <td>
                    <div class="media align-items-center">
                      <img src="<?= $product['image'] ? Url::getDomain() . $product['image'] : Url::getDomain() . 'images/test.jpg' ?>" width="50" height="50" class="rounded mr-3" style="object-fit:cover;" alt="">
                      <div class="media-body">
                        <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/" class="font-size-sm text-dark font-weight-medium"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 40)) ?></a>
                      </div>
                    </div>
                  </td>
                  <td class="text-accent font-weight-medium">$<?= number_format($product['price']) ?></td>
                  <td><span class="font-size-sm"><?= htmlspecialchars($product['category_name']) ?></span></td>
                  <td>
                    <?php if ($product['status'] == 1): ?>
                      <span class="badge badge-success badge-shadow"><?= Lang::$lang['available'] ?></span>
                    <?php elseif ($product['status'] == 2): ?>
                      <span class="badge badge-warning badge-shadow"><?= Lang::$lang['reserved'] ?></span>
                    <?php else: ?>
                      <span class="badge badge-secondary badge-shadow"><?= Lang::$lang['sold'] ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="font-size-sm text-muted"><?= date('Y-m-d', strtotime($product['createdDate'])) ?></td>
                  <td>
                    <a href="<?= Url::getDomain() ?>edit-product/<?= $product['refId'] ?>/" class="btn btn-sm btn-outline-accent mr-1"><i class="czi-edit"></i></a>
                    <a href="<?= Url::getDomain() ?>delete-product/<?= $product['refId'] ?>/" class="btn btn-sm btn-outline-danger btn-confirm-delete"><i class="czi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="text-center py-5">
          <i class="czi-bag" style="font-size:4rem;color:#ccc;"></i>
          <h5 class="mt-3"><?= Lang::$lang['noProducts'] ?></h5>
          <a href="<?= Url::getDomain() ?>sell/" class="btn btn-primary btn-shadow mt-3"><i class="czi-add mr-1"></i><?= Lang::$lang['sell'] ?></a>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>