<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang["sell"] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang["sellBanner"] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="bg-secondary rounded-lg box-shadow-lg p-4 p-md-5">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <label><?= Lang::$lang["uploadPhotos"] ?></label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="images[]" id="images" multiple accept="image/*">
              <label class="custom-file-label" for="images"><?= Lang::$lang["dragDrop"] ?></label>
            </div>
            <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
            <small class="form-text text-muted"><?= Lang::$lang["maxImages"] ?></small>
          </div>

          <div class="form-group">
            <label><?= Lang::$lang["listingTitle"] ?></label>
            <input type="text" class="form-control" name="listingTitle" required maxlength="100" placeholder="<?= Lang::$lang["enterTitle"] ?>">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label><?= Lang::$lang["category"] ?></label>
              <select class="form-control custom-select" name="fcId" id="fcId" required>
                <option value=""><?= Lang::$lang["selectCategory"] ?></option>
                <?php foreach ($this->categoryController->GetCategory() as $cat): ?>
                  <option value="<?= $cat["id"] ?>"><?= htmlspecialchars($cat["category"]) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label><?= Lang::$lang["selectSubcategory"] ?></label>
              <select class="form-control custom-select" name="scId" id="scId">
                <option value="0"><?= Lang::$lang["selectSubcategory"] ?></option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4">
              <label><?= Lang::$lang["condition"] ?></label>
              <select class="form-control custom-select" name="condition" required>
                <option value="1"><?= Lang::$lang["brandnew"] ?></option>
                <option value="2"><?= Lang::$lang["secondhand"] ?></option>
              </select>
            </div>
            <div class="form-group col-md-4">
              <label><?= Lang::$lang["price"] ?></label>
              <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                <input type="number" class="form-control price-format" name="price" required min="0" placeholder="<?= Lang::$lang["enterPrice"] ?>">
              </div>
            </div>
            <div class="form-group col-md-4">
              <label><?= Lang::$lang["brand"] ?></label>
              <input type="text" class="form-control" name="brand" placeholder="<?= Lang::$lang["enterBrand"] ?>">
            </div>
          </div>

          <div class="form-group">
            <label><?= Lang::$lang["description"] ?></label>
            <textarea class="form-control" name="description" rows="5" maxlength="2000" placeholder="<?= Lang::$lang["enterDescription"] ?>"></textarea>
          </div>

          <div class="form-group">
            <label><?= Lang::$lang["keywords"] ?></label>
            <input type="text" class="form-control" name="keyword" placeholder="<?= Lang::$lang["enterKeywords"] ?>">
          </div>

          <button type="submit" class="btn btn-primary btn-lg btn-block btn-shadow"><i class="czi-add mr-2"></i><?= Lang::$lang["submit"] ?></button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('images').addEventListener('change', function(e) {
  var preview = document.getElementById('imagePreview');
  preview.innerHTML = '';
  for (var i = 0; i < e.target.files.length && i < 10; i++) {
    (function(file) {
      var reader = new FileReader();
      reader.onload = function(ev) {
        var img = document.createElement('img');
        img.src = ev.target.result;
        img.className = 'rounded-lg mr-2 mb-2';
        img.style.cssText = 'width:100px;height:100px;object-fit:cover;';
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    })(e.target.files[i]);
  }
});

document.getElementById('fcId').addEventListener('change', function() {
  var fcId = this.value;
  var scSelect = document.getElementById('scId');
  scSelect.innerHTML = '<option value="0"><?= Lang::$lang["selectSubcategory"] ?></option>';
  if (fcId) {
    fetch('<?= Url::getDomain() ?>api/get-subcategories/?fcId=' + fcId)
      .then(function(r) { return r.json(); })
      .then(function(data) {
        data.forEach(function(cat) {
          var opt = document.createElement('option');
          opt.value = cat.id;
          opt.textContent = cat.category;
          scSelect.appendChild(opt);
        });
      });
  }
});
</script>