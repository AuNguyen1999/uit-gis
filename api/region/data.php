<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once "../object/region.php";
include_once "../config/DBConfig.php";
include_once "../polygon/readData.php";

$database = new Database();
$db = $database->connect();
$region = new Region($db);


if (isset($_GET['date'])) {
    $date = $_GET['date'];
    $stmt = $region->readFoDateRegion($date);
    $num = $stmt->rowCount();
    if ($num > 0) {
        $region_arr = array("type" => "FeatureCollection",);
        $region_arr["features"] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $region_item = array(
                "type" => "Feature",
                "properties" => (object)array(
                    "name" => $name,
                    "area" => $area,
                    "population" => $population,
                    "confirmed" => $confirmed,
                    "recovered" => $recovered,
                    "deaths" => $deaths,
                    "active" => $active,
                    "date" => $date
                ),
                "id" => $id,
                "geometry" => (object)array(
                    "type" => "MultiPolygon",
                    "coordinates" => getForRid($id)
                )
            );
            array_push($region_arr["features"], $region_item);
        }
        http_response_code(200);
        echo json_encode($region_arr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No regions found.")
        );
    }
} else {
    $stmt = $region->read();
    $num = $stmt->rowCount();
    if ($num > 0) {
        $region_arr = array("type" => "FeatureCollection",);
        $region_arr["features"] = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);


            $region_item = array(
                "type" => "Feature",
                "properties" => (object)array(
                    "name" => $name,
                    "population" => $population,
                    "area" => $area,

                ),
                "id" => $id,
                "geometry" => (object)array(
                    "type" => "MultiPolygon",
                    "coordinates" => getForRid($id)
                )
            );
            array_push($region_arr["features"], $region_item);
        }
        http_response_code(200);
        echo json_encode($region_arr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No regions found.")
        );
    }
}