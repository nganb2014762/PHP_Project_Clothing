<?php

include_once __DIR__ . '../../../partials/boostrap.php';

include_once __DIR__ . '../../../partials/admin_header.php';

require_once __DIR__ . '../../../partials/connect.php';

// session_start();

// $admin_id = $_SESSION['admin_id'];

// if(!isset($admin_id)){
//    header('location: login.php');
// };

if (isset($message)) {
   foreach ($message as $message) {
      echo '<script>alert(" ' . $message . ' ");</script><alert>';
   }
}

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location: admin_contacts.php');
}

?>

<title>messages</title>
</head>

<body>

   <section class="container my-3 py-3">
      <div class="container title text-center mt-3 pt-5">
         <h2 class="position-relative d-inline-block">Messages</h2>
         <!-- <hr class="mx-auto"> -->
      </div>
      <div class="row row-cols-2 row-cols-md-4 g-4 mt-3">
         <?php
         $select_message = $pdo->prepare("SELECT * FROM `message`");
         $select_message->execute();
         if ($select_message->rowCount() > 0) {
            while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <div class="col text-center">
                  <div class="card h-100 p-4">
                     <p> user id : <span>
                           <?= $fetch_message['user_id']; ?>
                        </span> </p>
                     <p> name : <span>
                           <?= $fetch_message['name']; ?>
                        </span> </p>
                     <p> number : <span>
                           <?= $fetch_message['number']; ?>
                        </span> </p>
                     <p> email : <span>
                           <?= $fetch_message['email']; ?>
                        </span> </p>
                     <p> message : <span>
                           <?= $fetch_message['message']; ?>
                        </span> </p>
                     <a href="admin_contacts.php?delete=<?= $fetch_message['id']; ?>"
                        onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
                  </div>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty">you have no messages!</p>';
         }
         ?>
      </div>
   </section>

   <?php
   include_once __DIR__ . '../../../partials/admin_footer.php';