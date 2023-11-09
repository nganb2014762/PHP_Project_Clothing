<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';

// session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_users = $pdo->prepare("DELETE FROM `user` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');

}

?>


<section class="my-3 py-3 user-accounts">
   <div class="container title text-center mt-3 pt-5">
      <h2 class="position-relative d-inline-block">Total Users</h2>
      <!-- <hr class="mx-auto"> -->
   </div>


   <div class="table-responsive">
      <table class="table table-success table-striped mt-3">
         <thead>
            <tr>
               <th scope="col">Image</th>
               <th scope="col">User ID</th>
               <th scope="col">Username</th>
               <th scope="col">Email</th>
               <th scope="col">Role</th>
               <th scope="col">Delete</th>
            </tr>
         </thead>
         <?php
         $select_users = $pdo->prepare("SELECT * FROM `user` WHERE role = '0' ");
         $select_users->execute();
         while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div style="<?php if ($fetch_users['id'] == $admin_id) {
               echo 'display:none';
            }; 
            ?>">
               <tbody>
                  <tr>
                     <td>
                        <img src="uploaded_img/<?= $fetch_users['image']; ?>" alt="">
                     </td>
                     <td><span>
                           <?= $fetch_users['id']; ?>
                        </span>
                     </td>
                     <td><span>
                           <?= $fetch_users['name']; ?>
                        </span></td>
                     <td><span>
                           <?= $fetch_users['email']; ?>
                        </span></td>
                     <td><span style=" color:<?php if ($fetch_users['role'] == '1') {
                        echo 'admin';
                     }; ?>">
                           <?= $fetch_users['role']; ?>
                        </span></td>
                     <td>
                        <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>"
                           onclick="return confirm('delete this user?');" class="btn">delete</a>
                     </td>
                  </tr>
               </tbody>
               <?php
         }
         ?>
      </table>
   </div>
</section>



<?php
include_once __DIR__ . '../../../partials/admin_footer.php';