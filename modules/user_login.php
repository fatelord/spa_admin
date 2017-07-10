<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'SALON_MODEL.php';

$token = isset($_SESSION['_csrf']) ? $_SESSION['_csrf'] : null;
unset($_SESSION['_csrf']);

$model = new \app\modules\SALON_MODEL();

if ($token && $_POST['_csrf'] == $token) {
    $email_address = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $resp = $model->IsValidPassword($password, $email_address);
    if ($resp) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $email_address;
        unset($_SESSION['message']); //clear the message session
        header("Location: ../manage_spa.php");
        exit();
    } else {
        $_SESSION['message'] = 'Invalid username/password please try again';
    }

}
header("Location: ../index.php");
exit();