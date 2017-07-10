<?php
namespace app\modules;
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
	public static function UPDATE_SERVICE($pk, $service_arr)
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