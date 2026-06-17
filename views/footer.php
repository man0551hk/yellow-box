
  <!-- Footer -->
  <footer class="footer-yellow pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-4">
          <img src="<?= Url::getDomain() ?>images/logo.png" style="height:40px;" class="mb-3" alt="Yellow Hub">
          <p class="small"><?= Session::get("lang") == "tc" ? "Yellow Hub 係香港其中一個最大嘅網上買賣平台，讓你輕鬆買賣各類商品。" : "Yellow Hub is one of Hong Kong's largest online marketplace, making it easy to buy and sell various items." ?></p>
          <div class="mt-3">
            <a href="#" class="text-white mr-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white mr-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white mr-3"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <h6 class="text-uppercase font-weight-bold mb-3"><?= Lang::$lang["categories"] ?></h6>
          <ul class="list-unstyled small">
            <?php
            $footerCategorys = $this->categoryController->GetCategory();
            foreach ($footerCategorys as $fc):
            ?>
              <li class="mb-2"><a href="<?= Url::SetLink($fc["seo"]) ?>"><?= $fc["category"] ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <h6 class="text-uppercase font-weight-bold mb-3"><?= Lang::$lang["help"] ?></h6>
          <ul class="list-unstyled small">
            <li class="mb-2"><a href="#"><?= Lang::$lang["about"] ?></a></li>
            <li class="mb-2"><a href="#"><?= Lang::$lang["contactUs"] ?></a></li>
            <li class="mb-2"><a href="#"><?= Lang::$lang["terms"] ?></a></li>
            <li class="mb-2"><a href="#"><?= Lang::$lang["privacyPolicy"] ?></a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-4 mb-4">
          <h6 class="text-uppercase font-weight-bold mb-3"><?= Lang::$lang["contactUs"] ?></h6>
          <ul class="list-unstyled small">
            <li class="mb-2"><i class="fas fa-envelope mr-2"></i> support@yellowhk.com</li>
           
            <li class="mb-2"><i class="fas fa-map-marker-alt mr-2"></i> Hong Kong</li>
          </ul>
        </div>
      </div>
      <hr class="border-secondary">
      <div class="row">
        <div class="col text-center small">
          &copy; <?= date('Y') ?> deepYellow Limited. <?= Lang::$lang["allRightsReserved"] ?>.
        </div>
      </div>
    </div>
  </footer>

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // Enable dropdown submenu on hover
    $('.dropdown-submenu').on('mouseenter', function() {
      $(this).find('.dropdown-menu').first().addClass('show');
    }).on('mouseleave', function() {
      $(this).find('.dropdown-menu').first().removeClass('show');
    });

    // Auto-hide alerts
    $('.alert-auto-hide').fadeTo(5000, 0).slideUp(500, function() {
      $(this).remove();
    });

    // Confirm delete
    $('.btn-confirm-delete').on('click', function(e) {
      if (!confirm('<?= Lang::$lang["confirmDelete"] ?>')) {
        e.preventDefault();
      }
    });

    // Format price input
    $('.price-format').on('input', function() {
      var val = $(this).val().replace(/[^0-9]/g, '');
      $(this).val(val);
    });

    // Load recently viewed products on home page
    $(document).ready(function() {
      if ($('#recentlyViewedContainer').length) {
        $.get('<?= Url::getDomain() ?>api/get-recently-viewed/', function(data) {
          var container = $('#recentlyViewedContainer');
          container.empty();
          if (data && data.length > 0) {
            data.forEach(function(product) {
              var col = $('<div class="col-lg-3 col-md-4 col-6 mb-3"></div>');
              col.html(`
                <div class="card product-card h-100">
                  <a href="<?= Url::getDomain() ?>product/${product.refId}/">
                    <img src="${product.image || '<?= Url::getDomain() ?>images/test.jpg'}" class="card-img-top" alt="${product.listingTitle}">
                  </a>
                  <div class="card-body p-3">
                    <p class="card-text small text-muted mb-1">
                      <a href="<?= Url::getDomain() ?>category/${product.category_seo}/" class="category-badge">${product.category_name}</a>
                    </p>
                    <h6 class="card-title mb-1">
                      <a href="<?= Url::getDomain() ?>product/${product.refId}/" class="text-dark">${product.listingTitle.substring(0, 30)}</a>
                    </h6>
                    <p class="product-price mb-0">$${Number(product.price).toLocaleString()}</p>
                    <small class="text-muted">${product.viewedDate ? new Date(product.viewedDate).toLocaleDateString() : ''}</small>
                  </div>
                </div>
              `);
              container.append(col);
            });
          } else {
            container.html('<div class="col-12 empty-state"><i class="fas fa-history"></i><p><?= Session::get("lang") == "tc" ? "未有瀏覽記錄" : "No recently viewed items" ?></p></div>');
          }
        });
      }

      // Check unread notifications
      function checkNotifications() {
        $.get('<?= Url::getDomain() ?>api/get-notifications/', function(data) {
          if (data && data.unreadCount > 0) {
            $('#notificationBadge').text(data.unreadCount).show();
          } else {
            $('#notificationBadge').hide();
          }
        });
      }
      
      <?php if ($isLoggedIn): ?>
      checkNotifications();
      setInterval(checkNotifications, 30000); // Check every 30 seconds
      <?php endif; ?>
    });
  </script>

</body>
</html>
