<?php
session_start();
$token = md5(uniqid('mail_'));
$_SESSION['_csrf'] = $token;

//check if user is logged in
$logged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
$name = isset($_SESSION['username']) ? $_SESSION['username'] : false;
$spa_id = isset($_GET['spa_id']) ? $_GET['spa_id'] : 0;
$application_name = 'Services - User Admin';
if (!$logged) {
	header("Location: index.php");
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title><?= $application_name ?></title>
    <!-- Force latest IE rendering engine or ChromeFrame if installed -->
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="vendor/bower-asset/jquery-ui/themes/cupertino/jquery-ui.css">
    <link rel="stylesheet" href="vendor/bower-asset/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">

    <link rel="stylesheet" href="vendor/bower-asset/jsgrid/css/jsgrid.css">
    <link rel="stylesheet" href="vendor/bower-asset/jsgrid/css/theme.css">
    <link rel="stylesheet" href="vendor/bower-asset/pace/themes/green/pace-theme-loading-bar.css">
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="col-md-12">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><?= $application_name ?></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <li><a href="logout.php">Logout (<?= $name ?>)</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="col-md-12" style="margin:0 0 10px 0">
    <a href="manage_spa.php" class="btn btn-primary btn-sm"><< Back to Spa</a>
</div>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="spa_id" id="spa_id" value="<?= $spa_id; ?>"/>
            <div id="jsGrid"><?= $application_name ?></div>
        </div>
    </div>
</div>

<div id="detailsDialog">
    <form id="detailsForm">
        <div class="row">
            <div class="col-md-12">
                <label for="name">Salon/Spa Name:</label>
                <input id="SPA_NAME" name="SPA_NAME" type="text" readonly="readonly" class="form-control"/>
                <input id="SPA_ID" name="SPA_ID" type="hidden" class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="name">Service:</label>
                <input id="SERVICE_NAME" name="SERVICE_NAME" type="text" class="form-control"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="name">Cost</label>
                <input id="SERVICE_COST" name="SERVICE_COST" type="text" class="form-control"/>
            </div>
        </div>
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12">
                <button type="submit" id="save" class="btn btn-success btn-block btn-sm">Save</button>
            </div>
        </div>

    </form>
</div>
<!-- end of modal -->
<script src="vendor/bower-asset/jquery/dist/jquery.js"></script>
<script src="vendor/bower-asset/jquery-ui/jquery-ui.js"></script>

<script src="vendor/bower-asset/bootstrap/dist/js/bootstrap.js"></script>
<script src="vendor/bower-asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="vendor/bower-asset/jquery-validation/dist/additional-methods.min.js"></script>

<script type="text/javascript" src="vendor/bower-asset/jsgrid/dist/jsgrid.min.js"></script>

<script src=vendor/bower-asset/pace/pace.min.js></script>
<script src=js/waiting_modal.js></script>
<script src=js/spa_services.js></script>
</body>
</html>
