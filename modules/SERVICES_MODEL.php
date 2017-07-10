<?php
/**
 * Created by PhpStorm.
 * User: barsa
 * Date: 08-May-17
 * Time: 15:12
 */

namespace app\modules;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../config.php';
require_once '../vendor/autoload.php';

use Garden\Password\VanillaPassword;
use Medoo\Medoo;

class SERVICES_MODEL
{
	public $database;
	public $spa_services_table = 'services';
	public $spa_table = 'salon';
	public $spa_services_view = 'salon_service';
	public $date;

	function __construct($debug = false)
	{
		$this->database = new Medoo([
			'database_type' => DB_TYPE,
			'database_name' => DB_SCHEMA,
			'server' => DB_HOST,
			'port' => DB_PORT,
			'username' => DB_USER,
			'password' => DB_PASS,
			'charset' => DB_CHAR,
			'command' => 'SET SQL_MODE=ANSI_QUOTES'
		]);

		if ($debug) {
			$this->database->debug();
		}
		$this->date = date('Y/m/d H:i:s');
	}

	public function UpdateService($pk, $service_arr)
	{
		$this->database->update($this->spa_services_table, $service_arr, ['SERVICE_ID' => $pk]);
	}

	public function InsertService($service_arr)
	{
		$this->database->insert($this->spa_services_table, $service_arr);
	}

	public function DeleteService($pk)
	{
		$this->database->delete($this->spa_services_table, ['SERVICE_ID' => $pk]);
	}


	public function FetchServiceList($salon_id)
	{
		//$this->database->debug();
		/*$data = $this->database->select($this->spa_services_table, [
			'SERVICE_ID',
			'SALON_ID',
			'SALON_NAME',
			'SERVICE_NAME',
			'SERVICE_COST'
		], [
			'SALON_ID' => $salon_id
		], [
			"ORDER" => ["SERVICE_ID" => "ASC"],
		]);*/
		$data = $this->database->select($this->spa_services_table, [
			"[>]salon" => ["SALON_ID" => "SALON_ID"],

		], [
			$this->spa_table . '.SALON_NAME',
			$this->spa_services_table . '.SERVICE_ID[Number]',
			$this->spa_services_table . '.SALON_ID[Number]',
			$this->spa_services_table . '.SERVICE_NAME',
			$this->spa_services_table . '.SERVICE_COST[Number]'
		], [
			$this->spa_services_table . '.SALON_ID' => $salon_id
		]);

		return $data;
	}

	public function GetTimeStamp()
	{
		$date = new \DateTime();
		return $date->getTimestamp();
	}
}