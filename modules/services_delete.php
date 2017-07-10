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
		$pk = intval($_POST['SERVICE_ID']);
		$result = \app\modules\SERVICE_CLASS::DELETE_SPA($pk);
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();