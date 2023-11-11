<?php
include_once __DIR__ . "../../../partials/admin_boostrap.php";
session_start();
require_once __DIR__ . '../../../partials/connect.php';

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}
;


if (isset($message)) {
    foreach ($message as $message) {
        // echo '<script>alert(" ' . $message . ' ");</script>';
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($message) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
}

// if (isset($message)) {
//     foreach ($message as $message) {
//        echo '<script>alert(" ' . $message . ' ");</script><alert>';
//     }
//  }

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_message = $pdo->prepare("DELETE FROM `message` WHERE user_id = ?");
    $delete_message->execute([$delete_id]);
    header('location: index.php');
}



?>
?>

<title>Message</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include_once __DIR__ . "../../../partials/admin_header_column.php";
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include_once __DIR__ . "../../../partials/admin_header.php";
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->


                    <section class="">
                        <div class="container text-center">
                            <h2 class="position-relative d-inline-block">Message from clients</h2>
                            <!-- <hr class="mx-auto"> -->
                        </div>

                        <div class="mx-auto container">
                            <div class="card col-md-6 offset-md-3 shadow-sm">
                                <div class="card-body">
                                    <form id="product-form" action="" method="POST" enctype="multipart/form-data"
                                        class="text_center form-horizontal">
                                        <?php
                                        $select_message = $pdo->prepare("
                                        SELECT 
                                            message.id AS message_id, 
                                            message.message,
                                            user.id AS user_id,
                                            user.name, 
                                            user.phone, 
                                            user.email 
                                        FROM 
                                            message 
                                        JOIN 
                                            user ON message.user_id = user.id
                                    ");

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
                                                                <?= $fetch_message['phone']; ?>
                                                            </span> </p>
                                                        <p> email : <span>
                                                                <?= $fetch_message['email']; ?>
                                                            </span> </p>
                                                        <p> message : <span>
                                                                <?= $fetch_message['message']; ?>
                                                            </span> </p>
                                                        <a href="contact.php?delete=<?= htmlspecialchars($fetch_message['user_id']); ?>"
                                                            onclick="return confirm('delete this message?');"
                                                            class="delete-btn">delete</a>

                                                        <!-- <td class="pt-4">
                                                            <a class="btn btn-danger my-1 my-lg-0"
                                                                data-id="<?= htmlspecialchars($fetch_message['user_id']); ?>"
                                                                data-toggle="modal"
                                                                data-target="#deleteConfirmationModal">delete</a>

                                                        </td> -->


                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            echo '<p class="empty">you have no messages!</p>';
                                        }
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?php
    include_once __DIR__ . '../../../partials/admin_footer.php';