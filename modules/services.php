<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'SERVICES_MODEL.php';


switch ($_SERVER["REQUEST_METHOD"]) {
	case "GET":
		$result = SERVICE_CLASS::GET_SERVICES_LIST($_GET["salon_id"]);
		break;

	case "POST":
		$result = SERVICE_CLASS::INSERT_SERVICE([
			'SALON_ID' => intval($_POST['SALON_ID']),
			'SERVICE_NAME' => $_POST['SERVICE_NAME'],
			'SERVICE_COST' => $_POST['SERVICE_COST'],
		]);
		break;

	case "PUT":
		parse_str(file_get_contents("php://input"), $_PUT);
		$pk = intval($_PUT['SERVICE_ID']);

		$result = SERVICE_CLASS::UPDATE_SPA($pk, [
			//'SALON_ID' => intval($_PUT['SALON_ID']),
			'SERVICE_NAME' => $_PUT['SERVICE_NAME'],
			'SERVICE_COST' => $_PUT['SERVICE_COST'],
		]);
		break;

	case "DELETE":
		parse_str(file_get_contents("php://input"), $_DELETE);
		$pk = intval($_DELETE['SERVICE_ID']);
		$result = SERVICE_CLASS::DELETE_SPA($pk);
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();

class SERVICE_CLASS
{


	/**
	 * @param $spa_id
	 * @return array|bool
	 */
	public static function GET_SERVICES_LIST($spa_id)
	{
		$model = new \app\modules\SERVICES_MODEL();
		$data = $model->FetchServiceList($spa_id);
		return $data;//json_encode($data);
	}

	/**
	 * @param $service_arr
	 */
	public static function INSERT_SERVICE($service_arr)
	{
		$model = new \app\modules\SERVICES_MODEL();
		$model->InsertService($service_arr);
	}

	/**
	 * @param $pk
	 * @param $service_arr
	 */
	public static function UPDATE_SPA($pk, $service_arr)
	{
		$model = new \app\modules\SERVICES_MODEL();
		$model->UpdateService($pk, $service_arr);
	}

	/**
	 * @param $pk
	 */
	public static function DELETE_SPA($pk)
	{
		$model = new \app\modules\SERVICES_MODEL();
		$model->DeleteService($pk);
	}
}