<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: login.php');
    exit();
}




if (isset($_POST['send'])) {

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $pdo->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'already sent message!';
    } else {

        $insert_message = $pdo->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
        $insert_message->execute([$user_id, $name, $email, $number, $msg]);

        $message[] = 'sent message successfully!';
    }
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
  };
?>

<title>Contact</title>
</head>

<body>
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
        <div class="col d-none d-md-block d-lg-block mt-5">
            <img width="250%" height="100%" src="img/poster/contact_us.jpg" class="rounded float-start" alt="">
        </div>
        <div class="col p-5 m-5 d-flex flex-column position-static">
            <div class="container title mt-5 pt-5 pb-2 col-md-9 offset-md-3 ">
                <h2 class="position-relative d-inline-block">Contact Us</h2>
                <hr class="mx-auto">
            </div>
            <!-- <h3 class="mb-0 mt-5">Contact Us</h3> -->

            <form id="register-form" class="text_center form-horizontal col-md-9" action="" method="POST">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" required placeholder="enter your name">
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" required placeholder="enter your email">
                </div>

                <div class="form-group">
                    <input type="number" name="number" min="0" class="form-control" required
                        placeholder="enter your number">
                </div>

                <div class="form-group">
                    <textarea name="msg" class="form-control" required placeholder="enter your message" cols="30"
                        rows="10"></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" value="send message" class="btn w-100" name="send">
                </div>
            </form>
        </div>

    </div>
    <!-- <section class="my-5 py-5">
        <div class="mx-auto container-fluid mt-3 col-md-6 offset-md-2">
            


        </div>

        </div>

    </section> -->


    <!-- <section class="my-5 py-5">
        <div class="container title text-center mt-3 pt-5">
            <h2 class="position-relative d-inline-block">Contact Us</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container mt-3">
            <div class="card col-md-6 offset-md-3">
                <div class="card-body">
                    <form id="register-form" class="text_center form-horizontal" action="" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" required placeholder="enter your name">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" class="form-control" required
                                placeholder="enter your email">
                        </div>

                        <div class="form-group">
                            <input type="number" name="number" min="0" class="form-control" required
                                placeholder="enter your number">
                        </div>

                        <div class="form-group">
                            <textarea name="msg" class="form-control" required placeholder="enter your message"
                                cols="30" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="send message" class="btn w-100" name="send">
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section> -->

    <?php
    include_once __DIR__ . '../../partials/footer.php';