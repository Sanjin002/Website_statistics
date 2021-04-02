<?php
/**
 * Headers
 */
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Tool.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();


  $tool = new Tool($db);


  $data = json_decode(file_get_contents("php://input"));

  /**
   * Set ID to UPDATE
   */
  $tool->id = $data->id;

  $tool->name = $data->name;

  /**
   * Update statistics
   */
  if($tool->update()) {
    echo json_encode(
      array('message' => 'Tool Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Tool not updated')
    );
  }
