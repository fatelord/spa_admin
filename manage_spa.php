<?php
session_start();
$token = md5(uniqid('mail_'));
$_SESSION['_csrf'] = $token;

//check if user is logged in
$logged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
$name = isset($_SESSION['username']) ? $_SESSION['username'] : false;
$application_name = 'SPA - User Admin';
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
<script src="vendor/bower-asset/jquery/dist/jquery.js"></script>
<script src="vendor/bower-asset/bootstrap/dist/js/bootstrap.js"></script>
<script src="vendor/bower-asset/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="vendor/bower-asset/jquery-validation/dist/additional-methods.min.js"></script>

<script type="text/javascript" src="vendor/bower-asset/jsgrid/dist/jsgrid.min.js"></script>

<script src=vendor/bower-asset/pace/pace.min.js></script>
<script src=js/waiting_modal.js></script>

<script type="text/javascript">
    $(document).ready(function () {
        'use strict';

        GetUploadedFiles();

        function GetUploadedFiles() {
            //get the json files
            var url = 'modules/fetch_spa_list.php';
            var $csrf = $('#_csrf').val();
            var controller = {
                loadData: function (filter) {
                    return $.ajax({
                        type: "GET",
                        url: "/clients/",
                        data: filter
                    });
                },
                insertItem: function (item) {
                    return $.ajax({
                        type: "POST",
                        url: "/clients/",
                        data: item
                    });
                },
                updateItem: function (item) {
                    return $.ajax({
                        type: "PUT",
                        url: "/clients/",
                        data: item
                    });
                },
                deleteItem: function (item) {
                    return $.ajax({
                        type: "DELETE",
                        url: "/clients/",
                        data: item
                    });
                }
            };
     
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _csrf: $csrf
                },
                success: function (data, resultText) {
                    $("#jsGrid").jsGrid({
                        width: "100%",
                        height: "auto",

                        heading: true,
                        filtering: false,
                        inserting: false,
                        //editing: false,
                        selecting: true,
                        //sorting: false,
                        paging: false,
                        pageLoading: true,

                        //filtering: true,
                        editing: true,
                        sorting: true,
                        //paging: true,
                        autoload: true,

                        pageSize: 15,
                        pageButtonCount: 5,

                        data: data,
                        fields: [
                            {name: "SPA_NAME", title: "Spa Name", type: "text", width: 150},
                            {name: "SPA_TEL", title: "Telephone", type: "number", align: "center", width: 50},
                            {name: "SPA_LOCATION", title: "Spa Location", type: "text", width: 150},
                            {name: "SPA_WEBSITE", title: "Spa Website", type: "text", width: 150},
                        ],
                        rowClick: function (args) {
                            console.log(args.item);
                            var selectedItem = args.item;
                            // save selected row
                            var $selectedRow = $(args.event.target).closest("tr");

                            // remove class for all rows
                            $("#jsGrid tr").removeClass("active-row");
                            // add class to highlight row
                            $selectedRow.addClass("active-row");
                            //add to the file name input
                            var filenameCount = selectedItem.uploaded_file + ' (' + selectedItem.contact_count + ')';
                            $('#filename').val(selectedItem.uploaded_file);
                            $('#selected-file').val(filenameCount);
                        },
                    });
                },
                dataType: 'json'
            });
        }
    });
</script>
</body>
</html>
