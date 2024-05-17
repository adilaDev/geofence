<?php
// Include config file
require_once "layouts/config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';
$useremail_err = $msg = "";
// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$uri_segments[1]";
if (isset($_POST['submit'])) {

    $useremail = mysqli_real_escape_string($link, $_POST['useremail']);
    $sql = "SELECT * FROM users WHERE useremail = '$useremail'";
    $query = mysqli_query($link, $sql);
    $emailcount = mysqli_num_rows($query);

    if ($emailcount) {
        $userdata = mysqli_fetch_array($query);
        $username = $userdata['username'];
        $token = $userdata['token'];

        $subject = "Password Reset";
        $body = "Hi, $username. Click here to reset your password " . $actual_link . "/auth-reset-password.php?token=$token ";
        // $body = "Hi, $username. Clicl here to reset your password http://localhost/Skote-PHP/auth-reset-password.php?token=$token ";
        $sender_email = "From: $gmailid";

        try {
            // Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->Username = $gmailid;
            $mail->Password = $gmailpassword;

            // Sender and recipient settings
            $mail->setFrom($gmailid, $gmailusername);
            $mail->addAddress($useremail, $username);
            $mail->addReplyTo($gmailid, $gmailusername); // to set the reply to

            // Setting the email content
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
                $msg = "We have emailed your password reset link!";
            // header("location:auth-login.php");
        } catch (Exception $e) {
            $useremail_err =  "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $useremail_err = "No Email Found";
    }
}
?>
<?php include 'layouts/head-main.php'; ?>

<head>
    <title>Recover Password 2 | Skote - Admin & Dashboard Template</title>
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
                                    <?php if($msg) {?>
                                            <div class="alert alert-success text-center mb-4" role="alert">
                                                <?php echo $msg; ?>
                                            </div>
                                    <?php } ?>
                                        <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">

                                            <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                                <label for="useremail" class="form-label">Email</label>
                                                <input type="email" class="form-control mb-1" id="useremail" name="useremail" placeholder="Enter email">
                                                <span class="text-danger"><?php echo $useremail_err; ?></span>
                                            </div>

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