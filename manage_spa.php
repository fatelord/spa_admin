<?php
session_start();
$token = md5(uniqid('mail_'));
$_SESSION['_csrf'] = $token;

//check if user is logged in
$logged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
$name = isset($_SESSION['username']) ? $_SESSION['username'] : false;
$application_name = 'SALON/SPA - User Admin';
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
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="_csrf" id="_csrf" value="<?= $token; ?>"/>
            <div id="jsGrid"><?= $application_name ?></div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="detailsDialog" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= $application_name ?></h4>
            </div>
            <div class="modal-body">
                <!-- form here -->
                <form id="detailsForm">
                    <div class="row">
                        <label for="name">Salon/Spa Name:</label>
                        <input id="SPA_NAME" name="SPA_NAME" type="text" class="form-control"/>
                    </div>
                    <div class="row">
                        <label for="name">Telephone Number:</label>
                        <input id="SPA_TEL" name="SPA_TEL" type="text" class="form-control"/>
                    </div>
                    <div class="row">
                        <label for="name">Location</label>
                        <input id="SPA_LOCATION" name="SPA_LOCATION" type="text" class="form-control"/>
                    </div>
                    <div class="row">
                        <label for="name">Email</label>
                        <input id="SPA_EMAIL" name="SPA_EMAIL" type="text" class="form-control"/>
                    </div>
                    <div class="row">
                        <label for="name">Website</label>
                        <input id="SPA_WEBSITE" name="SPA_WEBSITE" type="text" class="form-control"/>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Map</label>
                            <input id="SPA_MAP_COORD" name="SPA_MAP_COORD" type="text" class="form-control"/>
                        </div>
                        <div class="col-md-6">
                            <label for="name">Image</label>
                            <input id="SPA_IMAGE" name="SPA_IMAGE" type="text" class="form-control"/>
                        </div>
                    </div>
                </form>
                <!-- end of form -->
            </div>
            <div class="modal-footer">
                <div class="row">
                    <button type="submit" id="save" class="btn btn-primary btn-block">Save</button>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end of modal -->
<script src="vendor/bower-asset/jquery/dist/jquery.js"></script>
<script src="vendor/bower-asset/bootstrap/dist/js/bootstrap.js"></script>
<script src="vendor/bower-asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="vendor/bower-asset/jquery-validation/dist/additional-methods.min.js"></script>

<script type="text/javascript" src="vendor/bower-asset/jsgrid/dist/jsgrid.min.js"></script>

<script src=vendor/bower-asset/pace/pace.min.js></script>
<script src=js/waiting_modal.js></script>
<script src=js/sample.js></script>
</body>
</html>
