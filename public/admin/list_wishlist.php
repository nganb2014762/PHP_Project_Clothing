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


if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_message = $pdo->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    $delete_message->execute([$delete_id]);
    header('location: index.php');
}

?>

<title>List wishlist</title>
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
                            <h2 class="position-relative d-inline-block">List Favorite Products</h2>
                            <!-- <hr class="mx-auto"> -->
                        </div>


                        <div class="table-responsive">
                            <form id="product-form" action="" method="POST" enctype="multipart/form-data"
                                class="text_center form-horizontal">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">User ID</th>                                            
                                            <th scope="col">Pid</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>                                            
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php
                                        $i = 1;
                                        $select_message = $pdo->prepare("SELECT * from wishlist ");
                                        $select_message->execute();
                                        if ($select_message->rowCount() > 0) {
                                            while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                <tr>
                                                    <td class="pt-4">
                                                        <b>
                                                            <?= htmlspecialchars($i++); ?>
                                                        </b>
                                                    </td>

                                                    <td class="pt-4">
                                                        <?= htmlspecialchars($fetch_message['user_id']); ?>
                                                    </td>

                                                    <td class="pt-4">
                                                        <?= htmlspecialchars($fetch_message['pid']); ?>
                                                    </td>

                                                    <td class="pt-4">
                                                        <img src="uploaded_img/<?= htmlspecialchars($fetch_message['image']); ?>"
                                                            alt="" style="width:100px; height:120px" />
                                                    </td>

                                                    <td class="pt-4">
                                                        <?= htmlspecialchars($fetch_message['name']); ?>
                                                    </td>

                                                    <td class="pt-4">
                                                        <?= htmlspecialchars($fetch_message['price']); ?>
                                                    </td>                                                    

                                                    <td class="pt-4">
                                                        <a href="list_wishlist.php?delete=<?= htmlspecialchars($fetch_message['user_id']); ?>"
                                                            onclick="return confirm('delete this row?');"
                                                            class="delete-btn">delete</a>
                                                    </td>

                                                </tr>
                                            </tbody>
                                            <?php
                                            }
                                        }
                                        ?>
                                </table>
                            </form>
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