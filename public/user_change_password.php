<?php


include_once __DIR__ . '/../partials/boostrap.php';

include_once __DIR__ . '/../partials/header.php';

require_once __DIR__ . '/../partials/connect.php';

$user_id = $_SESSION['user_id'];
$message = [];
if(!isset($user_id)){
   header('location:login.php');
};

if (isset($_POST['update_profile'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_profile = $pdo->prepare("UPDATE `user` SET name = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $user_id]);

   // $image = $_FILES['image']['name'];
   // $image = filter_var($image, FILTER_SANITIZE_STRING);
   // $image_size = $_FILES['image']['size'];
   // $image_tmp_name = $_FILES['image']['tmp_name'];
   // $image_folder = 'uploaded_img/' . $image;
   // $old_image = $_POST['old_image'];

   // if (!empty($image)) {
   //    if ($image_size > 2000000) {
   //       $message[] = 'image size is too large!';
   //    } else {
   //       $update_image = $pdo->prepare("UPDATE `users` SET image = ? WHERE id = ?");
   //       $update_image->execute([$image, $admin_id]);
   //       if ($update_image) {
   //          move_uploaded_file($image_tmp_name, $image_folder);
   //          unlink('uploaded_img/' . $old_image);
   //          $message[] = 'image updated successfully!';
   //       }
   //       ;
   //    }
   //    ;
   // }
   // ;

   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
   $new_pass = md5($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = md5($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if (!empty($update_pass) and !empty($new_pass) and !empty($confirm_pass)) {
      if ($update_pass != $old_pass) {
         $message[] = 'old password not matched!';
      } elseif ($new_pass != $confirm_pass) {
         $message[] = 'confirm password not matched!';
      } else {
         $update_pass_query = $pdo->prepare("UPDATE `user` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $user_id]);
         $message[] = 'password updated successfully!';
      }
   }

}

?>




<section class="container my-3 py-3 ">
   <div class="container title text-center mt-3 pt-5">
      <h2 class="position-relative d-inline-block">Change Password</h2>
      <hr class="mx-auto">


   </div>
   <br>
   <?php
    if(isset($message)) {
        foreach($message as $message){
            echo '<script>alert(" '.$message.' ");</script><alert><div class="messgage">';
        }
    }
   ?>

   <div class="mx-auto container mt-5">
      <div class="card col-md-6 offset-md-3">
         <div class="card-body">
            <form id="product-form" action="" method="POST" enctype="multipart/form-data"
               class="text_center form-horizontal">
               <div class="form-group p-2">
                  <input class="form-control" type="text" name="name" value="<?= $fetch_profile['name']; ?>"
                     placeholder="update username" required class="box">
               </div>

               <div class="form-group p-2">
                  <input class="form-control" type="email" name="email" value="<?= $fetch_profile['email']; ?>"
                     placeholder="update email" required class="box">
               </div>

               <div class="form-group p-2">
                  <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
                  <input class="form-control" type="password" name="update_pass" placeholder="enter previous password"
                     class="box">
               </div>

               <div class="form-group p-2">
                  <input class="form-control" type="password" name="new_pass" placeholder="enter new password"
                     class="box">
               </div>

               <div class="form-group p-2">
                  <input class="form-control" type="password" name="confirm_pass" placeholder="confirm new password"
                     class="box">
               </div>
               <div class="form-group p-2">
                  <div class="flex-btn">
                     <input type="submit" class="btn w-100" value="Update Password" name="update_password">
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>

</section>

<?php
    include_once __DIR__ . '/../partials/footer.php';
    ?>