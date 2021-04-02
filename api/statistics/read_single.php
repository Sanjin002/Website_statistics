<?php
/**
 * Headers
 */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Statistics.php';

/**
 * Instantiate DB & connect
 */
$database = new Database();
$db = $database->connect();


$statistics = new Statistics($db);

/**
 * Get ID
 */
$statistics->id = isset($_GET['id']) ? $_GET['id'] : die();

/**
 * Get statistics
 */
$statistics->read_single();

/**
 * Create array
 */
$statistics_arr = array(
    'id' => $statistics->id,
    'sessions' => $statistics->sessions,
    'browsers' => $statistics->browsers,
    'users' => $statistics->users,
    'tool_id' => $statistics->tool_id,
    'tool_name' => $statistics->tool_name
);

/**
 * Create JSON
 */
print_r(json_encode($statistics_arr));