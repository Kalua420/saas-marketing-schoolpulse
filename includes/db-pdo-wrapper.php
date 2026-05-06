<?php
/**
 * MySQLi-based PDO Wrapper
 * This provides PDO-like functionality using MySQLi
 * Use this temporarily until hosting enables PDO MySQL driver
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'schoolpu_saas');
define('DB_USER', 'schoolpu_saas');
define('DB_PASS', 'p9ePShkbJbYtHAvCHFTJ');
define('DB_CHARSET', 'utf8mb4');

// Create MySQLi connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    error_log("Database connection failed: " . $mysqli->connect_error);
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}

// Set charset
$mysqli->set_charset(DB_CHARSET);

// Create a PDO-like wrapper class
class PDOWrapper {
    private $mysqli;
    
    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }
    
    public function prepare($sql) {
        return new PDOStatementWrapper($this->mysqli, $sql);
    }
    
    public function query($sql) {
        $result = $this->mysqli->query($sql);
        if (!$result) {
            throw new Exception($this->mysqli->error);
        }
        return new PDOStatementWrapper($this->mysqli, $sql, $result);
    }
    
    public function lastInsertId() {
        return $this->mysqli->insert_id;
    }
    
    public function beginTransaction() {
        return $this->mysqli->begin_transaction();
    }
    
    public function commit() {
        return $this->mysqli->commit();
    }
    
    public function rollBack() {
        return $this->mysqli->rollback();
    }
}

class PDOStatementWrapper {
    private $mysqli;
    private $sql;
    private $stmt;
    private $result;
    private $params = [];
    
    public function __construct($mysqli, $sql, $result = null) {
        $this->mysqli = $mysqli;
        $this->sql = $sql;
        $this->result = $result;
        
        if ($result === null) {
            $this->stmt = $mysqli->prepare($sql);
            if (!$this->stmt) {
                throw new Exception($mysqli->error);
            }
        }
    }
    
    public function execute($params = []) {
        if (empty($params)) {
            $result = $this->stmt->execute();
            if (!$result) {
                throw new Exception($this->stmt->error);
            }
            $this->result = $this->stmt->get_result();
            return $result;
        }
        
        // Build type string
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        
        // Bind parameters
        $this->stmt->bind_param($types, ...$params);
        
        // Execute
        $result = $this->stmt->execute();
        if (!$result) {
            throw new Exception($this->stmt->error);
        }
        
        $this->result = $this->stmt->get_result();
        return $result;
    }
    
    public function fetch($mode = null) {
        if ($this->result === false) {
            return false;
        }
        return $this->result->fetch_assoc();
    }
    
    public function fetchAll($mode = null) {
        if ($this->result === false) {
            return [];
        }
        return $this->result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function fetchColumn($column = 0) {
        $row = $this->fetch();
        if ($row === false) {
            return false;
        }
        $values = array_values($row);
        return $values[$column] ?? false;
    }
    
    public function rowCount() {
        if ($this->stmt) {
            return $this->stmt->affected_rows;
        }
        if ($this->result) {
            return $this->result->num_rows;
        }
        return 0;
    }
}

// Create PDO-like object
$pdo = new PDOWrapper($mysqli);

// Define PDO constants if not defined
if (!defined('PDO::FETCH_ASSOC')) {
    define('PDO::FETCH_ASSOC', MYSQLI_ASSOC);
}
