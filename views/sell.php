<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h4 class="mb-4"><?= Lang::$lang["sellBanner"] ?></h4>
          
          <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>
          
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang["uploadPhotos"] ?></label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="images[]" id="images" multiple accept="image/*">
                <label class="custom-file-label" for="images"><?= Lang::$lang["dragDrop"] ?></label>
              </div>
              <div id="imagePreview" class="mt-2 d-flex flex-wrap"></div>
              <small class="form-text text-muted"><?= Lang::$lang["maxImages"] ?></small>
            </div>
            
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang["listingTitle"] ?></label>
              <input type="text" class="form-control" name="listingTitle" required maxlength="100" placeholder="<?= Lang::$lang["enterTitle"] ?>">
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="font-weight-bold"><?= Lang::$lang["category"] ?></label>
                <select class="form-control" name="fcId" id="fcId" required>
                  <option value=""><?= Lang::$lang["selectCategory"] ?></option>
                  <?php
                  $sellCategorys = $this->categoryController->GetCategory();
                  foreach ($sellCategorys as $cat):
                  ?>
                    <option value="<?= $cat["id"] ?>"><?= $cat["category"] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label class="font-weight-bold"><?= Lang::$lang["selectSubcategory"] ?></label>
                <select class="form-control" name="scId" id="scId">
                  <option value="0"><?= Lang::$lang["selectSubcategory"] ?></option>
                </select>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-4">
                <label class="font-weight-bold"><?= Lang::$lang["condition"] ?></label>
                <select class="form-control" name="condition" required>
                  <option value="1"><?= Lang::$lang["brandnew"] ?></option>
                  <option value="2"><?= Lang::$lang["secondhand"] ?></option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label class="font-weight-bold"><?= Lang::$lang["price"] ?></label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                  <input type="number" class="form-control price-format" name="price" required min="0" placeholder="<?= Lang::$lang["enterPrice"] ?>">
                </div>
              </div>
              <div class="form-group col-md-4">
                <label class="font-weight-bold"><?= Lang::$lang["brand"] ?></label>
                <input type="text" class="form-control" name="brand" placeholder="<?= Lang::$lang["enterBrand"] ?>">
              </div>
            </div>
            
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang["description"] ?></label>
              <textarea class="form-control" name="description" rows="5" maxlength="2000" placeholder="<?= Lang::$lang["enterDescription"] ?>"></textarea>
            </div>
            
            <div class="form-group">
              <label class="font-weight-bold"><?= Lang::$lang["keywords"] ?></label>
              <input type="text" class="form-control" name="keyword" placeholder="<?= Lang::$lang["enterKeywords"] ?>">
            </div>
            
            <button type="submit" class="btn btn-yellow btn-lg btn-block"><?= Lang::$lang["submit"] ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Image preview
document.getElementById('images').addEventListener('change', function(e) {
  var preview = document.getElementById('imagePreview');
  preview.innerHTML = '';
  for (var i = 0; i < e.target.files.length && i < 10; i++) {
    var file = e.target.files[i];
    var reader = new FileReader();
    reader.onload = function(e) {
      var img = document.createElement('img');
      img.src = e.target.result;
      img.style.width = '100px';
      img.style.height = '100px';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '8px';
      img.style.margin = '5px';
      preview.appendChild(img);
    }
    reader.readAsDataURL(file);
  }
});

// Load subcategories
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
