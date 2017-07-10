<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'SALON_MODEL.php';


switch ($_SERVER["REQUEST_METHOD"]) {
	case "GET":
		$result = SALON_CLASS::GET_SALON_LIST(array(//"SALON_NAME" => $_GET["SALON_NAME"],
		));
		break;

	case "POST":
		$result = SALON_CLASS::INSERT_SPA([
			//'SALON_ID' => intval($_POST['SALON_ID']),
			'SALON_NAME' => $_POST['SALON_NAME'],
			'SALON_TEL' => $_POST['SALON_TEL'],
			'SALON_LOCATION' => $_POST['SALON_LOCATION'],
			'SALON_EMAIL' => $_POST['SALON_EMAIL'],
			'SALON_WEBSITE' => $_POST['SALON_WEBSITE'],
			'SALON_MAP_COORD' => $_POST['SALON_MAP_COORD'],
			'SALON_IMAGE' => $_POST['SALON_IMAGE'],
		]);
		break;

	case "PUT":
		parse_str(file_get_contents("php://input"), $_PUT);
		$pk = intval($_PUT['SALON_ID']);

		$result = SALON_CLASS::UPDATE_SPA($pk, [
			'SALON_NAME' => $_PUT['SALON_NAME'],
			'SALON_TEL' => $_PUT['SALON_TEL'],
			'SALON_LOCATION' => $_PUT['SALON_LOCATION'],
			'SALON_EMAIL' => $_PUT['SALON_EMAIL'],
			'SALON_WEBSITE' => $_PUT['SALON_WEBSITE'],
			'SALON_MAP_COORD' => $_PUT['SALON_MAP_COORD'],
			'SALON_IMAGE' => $_PUT['SALON_IMAGE'],
		]);
		break;

	case "DELETE":
		parse_str(file_get_contents("php://input"), $_DELETE);
		$pk = intval($_DELETE['SALON_ID']);
		$result = SALON_CLASS::DELETE_SPA($pk);
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();

class SALON_CLASS
{

	/**
	 * @param $filter
	 * @return array|bool
	 */
	public static function GET_SALON_LIST($filter)
	{
		$model = new \app\modules\SALON_MODEL();
		$data = $model->FetchSpaList();
		return $data;//json_encode($data);
	}

	/**
	 * @param $spa_arr
	 */
	public static function INSERT_SPA($spa_arr)
	{
		$model = new \app\modules\SALON_MODEL();
		$model->InsertSpa($spa_arr);
	}

	/**
	 * @param $pk
	 * @param $spa_arr
	 */
	public static function UPDATE_SPA($pk, $spa_arr)
	{
		$model = new \app\modules\SALON_MODEL();
		$model->UpdateSpa($pk, $spa_arr);
	}

	public static function DELETE_SPA($pk)
	{
		$model = new \app\modules\SALON_MODEL();
		$model->DeleteSpa($pk);
	}
}