<?php
    require_once('process_registration.php');

    if(isset($_SESSION['email'])){
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- icon-->
    <link rel="icon" href="./img/favicon.png" sizes="16x16">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PharmaClique - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        .bg-gradient-primary {
            background-color: #1B5B3A !important;
            background-image: -webkit-gradient(linear,left top,left bottom,color-stop(50%,#05445E),to(#05445E)) !important;
            background-image: linear-gradient(180deg,#05445E 10%,#05445E 100%) !important;
            background-size: cover !important;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Alert Here -->
        <?php
        if(isset($_SESSION['loginError'])){
            ?>
            <br>
            <div class="alert alert-warning alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php
                echo $_SESSION['loginError'];
                unset($_SESSION['loginError']);
                ?>
            </div>
            <?php
        }
        ?>
        <!-- End Alert Here -->

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">PharmaClique -  <?php echo date("Y"); ?></h1>
                                    </div>
                                    <form class="user" method="post" action="process_registration.php">
<!--                                        <span class="text-danger">--><?php //if(isset($_SESSION['loginError'])){ echo $_SESSION['loginError']; } ?><!--</span>-->
                                        <div class="form-group">
                                            <input type="email" class="form-control"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
<!--                                        <div class="form-group">-->
<!--                                            <div class="custom-control custom-checkbox small">-->
<!--                                                <input type="checkbox" class="custom-control-input" id="customCheck">-->
<!--                                                <label class="custom-control-label" for="customCheck">Remember-->
<!--                                                    Me</label>-->
<!--                                            </div>-->
<!--                                        </div>-->
                                        <button type="submit" href="index.php" class="btn btn-primary btn-block" name="login">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
<?php
    unset($_SESSION['loginError']);
?>