<?php
include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';


if (isset($_POST['add_to_wishlist'])) {
   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = :p_name AND user_id = :user_id");
   $check_wishlist_numbers->execute([':p_name' => $p_name, ':user_id' => $user_id]);
   // $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   // $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $pdo->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'already added to wishlist!';
   } elseif ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {
      $insert_wishlist = $pdo->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }
}

if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
    $p_name = $_POST['p_name'];
    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
    $p_price = $_POST['p_price'];
    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
    $p_image = $_POST['p_image'];
    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);
 
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

         <div class="container pb-5 align-text-center ju">
            <div class="row">
               <?php
               $pid = $_GET['pid'];
               $select_products = $pdo->prepare("SELECT products.*, category.name as category_name FROM `products` 
            JOIN category ON products.category_id = category.id WHERE products.id = ?");
               $select_products->execute([$pid]);
               if ($select_products->rowCount() > 0) {
                  while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                     <div class="col-lg-4 mt-5">
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
                              <form action="" method="POST" onsubmit="return addToCart();">
                                 <div class="row">
                                    <div class="col-8">
                                       <h2 class="card-text text-capitalize fw-bold">
                                          <?= htmlspecialchars($fetch_products['name']); ?>
                                       </h2>
                                    </div>
                                    <div class="col-4 text-end"><a href="wishlist.php"><i
                                             class="fa-regular fa-heart fa-lg text-dark heart"></i></a></div>
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

                                 <h6>Specification:</h6>
                                 <ul class="list-unstyled">
                                    <li>Lorem ipsum dolor sit</li>
                                    <li>Amet, consectetur</li>
                                    <li>Adipiscing elit,set</li>
                                    <li>Duis aute irure</li>
                                    <li>Ut enim ad minim</li>
                                    <li>Dolore magna aliqua</li>
                                    <li>Excepteur sint</li>
                                 </ul>


                                 <ul class="list-inline">
                                    <li class="list-inline-item text-right h6">
                                       Quantity:
                                    </li>
                                    <input type="number" min="1" max="<?= htmlspecialchars($fetch_products['quantity']); ?>"
                                       value="1" name="p_qty" class="qty" style="width: 100px;"/>
                                    <button class="buy-btn text-capitalize" type="submit" name="add_to_cart">
                                       Add To Cart</button>
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


         <div class="row mt-5">
            <?php
            $pid = $_GET['pid'];
            $select_products = $pdo->prepare("SELECT products.*, category.name as category_name FROM `products` 
            JOIN category ON products.category_id = category.id WHERE products.id = ?");
            $select_products->execute([$pid]);
            if ($select_products->rowCount() > 0) {
               while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                     <img class="img-fluid w-100 pb-1" src="admin/uploaded_img/<?= $fetch_products['image']; ?>" alt=""
                        id="mainImg" />
                  </div>

                  <div class="col-lg-6 col-md-12 col-12">
                     <form action="" method="POST">
                        <div class="category">
                           <h6 class="text-capitalize mt-3">
                              <?= $fetch_products['category_name']; ?>
                           </h6>
                        </div>
                        <div class="name">
                           <h2 class="text-capitalize mt-3">
                              <?= $fetch_products['name']; ?>
                           </h2>
                        </div>
                        <div class="price">
                           <h1 class="text-capitalize mt-3">$<span>
                                 <?= $fetch_products['price']; ?>
                              </span></h1>
                        </div>
                        <div class="quantity">
                           <input type="number" min="1" value="1" name="p_qty" class="qty" />
                           <button class="buy-btn text-capitalize mt-3" type="submit" name="add_to_cart">Add To Cart</button>
                        </div>
                        <div class="wishlist">
                           <button class="buy-btn text-capitalize mt-3" type="submit" name="add_to_wishlist">Add To
                              Wishlist</button>
                        </div>
                        <div class="details">
                           <h4 class="text-capitalize mt-3">Product details</h4>
                           <?= $fetch_products['details']; ?>
                        </div>
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                        <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                        <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                     </form>
                  </div>
                  <?php
               }
            } else {
               echo '<p class="empty text-capitalize">no products added yet!</p>';
            }
            ?>
         </div>
   </section>
   <!-- end of quick-view -->
   <!-- Trên đầu trang HTML -->
   <script>
      function addToCart() {
         // Kiểm tra trạng thái đăng nhập ở phía client (trình duyệt)
         var loggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

         if (!loggedIn) {
            // Hiển thị thông báo hoặc chuyển hướng đến trang đăng nhập
            alert('Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.');
            window.location.href = 'login.php'; // Chuyển hướng đến trang đăng nhập
            return false; // Ngăn chặn gửi yêu cầu đến máy chủ
         }

         // Tiếp tục xử lý thêm vào giỏ hàng ở đây
         // ...

         return true; // Cho phép gửi yêu cầu đến máy chủ
      }
   </script>

   <?php
   include_once __DIR__ . '../../partials/footer.php';
   ?>
</body>

</html>