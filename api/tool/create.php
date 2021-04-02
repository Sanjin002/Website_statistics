<?php
/**
 * Headers
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Tool.php';
/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();


$tool = new Tool($db);


$data = json_decode(file_get_contents("php://input"));

$tool->name = $data->name;

/**
 * Create Tool
 */
if ($tool->create()) {
    echo json_encode(
        array('message' => 'Tool Created')
    );
} else {
    echo json_encode(
        array('message' => 'Tool Not Created')
    );
}
