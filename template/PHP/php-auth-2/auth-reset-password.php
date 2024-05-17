<?php
// Include config file
require_once "layouts/config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = $msg = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please enter the confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    $tokenvalue = $_POST["token-value"];

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE token = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_token);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_token = $tokenvalue;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $msg = "Password updated successfully. Destroy the session, and redirect to login page";
                session_destroy();
                header("location: auth-login.php");
                exit();
            } else {
                $msg = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Reset Password | Skote - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.theme.default.min.css">
    <?php include 'layouts/head-style.php'; ?>
</head>


<body class="auth-body-bg">

    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">

                <div class="col-xl-9">
                    <div class="auth-full-bg pt-lg-5 p-4">
                        <div class="w-100">
                            <div class="bg-overlay"></div>
                            <div class="d-flex h-100 flex-column">


                                <div class="p-4 mt-auto">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-7">
                                            <div class="text-center">

                                                <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span class="text-primary">5k</span>+ Satisfied clients</h4>

                                                <div dir="ltr">
                                                    <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">" Fantastic theme with a ton of options. If you just want the HTML to integrate with your project, then this is the package. You can find the files in the 'dist' folder...no need to install git and all the other stuff the documentation talks about. "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">Abs1981</h4>
                                                                    <p class="font-size-14 mb-0">- Skote User</p>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="item">
                                                            <div class="py-3">
                                                                <p class="font-size-16 mb-4">" If Every Vendor on Envato are as supportive as Themesbrand, Development with be a nice experience. You guys are Wonderful. Keep us the good work. "</p>

                                                                <div>
                                                                    <h4 class="font-size-16 text-primary">nezerious</h4>
                                                                    <p class="font-size-14 mb-0">- Skote User</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-3">
                    <div class="auth-full-page-content p-md-5 p-4">
                        <div class="w-100">

                            <div class="d-flex flex-column h-100">
                                <div class="mb-4 mb-md-5">
                                    <a href="index.php" class="d-block auth-logo">
                                        <img src="assets/images/logo-dark.png" alt="" height="18" class="auth-logo-dark">
                                        <img src="assets/images/logo-light.png" alt="" height="18" class="auth-logo-light">
                                    </a>
                                </div>
                                <div class="my-auto">

                                    <div>
                                        <h5 class="text-primary"> Reset Password</h5>
                                        <p class="text-muted">Re-Password with Skote.</p>
                                    </div>

                                    <div class="mt-4">
                                        <?php if ($msg) { ?>
                                            <div class="alert alert-success text-center mb-4" role="alert">
                                                <?php echo $msg; ?>
                                            </div>
                                        <?php } ?>
                                        <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                            <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                                <label for="new_password">New Password</label>
                                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter password" value="<?php echo $new_password; ?>">
                                                <span class="text-danger"><?php echo $new_password_err; ?></span>
                                            </div>

                                            <div class="mb-3 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                                <label for="userpassword">Confirm Password</label>
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter password" value="<?php echo $confirm_password; ?>">
                                                <span class="text-danger"><?php echo $confirm_password_err; ?></span>
                                            </div>

                                            <input type="hidden" name="token-value" value="<?php echo $_GET['token']; ?>" />
                                            <div class="text-end">
                                                <button class="btn btn-primary w-md waves-effect waves-light" type='submit' name='submit' value='Submit'>Reset</button>
                                            </div>
                                        </form>
                                        <div class="mt-5 text-center">
                                            <p>Remember It ? <a href="auth-login-2.php" class="fw-medium text-primary"> Sign In here</a> </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mt-md-5 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                        </script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>

    <!-- JAVASCRIPT -->
    <?php include 'layouts/vendor-scripts.php'; ?>

    <!-- owl.carousel js -->
    <script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>

    <!-- auth-2-carousel init -->
    <script src="assets/js/pages/auth-2-carousel.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

</body>

</html>