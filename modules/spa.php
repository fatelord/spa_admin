<?php
require_once 'SPA_MODEL.php';

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $result = SPA_CLASS::GET_SPA_LIST(array(
            //"SPA_NAME" => $_GET["SPA_NAME"],
        ));
        break;

    case "POST":
        $result = $clients->insert(array(
            "name" => $_POST["name"],
            "age" => intval($_POST["age"]),
            "address" => $_POST["address"],
            "married" => $_POST["married"] === "true" ? 1 : 0,
            "country_id" => intval($_POST["country_id"])
        ));
        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $result = $clients->update(array(
            "id" => intval($_PUT["id"]),
            "name" => $_PUT["name"],
            "age" => intval($_PUT["age"]),
            "address" => $_PUT["address"],
            "married" => $_PUT["married"] === "true" ? 1 : 0,
            "country_id" => intval($_PUT["country_id"])
        ));
        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);

        $result = $clients->remove(intval($_DELETE["id"]));
        break;
}

header("Content-Type: application/json");
print_r(json_encode($result));
exit();
class SPA_CLASS
{

    public static function GET_SPA_LIST($filter)
    {
        $model = new \app\modules\SPA_MODEL();

        $data = $model->FetchSpaList();
        return $data;//json_encode($data);
    }
}