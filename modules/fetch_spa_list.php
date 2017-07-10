<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$token = isset($_SESSION['_csrf']) ? $_SESSION['_csrf'] : null;
//unset($_SESSION['_csrf']);

require_once 'SPA_MODEL.php';

$resp = ['success' => false];
if ($token && $_POST['_csrf'] == $token) {
//lets process the files and fetch using ajax
    $resp = GET_FILES::getFiles();
}

print_r(json_encode($resp));
exit();


class GET_FILES
{

    public static function getFiles()
    {
        $model = new \app\modules\SPA_MODEL();

        $data = $model->FetchSpaList();
        return $data;//json_encode($data);
    }
}