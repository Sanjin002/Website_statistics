<?php
/**
 * Headers
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Statistics.php';

/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();


$statistics = new Statistics($db);


$data = json_decode(file_get_contents("php://input"));

$statistics->sessions = $data->sessions;
$statistics->browsers = $data->browsers;
$statistics->users = $data->users;
$statistics->tool_id = $data->tool_id;

/**
 * Create statistics
 */
if ($statistics->create()) {
    echo json_encode(
        array('message' => 'Statistics Created')
    );
} else {
    echo json_encode(
        array('message' => 'Statistics Not Created')
    );
}

