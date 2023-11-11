<?php 

include_once __DIR__ . '../../partials/boostrap.php';
include_once __DIR__ . '../../partials/header.php';
require_once __DIR__ . '../../partials/connect.php'; 

if(isset($_POST['submit'])){
    $name = $_POST['name'];

    $phone = $_POST['phone'];

    $email = $_POST['email'];

    $password = md5($_POST['password']);

    $cpassword = md5($_POST['cpassword']);

    $select = $pdo->prepare("SELECT * FROM user WHERE email = ? AND phone = ?");
    $select->execute([$email, $phone]);

    if($select->rowCount() > 0){
        $message[] = 'User email already exist!';
    }else{
        if($password != $cpassword){
            $message[] = 'Confirm password not matched!';
        }else{
            $insert = $pdo->prepare("INSERT INTO `user`(name, phone, email, password) VALUES(?, ?, ?, ?)");
            $insert->execute([$name, $phone, $email, $password]);
            $message[] = 'registered successfully!';
            header('Location: login.php');
            }
        }
}

?>
<title>Register</title>
</head>

<body>

    <?php
    if(isset($message)) {
        foreach($message as $message){
            echo '<script>alert(" '.$message.' ");</script><alert><div class="messgage">';
        }
    }
?>
    <!-- Register -->
    <section class="my-5 py-5">
        <!-- <div class="container text-center mt-3 pt-5">
            <img src="../img/account/user0.png" alt="" width="100">
        </div> -->
        <div class="container title text-center mt-3 pt-5">
            <h2 class="position-relative d-inline-block">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container mt-3">
            <div class="card col-md-6 offset-md-3">
                <div class="card-body">
                    <form action="register.php" id="register-form" method='post' class="text_center form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" id="register-name" name="name" placeholder="Name"
                                for="name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="register-phone" name="phone" placeholder="Phone"
                                for="phone">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="register-email" name="email" placeholder="Email"
                                for="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="register-password" name="password"
                                placeholder="Password" for="password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="register-confirm-password" name="cpassword"
                                placeholder="Confirm Password" for="cpassword">
                        </div>
                        <div class="form-group row">
                            <div class="form-check col-md-6">
                                <input class="form-check-input" type="checkbox" id="agree" name="agree" value="agree" />
                                <label class="form-check-label" for="agree">Agree to our regulations</label>
                            </div>
                            <div class="col-md-6">
                                <a href="login.php" id="login-url" class="">Do you have an account ? Login</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn w-100" id="register-btn" value="Register" name="submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <?php
    include_once __DIR__ . '/../partials/footer.php';
    ?>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#register-form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                phone: {
                    required: true,
                    minlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                cpassword: {
                    required: true,
                    minlength: 8,
                    equalTo: '#register-password',
                },
                agree: 'required',
            },
            messages: {
                name: {
                    required: 'You have not entered your username',
                    minlength: 'Username must have at least 8 characters',
                },
                phone: {
                    required: 'You have not entered your phone',
                    minlength: 'Phone must have  10 numbers',
                },
                email: 'Invalid email box',
                password: {
                    required: 'You have not entered a password',
                    minlength: 'Password must have at least 10 characters',
                },
                cpassword: {
                    required: 'You have not entered a password',
                    minlength: 'Password must have at least 10 characters',
                    equalTo: 'The password does not match the entered password'
                },

                agree: 'You must agree to our regulations'
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                if (element.prop('type') === 'checkbox') {
                    error.insertAfter(element.siblings('label'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element)
                    .addClass('is-invalid')
                    .removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element)
                    .addClass('is-valid')
                    .removeClass('is-invalid');
            },
        });
    });
    </script>