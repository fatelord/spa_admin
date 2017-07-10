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
		$pk = isset($_POST['SALON_ID']) ? intval($_POST['SALON_ID']) : false;

		$data = [
			'SALON_NAME' => $_POST['SALON_NAME'],
			'SALON_TEL' => $_POST['SALON_TEL'],
			'SALON_LOCATION' => $_POST['SALON_LOCATION'],
			'SALON_EMAIL' => $_POST['SALON_EMAIL'],
			'SALON_WEBSITE' => $_POST['SALON_WEBSITE'],
			'SALON_MAP_COORD' => $_POST['SALON_MAP_COORD'],
			'SALON_IMAGE' => $_POST['SALON_IMAGE'],
		];
		if ($pk === false) {
			$result = \app\modules\SALON_CLASS::INSERT_SPA($data);
		} else {
			$result = \app\modules\SALON_CLASS::UPDATE_SPA($pk, $data);
		}
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();