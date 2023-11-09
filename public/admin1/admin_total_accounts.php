<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';

// session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}
;

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_users = $pdo->prepare("DELETE FROM `user` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   header('location:admin_users.php');
}

?>

<title>Admin Total Accounts</title>
</head>

<section class="my-3 py-3">
   <div class="container title text-center mt-3 pt-5">
      <h2 class="position-relative d-inline-block">Total Accounts</h2>
      <!-- <hr class="mx-auto"> -->
   </div>

   <div class="card container mt-3">
      <div class="card-body">
         <div class="table-responsive">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">STT</th>
                     <th scope="col">Image</th>
                     <th scope="col">Name</th>
                     <th scope="col">Sex</th>
                     <th scope="col">Born</th>
                     <th scope="col-4">Address</th>
                     <th scope="col">Phone</th>
                     <th scope="col">Email</th>
                     <th scope="col">Role</th>
                     <th scope="col">Edit</th>
                     <th scope="col">Delete</th>
                  </tr>
               </thead>

               <tbody class="table-group-divider">
                  <?php
                  $i = 1;
                  $select_users = $pdo->prepare("SELECT * FROM `user`");
                  $select_users->execute();
                  while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)) {
                     ?>
                     <tr>
                        <td class="pt-4">
                           <b>
                              <?= $i++; ?>
                           </b>
                        </td>

                        <td>
                           <?php if ($fetch_users['image'] == '') {
                              echo '<div class="col-2"><img src="../img/account/user0.png" width="70" height="70" ></div>';
                           } else {
                              ?>
                              <div class="col-2"><img src="../img/account/<?= $fetch_users['image']; ?>" width="70" height="70"></div>
                              <?php
                           }
                           ?>
                        </td>

                        <td class="pt-4">
                           <span>
                              <?= $fetch_users['name']; ?>
                           </span>
                        </td>

                        <td class="pt-4">
                           <span>
                              <?php if ($fetch_users['sex'] == '0') {
                                 echo 'female';
                              }else{
                                 echo 'male';
                              }
                              ?>
                           </span>
                        </td>

                        <td class="pt-4">
                           <span>
                              <?= $fetch_users['born']; ?>
                           </span>
                        </td>

                        <td  class="pt-4">
                           <span>
                              <?php if ($fetch_users['address'] == '') {
                                 echo 'No address';
                              }
                              ;
                              ?>
                              <?= $fetch_users['address']; ?>
                           </span>
                        </td>

                        <td  class="pt-4">
                           <span>
                              <?= $fetch_users['phone']; ?>
                           </span>
                        </td>

                        <td  class="pt-4">
                           <span>
                              <?= $fetch_users['email']; ?>
                           </span>
                        </td>

                        <td class="pt-4">
                           <span>
                              <?php if ($fetch_users['role'] == '1') {
                                 echo 'admin';
                              } else {
                                 echo 'user';
                              }
                              ?>
                           </span>
                        </td>

                        <td class="pt-4">
                           <span>
                              <a href="admin_total_accounts.php?edit=<?= $fetch_users['id']; ?>" class="edit-btn">edit</a>
                           </span>
                        </td>

                        <td class="pt-4">
                           <span><a href="admin_total_accounts.php?delete=<?= $fetch_users['id']; ?>"
                                 onclick="return confirm('delete this user?');" class="delete-btn">delete</a></span>
                        </td>
                     </tr>
                  </tbody>
                  <?php
                  }
                  ?>
            </table>
         </div>
      </div>

      <?php
      include_once __DIR__ . '../../../partials/pagination.php';
      ?>

   </div> 
</section>



<?php
include_once __DIR__ . '../../../partials/admin_footer.php';
