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

class SALON_MODEL
{
	public $database;
	public $vanillaPassword;
	public $spa_table = 'salon';
	public $users_table = 'user';
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
		$this->vanillaPassword = new VanillaPassword();
		$this->date = date('Y/m/d H:i:s');
	}

	public function UpdateSpa($pk, $spa_arr)
	{
		$this->database->update($this->spa_table, $spa_arr, ['SALON_ID' => $pk]);
	}

	public function InsertSpa($spa_arr)
	{
		$this->database->insert($this->spa_table, $spa_arr);
	}

	public function DeleteSpa($pk)
	{
		$this->database->delete($this->spa_table, ['SALON_ID' => $pk]);
	}


	/**
	 * @param string $file_name
	 * @param bool   $deleted
	 * @return bool|\PDOStatement
	 */
	public function InsertUploadedFiles($file_name, $contact_count = 0, $deleted = false)
	{


		$result = $this->database->insert('uploaded_files', [
			'uploaded_file' => $file_name,
			'contact_count' => $contact_count,
			'deleted' => (int)$deleted,
			'date_uploaded' => $this->date//'NOW', //database value
		]);

		return $result;
	}

	public function FetchSpaList()
	{
		$data = $this->database->select($this->spa_table, [
			'SALON_ID',
			'SALON_NAME',
			'SALON_TEL',
			'SALON_LOCATION',
			'SALON_EMAIL',
			'SALON_WEBSITE',
			'SALON_MAP_COORD',
			'SALON_IMAGE',

		], [
			"ORDER" => ["SALON_ID" => "ASC"],
		]);
		return $data;
	}

	public function HashPassword($plain_pass)
	{
		$hashed = $this->vanillaPassword->hash($plain_pass);

		return $hashed;
	}

	public function IsValidPassword($plain_pass, $email_address)
	{
		//query the database
		$matched = false;
		$data = $this->database->select('user', 'PASSWORD', [
			'EMAIL' => $email_address,
			'ACCOUNT_TYPE' => 1, //1 for admin account type
			'ACCOUNT_STATUS' => 1 //1 indicates active account
		]);
		if (is_array($data)) {
			$stored_hash = $data[0];

			$matched = $this->vanillaPassword->verify($plain_pass, $stored_hash);
		}
		return $matched;
	}

	public function GetTimeStamp()
	{
		$date = new \DateTime();
		return $date->getTimestamp();
	}
}