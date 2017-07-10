<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'SALON_CLASS.php';

$method = $_SERVER["REQUEST_METHOD"];
switch ($method) {
	case "GET":
		$result = \app\modules\SALON_CLASS::GET_SALON_LIST(array(//"SALON_NAME" => $_GET["SALON_NAME"],
		));
		break;
	case "POST":
		$pk = intval($_POST['SALON_ID']);
		$result = \app\modules\SALON_CLASS::DELETE_SPA($pk);
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();