<?php

include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

// session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
// };

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

if (isset($message)) {
   foreach ($message as $message) {
     // echo '<script>alert(" ' . $message . ' ");</script>';
     echo '<div class="alert alert-warning alert-dismissible fade show col-4 offset-4" role="alert" tabindex="-1">
               ' . htmlspecialchars($message) . '
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
   }
 };
?>


<title>Search</title>
</head>

<section class="my-5 py-5">
    <div class="container title text-center mt-3 pt-5">
        <form action="" method="POST" class="d-flex justify-content-center">
            <div class="form-group p-2">
                <input class="form-control" type="text" name="search_box" placeholder="search products...">

            </div>
            <div class="form-group p-2">
                <input type="submit" name="search_btn" value="search" class="btn">
            </div>

        </form>
    </div>
</section>

<section class="container my-3 py-3">
   <div class="container title text-center">
      <h2 class="position-relative d-inline-block">Result</h2>
      <!-- <hr class="mx-auto"> -->
   </div>
   <div class="container row row-cols-2 row-cols-md-4 g-4 mt-3">
      <?php
      if (isset($_POST['search_btn'])) {
         $_SESSION['search_btn'] = $_POST['search_btn'];
         $_SESSION['search_btn'] = $_POST['search_box'];
      }
      if (isset($_SESSION['search_btn'])) {
         $search_box = $_SESSION['search_btn'];
         $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
         $select_products = $pdo->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <form action="" method="POST">
                  <div class="col text-center">
                     <div class="card h-100 p-4">
                        <div class="price">$
                           <?= $fetch_products['price']; ?>/-
                        </div>
                        <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                        <img src="admin/uploaded_img/<?= $fetch_products['image']; ?>" alt="">

                        <div class="name">
                           <?= $fetch_products['name']; ?>
                        </div>
                        <div class="cat">
                           <?= $fetch_products['category']; ?>
                        </div>
                        <div class="details">
                           <?= $fetch_products['details']; ?>
                        </div>
                        <div>
                           <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                           <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                           <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                           <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                        </div>
                        <div class="flex-btn">
                           <input type="number" min="1" value="1" name="p_qty" class="form-control ">
                        </div>
                        <br>
                        <div class="flex-btn">
                           <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
                        </div>
                        <br>
                        <div class="flex-btn">
                           <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                        </div>
                     </div>
                  </div>
               </form>

                    <?php
                }
            } else {
                echo '<p class="empty">no result found!</p>';
            }

        }
        ;
        ?>
    </div>
    </div>
</section>



<?php
include_once __DIR__ . '/../partials/footer.php';
?>