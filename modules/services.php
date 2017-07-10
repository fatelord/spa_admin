<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'SERVICES_MODEL.php';
require_once 'SERVICE_CLASS.php';

switch ($_SERVER["REQUEST_METHOD"]) {
	case "GET":
		$result = \app\modules\SERVICE_CLASS::GET_SERVICES_LIST($_GET["salon_id"]);
		break;

	case "POST":
		$pk = isset($_POST['SERVICE_ID']) ? intval($_POST['SERVICE_ID']) : false;

		$data = [
			'SALON_ID' => intval($_POST['SALON_ID']),
			'SERVICE_NAME' => $_POST['SERVICE_NAME'],
			'SERVICE_COST' => $_POST['SERVICE_COST'],
		];

		if ($pk === false) {
			$result = \app\modules\SERVICE_CLASS::INSERT_SERVICE($data);
		} else {
			$result = \app\modules\SERVICE_CLASS::UPDATE_SERVICE($pk, $data);
		}
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();