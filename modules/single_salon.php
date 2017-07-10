<?php
require_once 'SALON_MODEL.php';

$salon_id = $_GET['salon_id'];
$salon = new \app\modules\SALON_MODEL();

$data_raw = $salon->FetchSalonName($salon_id);
$data = [];
foreach ($data_raw as $key => $value) {
	$data = $value;
}
print_r(json_encode($data));