<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h4 class="mb-4"><?= Lang::$lang['editProduct'] ?></h4>
          
          <form method="POST" action="">
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang['listingTitle'] ?></label>
              <input type="text" class="form-control" name="listingTitle" required value="<?= htmlspecialchars($product['listingTitle']) ?>">
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="font-weight-bold"><?= Lang::$lang['category'] ?></label>
                <select class="form-control" name="fcId" required>
                  <?php
                  $editCategorys = $this->categoryController->GetCategory();
                  foreach ($editCategorys as $cat):
                  ?>
                    <option value="<?= $cat['id'] ?>" <?= $product['fcId'] == $cat['id'] ? 'selected' : '' ?>><?= $cat['category'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label class="font-weight-bold"><?= Lang::$lang['selectSubcategory'] ?></label>
                <select class="form-control" name="scId">
                  <option value="0"><?= Lang::$lang['selectSubcategory'] ?></option>
                  <?php
                  $editSubCategorys = $this->categoryController->GetSubCategory($product['fcId']);
                  foreach ($editSubCategorys as $sc):
                  ?>
                    <option value="<?= $sc['id'] ?>" <?= $product['scId'] == $sc['id'] ? 'selected' : '' ?>><?= $sc['category'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-4">
                <label class="font-weight-bold"><?= Lang::$lang['condition'] ?></label>
                <select class="form-control" name="condition" required>
                  <option value="1" <?= $product['condition'] == 1 ? 'selected' : '' ?>><?= Lang::$lang['brandnew'] ?></option>
                  <option value="2" <?= $product['condition'] == 2 ? 'selected' : '' ?>><?= Lang::$lang['secondhand'] ?></option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label class="font-weight-bold"><?= Lang::$lang['price'] ?></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                  <input type="number" class="form-control" name="price" required value="<?= $product['price'] ?>">
                </div>
              </div>
              <div class="form-group col-md-4">
                <label class="font-weight-bold"><?= Lang::$lang['brand'] ?></label>
                <input type="text" class="form-control" name="brand" value="<?= htmlspecialchars($product['brand']) ?>">
              </div>
            </div>
            
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang['description'] ?></label>
              <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>
            
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang['keywords'] ?></label>
              <input type="text" class="form-control" name="keyword" value="<?= htmlspecialchars($product['keyword']) ?>">
            </div>
            
            <div class="d-flex">
              <button type="submit" class="btn btn-yellow mr-2"><?= Lang::$lang['update'] ?></button>
              <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/" class="btn btn-outline-secondary"><?= Lang::$lang['cancel'] ?></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
