<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';

// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:login.php');
// };

if (isset($_POST['add_product'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $select_products = $pdo->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if ($select_products->rowCount() > 0) {
      $message[] = 'product name already exist!';
   } else {

      $insert_products = $pdo->prepare("INSERT INTO `products`(name, category, details, price, image) VALUES(?,?,?,?,?)");
      $insert_products->execute([$name, $category, $details, $price, $image]);

      if ($insert_products) {
         if ($image_size > 2000000) {
            $message[] = 'image size is too large!';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new product added!';
         }
      }
   }
}
;

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $select_delete_image = $pdo->prepare("SELECT image FROM `products` WHERE id = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   $delete_products = $pdo->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_products->execute([$delete_id]);
   $delete_wishlist = $pdo->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_cart = $pdo->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:admin_products.php');
}

if (isset($message)) {
   foreach ($message as $message) {
      echo '<script>alert(" ' . $message . ' ");</script><alert>';
   }
}
?>

<title>Products</title>
</head>

<body>
   <section class="my-5 py-5 mb-0 pb-0">
      <div class="container title text-center mt-3 ">
         <h2 class="position-relative d-inline-block">Add new product</h2>
         <!-- <hr class="mx-auto"> -->
      </div>

      <div class="mx-auto container mt-5">
         <div class="card col-md-6 offset-md-3">
            <div class="card-body">
               <form id="product-form" action="" method="POST" enctype="multipart/form-data"
                  class="text_center form-horizontal">
                  <div class="form-group p-2">
                     <input type="text" class="form-control" name="name" placeholder="Enter product name" required>
                  </div>
                  <div class="form-group p-2">
                     <select name="category" class="form-control" required>
                        <option value="" selected disabled>select category</option>
                        <option value="dress">dress</option>
                        <option value="pan">pan</option>
                        <option value="shirts">shirts</option>
                     </select>
                  </div>
                  <div class="form-group p-2">
                     <input type="number" min="0" name="price" class="form-control" placeholder="Enter product price"
                        required>
                  </div>
                  <div class="form-group p-2">
                     <input type="file" name="image" class="form-control" required
                        accept="image/jpg, image/jpeg, image/png">
                  </div>
                  <div class="form-group p-2">
                     <textarea name="details" class="form-control" placeholder="Enter product details" cols="30"
                        rows="10" required></textarea>
                  </div>
                  <div class="form-group p-2">
                     <input type="submit" class="btn w-100" value="add product" name="add_product">
                  </div>   
               </form>
            </div>
         </div>
      </div>
   </section>


   <section class="container my-3 py-3">
      <div class="container title text-center">
         <h2 class="position-relative d-inline-block">Products Added</h2>
         <!-- <hr class="mx-auto"> -->
      </div>
      <div class="container row row-cols-2 row-cols-md-4 g-4 mt-3">
         <?php
         $show_products = $pdo->prepare("SELECT * FROM `products`");
         $show_products->execute();
         if ($show_products->rowCount() > 0) {
            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <div class="col text-center">
                  <div class="card h-100 p-4">
                     <div class="price">$
                        <?= $fetch_products['price']; ?>/-
                     </div>
                     <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">

                     <div class="name">
                        <?= $fetch_products['name']; ?>
                     </div>
                     <div class="cat">
                        <?= $fetch_products['category']; ?>
                     </div>
                     <div class="details">
                        <?= $fetch_products['details']; ?>
                     </div>
                     <div class="flex-btn">
                        <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                        <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn"
                           onclick="return confirm('delete this product?');">delete</a>
                     </div>
                  </div>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty text-center">now products added yet!</p>';
         }
         ?>
      </div>
      </div>
   </section>

   <?php
   include_once __DIR__ . '../../../partials/admin_footer.php';