<?php

include_once "./object/region.php";
include_once "./config/DBConfig.php";


$database = new Database();
$db = $database->connect();
if ($db) {
    echo "Kết nối database thành công";
} else {
    echo "Kết nối database thấy bại";
}
