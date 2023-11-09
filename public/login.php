<?php

include_once __DIR__ . '../../partials/boostrap.php';

include_once __DIR__ . '../../partials/header.php';

require_once __DIR__ . '../../partials/connect.php';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];

    $password = md5($_POST['password']);
    $sql = "SELECT * FROM `user` WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':password' => $password
    ]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['role'] == '0') {
            $_SESSION['user_id'] = $row['id'];
            header('Location: index.php');
            exit();
        } else {
            $message[] = 'No user found or incorrect email or password!';
        }
    } else {
        $message[] = 'No user found or incorrect email or password!';
    }

};
?>

<?php

if (isset($message)) {
    foreach ($message as $message) {
        // echo '<script>alert(" ' . $message . ' ");</script>';
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($message) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
    }
}
;
?>
<title>Login</title>
</head>

<body>

    <!-- Login -->
    <section class="my-5 py-5">
        <div class="container title text-center mt-3 pt-5">
            <h2 class="position-relative d-inline-block">Login</h2>
            <!-- <hr class="mx-auto"> -->
        </div>
        <div class="mx-auto container mt-3">
            <div class="card col-md-6 offset-md-3">
                <div class="card-body">
                    <form action="login.php" id="login-form" method="post" class="text_center form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" id="login-email" name="email" placeholder="Email"
                                for="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="login-password" name="password"
                                placeholder="Password" for="password">
                        </div>
                        <div class="form-group row">
                            <div class="form-check col-md-6">
                                <input class="form-check-input" type="checkbox" id="agree" name="agree" value="agree" />
                                <label class="form-check-label">Remember Account</label>
                            </div>
                            <div class="col-md-6">
                                <a href="register.php" id="register-url" class="">Don't have account ? Register</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn w-100" id="login-btn" value="Login" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Login -->

    <?php
    include_once __DIR__ . '/../partials/footer.php';
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#login-form').validate({
                rules: {
                    email: {
                        required: true,
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    email: 'You have not entered a email',
                    password: {
                        required: 'You have not entered a password'
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    if (element.prop('type') === 'checkbox') {
                        error.insertAfter(element.siblings('label'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element)
                        .addClass('is-invalid')
                        .removeClass('is-valid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element)
                        .addClass('is-valid')
                        .removeClass('is-invalid');
                },
            });
        });
    </script>