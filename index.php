<?php
session_start();
$token = md5(uniqid('spa_'));
$_SESSION['_csrf'] = $token;

//check if user is logged in
$logged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
$login_message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$application_name = 'Salon/Spa-Admin Dashboard';
if ($logged) {
    header("Location: manage_spa.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<title><?=$application_name?></title>

<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="favicons/favicon.ico" type="image/x-icon">


<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->

<link rel="stylesheet" href="vendor/bower-asset/bootstrap/dist/css/bootstrap.css">
<link rel="stylesheet" href="css/bootstrap-theme.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="vendor/bower-asset/pace/themes/green/pace-theme-flat-top.css">
<body>
<div class="container text-center">
    <div class="col-md-12"><img src="icons/logo.png" alt="<?=$application_name?>" width="250"></div>
    <div class="col-md-12"><h1><?=$application_name?></h1></div>
    <div class="col-md-12">
        <h4>You need to login in order to proceed</h4>
    </div>
    <div class="row">
        <span class="text text-danger"><?= $login_message ?></span>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="margin-top: 25px;">
            <button type="button" class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#myModal">
                Login
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User Login</h4>
            </div>
            <div class="modal-body">
                <!-- login form here -->
                <form action="modules/user_login.php" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="_csrf" value="<?= $token; ?>"/>
                    Email:<br>
                    <input type="text" name="username" placeholder="Email Address" class="form-control text-input"
                           required="required"><br>
                    Password:<br>
                    <input type="password" name="password" placeholder="password" class="form-control text-input"
                           required="required"><br><br>

                    <input type="submit" value="SIGN IN" class="btn btn-default btn-lg btn-block btn-lg">
                </form>
                <!-- end of login form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script src="vendor/bower-asset/jquery/dist/jquery.min.js"></script>
<script src="vendor/bower-asset/bootstrap/dist/js/bootstrap.js"></script>
<script src=vendor/bower-asset/pace/pace.min.js></script>
</body>
</html>
