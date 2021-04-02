<?php
/**
 * Headers
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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

/**
 * Set ID to update
 */
$statistics->id = $data->id;

$statistics->sessions = $data->sessions;
$statistics->browsers = $data->browsers;
$statistics->users = $data->users;
$statistics->tool_id = $data->tool_id;

/**
 * Update statistics
 */
if ($statistics->update()) {
    echo json_encode(
        array('message' => 'Statistics Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Statistics Not Updated')
    );
}

