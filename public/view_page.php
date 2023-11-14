<?php
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';


if (isset($_POST['add_to_wishlist'])) {
   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];

   $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = :p_name AND user_id = :user_id");
   $check_wishlist_numbers->execute([':p_name' => $p_name, ':user_id' => $user_id]);
   if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'already added to wishlist!';
   } else {
      $insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }
}

if (isset($_POST['add_to_cart'])) {
   $pid = $_POST['pid'];
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_POST['p_image'];
   $p_qty = $_POST['p_qty'];

   $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_cart_numbers->rowCount() > 0) {
      // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
      $update_qty = $pdo->prepare("UPDATE `cart` SET quantity = quantity + ? WHERE name = ? AND user_id = ?");
      $update_qty->execute([$p_qty, $p_name, $user_id]);
      $message[] = 'Quantity updated in cart!';
   } else {
      // Sản phẩm chưa có trong giỏ hàng, thêm mới
      $insert_cart = $pdo->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }
}


?>

<title>Features Product</title>
</head>

<body>
   <!-- quick-view -->
   <section id="quick-view" class="pt-5">
      <div class="container">
         <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">Features Product</h2>
         </div>

         <div class="container align-text-center">
            <div class="row">
               <?php
               $pid = $_GET['pid'];
               $select_products = $pdo->prepare("SELECT products.*, category.name as category_name FROM `products` 
               JOIN category ON products.category_id = category.id WHERE products.id = ?");
               $select_products->execute([$pid]);
               if ($select_products->rowCount() > 0) {
                  while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                     <div class="col-lg-4 mt-5 offset-1">
                        <div class="card mb-3">
                           <img class="card-img img-fluid"
                              src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>" alt="Card image cap"
                              id="product-detail">
                        </div>
                        <div class="row">
                           <!--Start Controls-->
                           <div class="col-1 align-self-center">
                              <a href="#multi-item-example" role="button" data-bs-slide="prev">
                                 <i class="text-dark fas fa-chevron-left"></i>
                                 <span class="sr-only">Previous</span>
                              </a>
                           </div>
                           <!--End Controls-->
                           <!--Start Carousel Wrapper-->
                           <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item pointer-event"
                              data-bs-ride="carousel">
                              <!--Start Slides-->
                              <div class="carousel-inner product-links-wap" role="listbox">

                                 <!--First slide-->
                                 <div class="carousel-item active">
                                    <div class="row">
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 1">
                                          </a>
                                       </div>
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 2">
                                          </a>
                                       </div>
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 3">
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                 <!--/.First slide-->

                                 <!--Second slide-->
                                 <div class="carousel-item">
                                    <div class="row">
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 4">
                                          </a>
                                       </div>
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 5">
                                          </a>
                                       </div>
                                       <div class="col-4">
                                          <a href="#">
                                             <img class="card-img img-fluid"
                                                src="admin/uploaded_img/<?= htmlspecialchars($fetch_products['image']); ?>"
                                                alt="Product Image 6">
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                                 <!--/.Second slide-->
                              </div>
                              <!--End Slides-->
                           </div>
                           <!--End Carousel Wrapper-->
                           <!--Start Controls-->
                           <div class="col-1 align-self-center">
                              <a href="#multi-item-example" role="button" data-bs-slide="next">
                                 <i class="text-dark fas fa-chevron-right"></i>
                                 <span class="sr-only">Next</span>
                              </a>
                           </div>
                           <!--End Controls-->
                        </div>
                     </div>
                     <!-- col end -->
                     <div class="col-lg-6 mt-5">
                        <div class="card">
                           <div class="card-body">
                              <form action="" method="POST" onsubmit="return addToCart();" onsubmit="return addToWishlist();">
                                 <div class="row">
                                    <div class="col-11">
                                       <h2 class="card-text text-capitalize fw-bold">
                                          <?= htmlspecialchars($fetch_products['name']); ?>
                                       </h2>
                                    </div>
                                    <div class="col-1 text-end">
                                       <button class="text-capitalize border-0 bg-white" type="submit"
                                          name="add_to_wishlist"><i
                                             class="fa-regular fa-heart fa-lg text-dark heart"></i></button>
                                    </div>
                                 </div>
                                 <p class="h3">$
                                    <?= htmlspecialchars($fetch_products['price']); ?>
                                 </p>
                                 <p class="">
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-warning"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                                 </p>
                                 <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                       <h6>Category:</h6>
                                    </li>
                                    <li class="list-inline-item">
                                       <p class="text-muted text-capitalize">
                                          <?= htmlspecialchars($fetch_products['category_name']); ?>
                                       </p>
                                    </li>
                                 </ul>
                                 <h6>Description:</h6>
                                 <p class="text-capitalize">
                                    <?= htmlspecialchars($fetch_products['details']); ?>
                                 </p>

                                 <h6>Care Instruction:</h6>
                                 <ul class="list-unstyled">
                                    <li>do not bleach</li>
                                    <li>tumble dry with low heat</li>
                                    <li>iron on low heat</li>
                                    <li>machine wash with cold water</li>
                                 </ul>
                                 <ul class="list-inline">
                                    <li class="list-inline-item text-right h6">
                                       Quantity:
                                    </li>
                                    <input type="number" min="1" max="<?= htmlspecialchars($fetch_products['quantity']); ?>"
                                       value="1" name="p_qty" class="qty" style="width: 100px;" />
                                    <button class="buy-btn text-capitalize" type="submit" name="add_to_cart">
                                       Add To Cart</button>
                                 </ul>
                                 <ul class="list-inline">
                                    <a href="shop.php"
                                       class="buy-btn text-capitalize col-5 text-decoration-none text-dark">Continue
                                       Shopping</a>

                                    <a href="cart.php" class="buy-btn text-capitalize col-5 text-decoration-none text-dark">Go
                                       to Cart</a>

                                 </ul>

                                 <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                 <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                                 <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                                 <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                              </form>
                           </div>
                        </div>
                     </div>
                     <?php
                  }
               } else {
                  echo '<p class="empty text-capitalize">no products added yet!</p>';
               }
               ?>
            </div>
         </div>
   </section>
   <!-- end of quick-view -->

   <!-- Related items section-->
   <section id="collection">
      <div class="container">
         <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">Reviews</h2>
         </div>

         <div class="row g-0 container">
            <div class="col-4">
               <img src="img/undraw_posting_photo.svg" alt="" width="70%">
            </div>
            <div class="col-8">
               <p class="card-text text-capitalize text-truncate fw-bold">
                  Tên người bình luận
               </p>
               <p class="text-truncate text-capitalize">
                  Bình luận nội dung
               </p>
            </div>
            <p class="text-primary">Bình luận</p>
            <input type="text">
            <button type="submit" class="mt-2">bình luận</button>

         </div>
      </div>
      </div>
   </section>

   <!-- Related items section-->
   <section id="collection" class="bg-light">
      <div class="container">
         <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">You May Also Like</h2>
         </div>

         <div class="row g-0 container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 mt-3">
               <?php
               $select_products = $pdo->prepare("SELECT * FROM `products`");
               $select_products->execute();
               if ($select_products->rowCount() > 0) {
                  while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                     <div class="col">
                        <div class="card shadow rounded h-100">
                           <div class="collection-img position-relative">
                              <img class="rounded-top p-0 card-img-top"
                                 src="admin/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                           </div>

                           <div class="card-body">
                              <div class="row">
                                 <div class="col-8">
                                    <p class="card-text text-capitalize text-truncate fw-bold">
                                       <?= htmlspecialchars($fetch_products['name']); ?>
                                    </p>
                                 </div>
                                 <div class="col-4 text-end"><a href="#"><i
                                          class="fa-regular fa-heart fa-lg text-dark heart"></i></a></div>
                              </div>
                              <p class="text-truncate text-capitalize">
                                 <?= htmlspecialchars($fetch_products['details']); ?>
                              </p>
                              <div class="d-flex justify-content-between align-items-center">
                                 <span class="fw-bold d-block h5">$
                                    <?= htmlspecialchars($fetch_products['price']); ?>
                                 </span>
                                 <div class="btn-group">
                                    <a href="view_page.php?pid=<?= htmlspecialchars($fetch_products['id']); ?>"
                                       class="btn btn-primary">View</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <?php
                  }
                  ?>
               </div>

               <?php
               } else {
                  echo htmlspecialchars('<p class="empty">no products added yet!</p>');
               }
               ?>
         </div>
      </div>
   </section>

   <script>
      function addToWishlist() {
         // Kiểm tra trạng thái đăng nhập ở phía client (trình duyệt)
         var loggedIn = <?php echo htmlspecialchars(isset($_SESSION['user_id']) ? 'true' : 'false'); ?>;

         if (!loggedIn) {
            // Hiển thị thông báo hoặc chuyển hướng đến trang đăng nhập
            alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
            window.location.href = 'login.php'; // Chuyển hướng đến trang đăng nhập
            return false; // Ngăn chặn gửi yêu cầu đến máy chủ
         }
         return true; // Cho phép gửi yêu cầu đến máy chủ
      }
   </script>

   <script>
      function addToCart() {
         // Kiểm tra trạng thái đăng nhập ở phía client (trình duyệt)
         var loggedIn = <?php echo htmlspecialchars(isset($_SESSION['user_id']) ? 'true' : 'false'); ?>;

         if (!loggedIn) {
            // Hiển thị thông báo hoặc chuyển hướng đến trang đăng nhập
            alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
            window.location.href = 'login.php'; // Chuyển hướng đến trang đăng nhập
            return false; // Ngăn chặn gửi yêu cầu đến máy chủ
         }
         return true; // Cho phép gửi yêu cầu đến máy chủ
      }
   </script>

   <?php
   include_once __DIR__ . '../../partials/footer.php';
   ?>
</body>

</html>