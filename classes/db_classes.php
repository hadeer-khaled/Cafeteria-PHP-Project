<?php

require_once '../env.php';
require_once '../base.php';
class Database {

    private static $instance;
    private $connection;

    private function __construct() 
    {

    }
    public function prepare($query) {
        return $this->connection->prepare($query);
    }
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }

    public static function getInstance() 
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect($host, $username, $password, $database) 
    {
        try {
            $dsn = "mysql:host=$host;dbname=$database";
            $this->connection = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    public function insert($table, $columns, $values) {
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        $statement = $this->connection->prepare($query);

        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error inserting record: " . $e->getMessage();
            return false;
        }
    }

    public function select($table) {
        $query = "SELECT * FROM $table";
        $statement = $this->connection->prepare($query);

        try {
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result;
            } 
            else {
                return 0;
            }
        } catch (PDOException $e) {
            echo "Error selecting records: " . $e->getMessage();
        }
    }

    public function update($table, $id, $fields) {
        $query = "UPDATE $table SET $fields WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        var_dump($statement);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
            return false;
        }
    }

    public function delete($table, $id) {
        $query = "DELETE FROM $table WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
            return false;
        }
    }
    public function selectById($table, $id) {
        $query = "SELECT * FROM $table WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
    
        try {
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result;
            } else {
                echo "No record found with id $id in table $table.";
            }
        } catch (PDOException $e) {
            echo "Error selecting record by id: " . $e->getMessage();
        }
    }
    public function selectUserByEmail( $email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_INT);
    
        try {
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result;
            } else {
                echo "No record found with email $email in users table.";
            }
        } catch (PDOException $e) {
            echo "Error selecting record by id: " . $e->getMessage();
        }
    }
    
    public function searchResetToken($token) {
        // Prepare and execute SQL statement to search for the token in the database
        $sql = "SELECT * FROM reset_tokens WHERE token = ?";
        $params = array($token);
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);
        
        // Fetch the result as an associative array
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    
        return $result; // Return the token information if found, or null if not found
    }
    
    
    function updatePassword($email, $new_password) {
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $params = array($new_password, $email);
        $statement = $this->connection->prepare($sql);
        $statement->execute($params); 
        
        return $statement; // Return true if the password is updated successfully, or false if not
    }
    
    function addResetToken($email, $token) {
        $sql = "INSERT INTO reset_tokens (email, token, expiration_timestamp) VALUES (?, ?, ?)";
        // 5 minutes token expiration
        $expiration_timestamp = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $params = array($email, $token, $expiration_timestamp);
        $statement = $this->connection->prepare($sql);
        $statement->execute($params); 
        return $statement;

    }
    public function getOrdersByCriteria($start_date = null, $end_date = null, $user_id = null) {
        $sql = "SELECT o.id AS order_id, o.order_date, o.total_amount, o.notes, u.username, o.status
                FROM orders o
                INNER JOIN users u ON o.user_id = u.id";
    
        if (!empty($start_date) && !empty($end_date)) {
            $sql .= " WHERE o.order_date BETWEEN :start_date AND :end_date ";
            if (!empty($user_id)) {
                $sql .= " AND o.user_id = :user_id";
            }
        } elseif (!empty($user_id)) {
            $sql .= " WHERE o.user_id = :user_id";
        }
    
        $statement = $this->connection->prepare($sql);
    
        if (!empty($start_date) && !empty($end_date)) {
            $statement->bindParam(':start_date', $start_date);
            $statement->bindParam(':end_date', $end_date);
        }
        if (!empty($user_id)) {
            $statement->bindParam(':user_id', $user_id);
        }
    
        $statement->execute();
    
        $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        return $orders;
    }

    public function selectOrderItemsByOrderId($order_id) {
        $query = "SELECT * FROM order_items WHERE order_id = :order_id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    
        try {
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error selecting order items: " . $e->getMessage();
            return false;
        }
    }

    public function __destruct() {
        $this->connection = null;
    }

}

$database = Database::getInstance();

$database->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

// $database->select(DB_TABLE);

// $database->insert("users","username,password,email,room_id,role", "'Hala','123','Hala@gmail.com','1' ,'user'");


// $database->update(DB_TABLE,7,"name='hamada',password='1234',room_number='Cloud'");

// $database->delete(DB_TABLE,7);

// $database->findOneUser('omarkhalil117@gmail.com','123');
?>