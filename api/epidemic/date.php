<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once "../object/epidemic.php";
include_once "../config/DBConfig.php";

$database = new Database();
$db = $database->connect();
$epidemic = new Epidemic($db);
$stmt = $epidemic->getAllDate();
$num = $stmt->rowCount();



if ($num > 0) {
    $date_arr = array();
    $date_arr['data'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        array_push($date_arr['data'], $date);
    }
    http_response_code(200);
    echo  json_encode($date_arr, JSON_NUMERIC_CHECK);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No epidemic found.")
    );
}
