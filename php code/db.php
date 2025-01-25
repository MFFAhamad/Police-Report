<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'police_report';

    protected $conn;

    public function __construct() {
        if (!isset($this->conn)) {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

            if ($this->conn->connect_error) {
                die("Failed to connect to MySQL: " . $this->conn->connect_error);
            }
        }

        return $this->conn;
    }
    public function getConnection() {
        return $this->conn;
    }

    public function getReportStatus($reportId) {
        $stmt = $this->conn->prepare("SELECT status FROM report WHERE id = ?");
        $stmt->bind_param("i", $reportId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['status'];
        } else {
            return null;
        }
    }
    

    public function insertReport($id, $name, $nic, $address, $email, $idImagePath, $personImagePath) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO report (id, name, nic, address, email, id_image_path, id_back) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            // Error handling for preparation failure
            if ($stmt === false) {
                throw new Exception("Failed to prepare statement: " . $this->conn->error);
            }
    
            $bind = $stmt->bind_param("issssss", $id, $name, $nic, $address, $email, $idImagePath, $personImagePath);
            // Error handling for binding failure
            if ($bind === false) {
                throw new Exception("Failed to bind parameters: " . $stmt->error);
            }
    
            $execute = $stmt->execute();
            // Error handling for execution failure
            if ($execute === false) {
                throw new Exception("Failed to execute statement: " . $stmt->error);
            }
    
            $stmt->close();
            return true;
        } catch (Exception $e) {
            // Optionally log the error message $e->getMessage() to a log file or a database
            
            // You can also echo the error message if you want to see it on the screen (not recommended for production)
            echo "Error: " . $e->getMessage();
    
            if (isset($stmt) && $stmt instanceof mysqli_stmt) {
                $stmt->close();
            }
    
            return false;
        }
    }
    
}
?>
