<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';
// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location:login.php');
// };

if (isset($_POST['update_product'])) {

   $pid = $_POST['pid'];
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
   $old_image = $_POST['old_image'];

   $update_product = $pdo->prepare("UPDATE `products` SET name = ?, category = ?, details = ?, price = ? WHERE id = ?");
   $update_product->execute([$name, $category, $details, $price, $pid]);

   $message[] = 'product updated successfully!';

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'image size is too large!';
      } else {

         $update_image = $pdo->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);

         if ($update_image) {
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/' . $old_image);
            $message[] = 'image updated successfully!';
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="/css/style.css">

</head>

<body>

   <section class="my-5 py-5 mb-0 pb-0">
      <div class="container title text-center mt-3 ">
         <h2 class="position-relative d-inline-block">update product</h2>
         <!-- <hr class="mx-auto"> -->
      </div>

      <div class="mx-auto container mt-5">
         <div class="card col-md-6 offset-md-3">
            <div class="card-body">
               <?php
               $update_id = $_GET['update'];
               $select_products = $pdo->prepare("SELECT * FROM `products` WHERE id = ?");
               $select_products->execute([$update_id]);
               if ($select_products->rowCount() > 0) {
                  while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                     ?>

                     <form id="product-form" class="text_center form-horizontal" action="" method="post"
                        enctype="multipart/form-data">
                        <div class="form-group p-2">
                           <input class="form-control" type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
                        </div>

                        <div class="form-group p-2">
                           <input class="form-control" type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        </div>

                        <div class="form-group p-2 text-center" >
                           <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                        </div>

                        <div class="form-group p-2">
                           <input type="text" class="form-control" name="name" placeholder="enter product name" required class="box"
                              value="<?= $fetch_products['name']; ?>">
                        </div>

                        <div class="form-group p-2">
                           <input class="form-control" type="number" name="price" min="0" placeholder="enter product price" required class="box"
                              value="<?= $fetch_products['price']; ?>">
                        </div>

                        <div class="form-group p-2">
                           <select name="category" class="form-control" required>
                              <option selected>
                                 <?= $fetch_products['category']; ?>
                              </option>
                              <option value="dress">dress</option>
                              <option value="pan">pan</option>
                              <option value="shirts">shirts</option>

                           </select>
                        </div>

                        <div class="form-group p-2">
                           <textarea class="form-control" name="details" required placeholder="enter product details" class="box" cols="30"
                              rows="10"><?= $fetch_products['details']; ?></textarea>
                        </div>

                        <div class="form-group p-2">
                           <input class="form-control" type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png" >
                        </div>
                        
                        <div class="form-group p-2">
                           <div class="flex-btn">
                              <input type="submit" class="btn w-100" value="update product" name="update_product">
                              <a href="admin_products.php" class="btn w-100">go back</a>
                           </div>
                        </div>


                     </form>

                     <?php
                  }
               } else {
                  echo '<p class="empty">no products found!</p>';
               }
               ?>
            </div>
         </div>
      </div>
   </section>















   <script src="js/script.js"></script>

</body>

</html>