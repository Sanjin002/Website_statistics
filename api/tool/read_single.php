<?php

/**
 * Headers
 */
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Tool.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog Tool object
  $tool = new Tool($db);

  /**
   * Get ID
   */
  $tool->id = isset($_GET['id']) ? $_GET['id'] : die();

  /**
   * Get statistic
   */
  $tool->read_single();

  /**
   * Create array
   */
  $tool_arr = array(
    'id' => $tool->id,
    'name' => $tool->name
  );

  /**
   * Create JSON
   */
  print_r(json_encode($tool_arr));
