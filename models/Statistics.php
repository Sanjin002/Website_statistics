<?php 
  class Statistics {

    private $conn;
    private $table = 'statistics';

    // Statistics Properties
    public $id;
    public $tool_id;
    public $tool_name;
    public $sessions;
    public $browsers;
    public $users;
    public $created_at;

    // Constructor with database
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Statistics
    public function read() {
      // Create query
      $query = 'SELECT t.name as tool_name, s.id, s.tool_id, s.sessions, s.browsers, s.users, s.created_at
                                FROM ' . $this->table . ' s
                                LEFT JOIN
                                  tools t ON s.tool_id = t.id
                                ORDER BY
                                  s.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Statistics
    public function read_single() {
          // Create query
          $query = 'SELECT t.name as tool_name, s.id, s.tool_id, s.sessions, s.browsers, s.users, s.created_at
                                    FROM ' . $this->table . ' s
                                    LEFT JOIN
                                      tools t ON s.tool_id = t.id
                                    WHERE
                                      s.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->sessions = $row['sessions'];
          $this->browsers = $row['browsers'];
          $this->users = $row['users'];
          $this->tool_id = $row['tool_id'];
          $this->tool_name = $row['tool_name'];
    }

    // Create Statistics
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET sessions = :sessions, browsers = :browsers, users = :users, tool_id = :tool_id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->sessions = htmlspecialchars(strip_tags($this->sessions));
          $this->browsers = htmlspecialchars(strip_tags($this->browsers));
          $this->users = htmlspecialchars(strip_tags($this->users));
          $this->tool_id = htmlspecialchars(strip_tags($this->tool_id));

          // Bind data
          $stmt->bindParam(':sessions', $this->sessions);
          $stmt->bindParam(':browsers', $this->browsers);
          $stmt->bindParam(':users', $this->users);
          $stmt->bindParam(':tool_id', $this->tool_id);

          // Execute query
          if($stmt->execute()) {
            return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Statistics
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET sessions = :sessions, browsers = :browsers, users = :users, tool_id = :tool_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->sessions = htmlspecialchars(strip_tags($this->sessions));
          $this->browsers = htmlspecialchars(strip_tags($this->browsers));
          $this->users = htmlspecialchars(strip_tags($this->users));
          $this->tool_id = htmlspecialchars(strip_tags($this->tool_id));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':sessions', $this->sessions);
          $stmt->bindParam(':browsers', $this->browsers);
          $stmt->bindParam(':users', $this->users);
          $stmt->bindParam(':tool_id', $this->tool_id);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Statistics
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }