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

   $check_wishlist_numbers = $pdo->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

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


<title>Cart</title>
</head>

<body>
   <!-- quick-view -->
   <section id="quick-view" class="pt-5">
      <div class="container">
         <div class="title text-center mt-5 pt-5">
            <h2 class="position-relative d-inline-block">Features Product</h2>
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
                           <button class="buy-btn text-capitalize mt-3" type="submit" name="add_to_wishlist">Add To Wishlist</button>
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
      </div>
   </section>
   <!-- end of quick-view -->

   <?php
   include_once __DIR__ . '../../partials/footer.php';
   ?>
</body>

</html>
