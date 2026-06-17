<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="section-title mb-0"><?= Lang::$lang['myProducts'] ?></h4>
    <a href="<?= Url::getDomain() ?>sell/" class="btn btn-yellow"><i class="fas fa-plus mr-1"></i><?= Lang::$lang['sell'] ?></a>
  </div>
  
  <?php if (!empty($products)): ?>
    <div class="table-responsive">
      <table class="table table-hover bg-white shadow-sm rounded">
        <thead class="thead-light">
          <tr>
            <th><?= Lang::$lang['listingTitle'] ?></th>
            <th><?= Lang::$lang['price'] ?></th>
            <th><?= Lang::$lang['category'] ?></th>
            <th><?= Lang::$lang['status'] ?></th>
            <th><?= Lang::$lang['postedOn'] ?></th>
            <th><?= Lang::$lang['edit'] ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
            <tr>
              <td>
                <div class="d-flex align-items-center">
                  <img src="<?= $product['image'] ?: Url::getDomain() . 'images/test.jpg' ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;" class="mr-3">
                  <div>
                    <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/" class="text-dark font-weight-bold"><?= htmlspecialchars(mb_substr($product['listingTitle'], 0, 40)) ?></a>
                  </div>
                </div>
              </td>
              <td class="font-weight-bold">$<?= number_format($product['price']) ?></td>
              <td><span class="category-badge"><?= $product['category_name'] ?></span></td>
              <td>
                <?php if ($product['status'] == 1): ?>
                  <span class="badge badge-success"><?= Lang::$lang['available'] ?></span>
                <?php elseif ($product['status'] == 2): ?>
                  <span class="badge badge-warning"><?= Lang::$lang['reserved'] ?></span>
                <?php else: ?>
                  <span class="badge badge-secondary"><?= Lang::$lang['sold'] ?></span>
                <?php endif; ?>
              </td>
              <td><small class="text-muted"><?= date('Y-m-d', strtotime($product['createdDate'])) ?></small></td>
              <td>
                <a href="<?= Url::getDomain() ?>edit-product/<?= $product['refId'] ?>/" class="btn btn-sm btn-outline-primary mr-1"><i class="fas fa-edit"></i></a>
                <a href="<?= Url::getDomain() ?>delete-product/<?= $product['refId'] ?>/" class="btn btn-sm btn-outline-danger btn-confirm-delete"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <i class="fas fa-box-open"></i>
      <h5><?= Lang::$lang['noProducts'] ?></h5>
      <a href="<?= Url::getDomain() ?>sell/" class="btn btn-yellow mt-3"><?= Lang::$lang['sell'] ?></a>
    </div>
  <?php endif; ?>
</div>
