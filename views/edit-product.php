<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="<?= Url::getDomain() ?>my-products/"><?= Lang::$lang['myProducts'] ?></a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['editProduct'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['editProduct'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="bg-secondary rounded-lg box-shadow-lg p-4 p-md-5">
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <label><?= Lang::$lang['uploadPhotos'] ?></label>
            <div class="custom-file mb-2">
              <input type="file" class="custom-file-input" name="images[]" id="editImages" multiple accept="image/*">
              <label class="custom-file-label" for="editImages"><?= Lang::$lang['dragDrop'] ?></label>
            </div>
            <div id="existingImages" class="d-flex flex-wrap mb-2">
              <?php if (!empty($product['images'])): ?>
                <?php foreach ($product['images'] as $img): ?>
                  <img src="<?= strpos($img, 'http') === 0 ? $img : Url::getDomain() . ltrim($img, '/') ?>" class="rounded-lg mr-2 mb-2" style="width:100px;height:100px;object-fit:cover;" alt="">
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div id="imagePreview" class="d-flex flex-wrap"></div>
            <small class="form-text text-muted"><?= Lang::$lang['maxImages'] ?></small>
          </div>

          <div class="form-group">
            <label><?= Lang::$lang['listingTitle'] ?></label>
            <input type="text" class="form-control" name="listingTitle" required value="<?= htmlspecialchars($product['listingTitle']) ?>">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label><?= Lang::$lang['category'] ?></label>
              <select class="form-control custom-select" name="fcId" required>
                <?php foreach ($this->categoryController->GetCategory() as $cat): ?>
                  <option value="<?= $cat['id'] ?>" <?= $product['fcId'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['category']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label><?= Lang::$lang['selectSubcategory'] ?></label>
              <select class="form-control custom-select" name="scId">
                <option value="0"><?= Lang::$lang['selectSubcategory'] ?></option>
                <?php foreach ($this->categoryController->GetSubCategory($product['fcId']) as $sc): ?>
                  <option value="<?= $sc['id'] ?>" <?= $product['scId'] == $sc['id'] ? 'selected' : '' ?>><?= htmlspecialchars($sc['category']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label><?= Lang::$lang['condition'] ?></label>
              <select class="form-control custom-select" name="condition" required>
                <option value="1" <?= $product['condition'] == 1 ? 'selected' : '' ?>><?= Lang::$lang['brandnew'] ?></option>
                <option value="2" <?= $product['condition'] == 2 ? 'selected' : '' ?>><?= Lang::$lang['secondhand'] ?></option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label><?= Lang::$lang['price'] ?></label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input type="number" class="form-control" name="price" required value="<?= $product['price'] ?>">
              </div>
            </div>
            <div class="form-group col-md-4">
              <label><?= Lang::$lang['brand'] ?></label>
              <input type="text" class="form-control" name="brand" value="<?= htmlspecialchars($product['brand']) ?>">
            </div>
          </div>

          <div class="form-group">
            <label><?= Lang::$lang['description'] ?></label>
            <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
          </div>

          <div class="form-group">
            <label><?= Lang::$lang['keywords'] ?></label>
            <input type="text" class="form-control" name="keyword" value="<?= htmlspecialchars($product['keyword']) ?>">
          </div>

          <div class="d-flex flex-wrap">
            <button type="submit" class="btn btn-primary btn-shadow mr-2 mb-2"><i class="czi-check mr-1"></i><?= Lang::$lang['update'] ?></button>
            <a href="<?= Url::getDomain() ?>product/<?= $product['refId'] ?>/" class="btn btn-outline-accent mb-2"><?= Lang::$lang['cancel'] ?></a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>