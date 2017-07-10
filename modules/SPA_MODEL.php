<?php
/**
 * Created by PhpStorm.
 * User: barsa
 * Date: 08-May-17
 * Time: 15:12
 */

namespace app\modules;

require_once '../config.php';
require_once '../vendor/autoload.php';

use Garden\Password\VanillaPassword;
use Medoo\Medoo;

class SPA_MODEL
{
    public $database;
    public $vanillaPassword;
    public $spa_table = 'spa';
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

    public function InsertToContactsTable($recipient, $recipient_name, $timestamp, $status)
    {

        // $database->debug();
        $this->database->insert($this->messages_table, [
            "recipient_name" => $recipient_name,
            "recipient_email" => $recipient,
            "sent" => $status,
            "timestamp" => $timestamp,
            '#date_sent' => 'NOW()' //database value
        ]);
    }

    public function QueueMessages($recipient, $timestamp)
    {
        $this->database->insert($this->messages_queue_table, [
            "recipient_email" => $recipient,
            "sent" => 0,
            "timestamp" => $timestamp,
            '#date_sent' => 'NOW()' //database value
        ]);
    }

    /**
     * @param $file_name
     * @param bool $deleted
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
            'SPA_ID',
            'SPA_NAME',
            'SPA_TEL',
            'SPA_LOCATION',
            'SPA_EMAIL',
            'SPA_WEBSITE',
            'SPA_MAP_COORD',
            'SPA_IMAGE',

        ], [
            "ORDER" => ["SPA_NAME" => "ASC"],
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
        $data = $this->database->select('user', 'PASSWORD', [
            'EMAIL' => $email_address,
            'ACCOUNT_TYPE' => 1, //1 for admin account type
            'ACCOUNT_STATUS' => 1 //1 indicates active account
        ]);

        $stored_hash = $data[0];

        $matched = $this->vanillaPassword->verify($plain_pass, $stored_hash);

        return $matched;
    }

    public function GetTimeStamp()
    {
        $date = new \DateTime();
        return $date->getTimestamp();
    }
}