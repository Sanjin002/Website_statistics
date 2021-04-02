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


$result = $statistics->read();
/**
 * Get row count
 */
$num = $result->rowCount();

/**
 * Check if any statistics
 */
if ($num > 0) {
    // Statistics array
    $statistics_arr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $statistics_item = array(
            'id' => $id,
            'sessions' => $sessions,
            'browsers' => $browsers,
            'users' => $users,
            'tool_id' => $tool_id,
            'tool_name' => $tool_name
        );

        /**
         * Push to "data"
         */
        array_push($statistics_arr, $statistics_item);

    }

    /**
     * Turn to JSON & output
     */
    echo json_encode($statistics_arr);

} else {
    /**
     * If there is no Statistics
     */
    echo json_encode(
        array('message' => 'No Statistics Found')
    );
}
