<?php
require_once 'SPA_MODEL.php';


switch ($_SERVER["REQUEST_METHOD"]) {
	case "GET":
		$result = SPA_CLASS::GET_SPA_LIST(array(//"SPA_NAME" => $_GET["SPA_NAME"],
		));
		break;

	case "POST":
		$result = SPA_CLASS::INSERT_SERVICE([
			//'SPA_ID' => intval($_POST['SPA_ID']),
			'SPA_NAME' => $_POST['SPA_NAME'],
			'SPA_TEL' => $_POST['SPA_TEL'],
			'SPA_LOCATION' => $_POST['SPA_LOCATION'],
			'SPA_EMAIL' => $_POST['SPA_EMAIL'],
			'SPA_WEBSITE' => $_POST['SPA_WEBSITE'],
			'SPA_MAP_COORD' => $_POST['SPA_MAP_COORD'],
			'SPA_IMAGE' => $_POST['SPA_IMAGE'],
		]);
		break;

	case "PUT":
		parse_str(file_get_contents("php://input"), $_PUT);
		$pk = intval($_PUT['SPA_ID']);

		$result = SPA_CLASS::UPDATE_SPA($pk, [
			'SPA_NAME' => $_PUT['SPA_NAME'],
			'SPA_TEL' => $_PUT['SPA_TEL'],
			'SPA_LOCATION' => $_PUT['SPA_LOCATION'],
			'SPA_EMAIL' => $_PUT['SPA_EMAIL'],
			'SPA_WEBSITE' => $_PUT['SPA_WEBSITE'],
			'SPA_MAP_COORD' => $_PUT['SPA_MAP_COORD'],
			'SPA_IMAGE' => $_PUT['SPA_IMAGE'],
		]);
		break;

	case "DELETE":
		parse_str(file_get_contents("php://input"), $_DELETE);
		$pk = intval($_DELETE['SPA_ID']);
		$result = SPA_CLASS::DELETE_SPA($pk);
		break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();

class SPA_CLASS
{

	/**
	 * @param $filter
	 * @return array|bool
	 */
	public static function GET_SPA_LIST($filter)
	{
		$model = new \app\modules\SPA_MODEL();
		$data = $model->FetchSpaList();
		return $data;//json_encode($data);
	}

	/**
	 * @param $spa_arr
	 */
	public static function INSERT_SPA($spa_arr)
	{
		$model = new \app\modules\SPA_MODEL();
		$model->InsertSpa($spa_arr);
	}

	/**
	 * @param $pk
	 * @param $spa_arr
	 */
	public static function UPDATE_SPA($pk, $spa_arr)
	{
		$model = new \app\modules\SPA_MODEL();
		$model->UpdateSpa($pk, $spa_arr);
	}

	public static function DELETE_SPA($pk)
	{
		$model = new \app\modules\SPA_MODEL();
		$model->DeleteSpa($pk);
	}
}