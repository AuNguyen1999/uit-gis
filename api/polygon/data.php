<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once "../object/polygon.php";
include_once "../point/index.php";
include_once "../config/DBConfig.php";

$database = new Database();
$db = $database->connect();
$polygon = new Polygon($db);

if (isset($_GET['date'])) {
    $stmt = $polygon->readFoDate($_GET['date']);
    $num = $stmt->rowCount();
    if ($num > 0) {
        $polygon_arr = array(
            "type" => "FeatureCollection",
        );
        $polygon_arr['features'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $polygon_item = array(
                "type" => "Feature",
                "geometry" => (object)array("type" => "Polygon", "coordinates" => array(getPoP($db, $id))),
                "properties" => (object)array(
                    "name" => $name,
                    "state_name" => $region,
                    "area" => $area,
                    "population" => $population,

                    "date" => $date,
                    "confirmed" => $confirmed,
                    "deaths" => $deaths,
                    "recovered" => $recovered,
                    "active" => $active,

                    "confirmed_area" => $confirmed / $area,
                    "deaths_area" => $deaths / $area,
                    "recovered_area" => $recovered / $area,
                    "active_area" => $active / $area,

                ),
                'id' => $id,
            );
            array_push($polygon_arr['features'], $polygon_item);
        }
        http_response_code(200);
        echo  json_encode($polygon_arr, JSON_NUMERIC_CHECK);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No polygon found.")
        );
    }
} else {
    $stmt = $polygon->read();
    $num = $stmt->rowCount();
    if ($num > 0) {
        $polygon_arr = array(
            "type" => "FeatureCollection",
        );
        $polygon_arr['features'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $polygon_item = array(
                "type" => "Feature",
                "geometry" => (object)array("type" => "Polygon", "coordinates" => array(getPoP($db, $id))),
                "properties" => (object)array(
                    "name" => $name,
                    "state_name" => $region,
                    "area" => $area,
                    "population" => $population,
                ),
                'id' => $id,
            );
            array_push($polygon_arr['features'], $polygon_item);
        }
        http_response_code(200);
        echo  json_encode($polygon_arr, JSON_NUMERIC_CHECK);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No polygon found.")
        );
    }
}