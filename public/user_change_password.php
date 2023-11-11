<?php

include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php';

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if (isset($_POST['update_password'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   $update_password = $pdo->prepare("UPDATE `user` SET name = ?, email = ? WHERE id = ?");
   $update_password->execute([$name, $email, $user_id]);

   $update_pass = md5($_POST['update_pass']);
   $new_pass = md5($_POST['new_pass']);
   $confirm_pass = md5($_POST['confirm_pass']);

   if (!empty($update_pass) && !empty($new_pass) && !empty($confirm_pass)) {
      if ($update_pass != $fetch_profile['password']) {
         $message[] = 'Mật khẩu cũ không khớp!';
      } elseif ($new_pass != $confirm_pass) {
         $message[] = 'Mật khẩu xác nhận không khớp!';
      } else {
         $update_pass_query = $pdo->prepare("UPDATE `user` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $user_id]);
         $message[] = 'Mật khẩu đã được cập nhật thành công!';
         // // Chuyển hướng đến trang index.php sau khi cập nhật mật khẩu
         // header('location:index.php');
         // exit(); // Đảm bảo không có đầu ra khác trước chuyển hướng
      }
   }

};

if (isset($message)) {
   foreach ($message as $message) {
       echo '<div class="alert alert-warning alert-dismissible fade show col-4 offset-4" role="alert" tabindex="-1">
               ' . htmlspecialchars($message) . '
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
   }
}
;
?>

<title>Change Password</title>
</head>

<section class="container my-5 pt-5">
   <div class="container title text-center mt-3 pt-5">
      <h2 class="position-relative d-inline-block">Change Password</h2>
      <hr class="mx-auto">


   </div>
   <div class="mx-auto container">
      <div class="card col-md-6 offset-md-3 bg-secondary">
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