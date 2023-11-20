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
    $msg = $_POST['msg'];

    $select_message = $pdo->prepare("SELECT * FROM `message` WHERE  user_id = ?");
    $select_message->execute([$msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'already sent message!';
    } else {

        $insert_message = $pdo->prepare("INSERT INTO `message`(user_id, message) VALUES(?,?)");
        $insert_message->execute([$user_id, $msg]);

        $message[] = 'Sent message successfully!<br>We will email or call you as soon as possible.<br>Thank you for your understanding.';
    }
}
;

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
            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="alert alert-warning alert-dismissible fade show col-9" role="alert">
                        ' . $message . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
            ;
            ?>
            <form id="register-form" class="text_center form-horizontal col-md-9" action="" method="POST">


                <div class="form-group">
                    <textarea name="msg" class="form-control rounded-3" required placeholder="Enter your message" cols="30"
                        rows="10"></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" value="send message" class="btn w-100 mt-3" name="send">
                </div>
            </form>
        </div>

    </div>


    <?php
    include_once __DIR__ . '../../partials/footer.php';