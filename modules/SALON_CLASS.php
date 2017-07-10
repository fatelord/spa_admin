<?php
namespace app\modules;
require_once 'SALON_MODEL.php';

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