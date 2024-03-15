<?php
    class Category {

        // DB Parameters
        private $conn;
        private $table = 'categories';

        // Category Fields
        public $id;
        public $category;

        // Database Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Method read() to GET all Categorys
        public function read() {

            // create SQL query
            $query = 'SELECT
                    p.id,
                    p.category
                FROM '
                    . $this->table . ' p
                ORDER BY
                    p.id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Method read_single() to GET single Category by ID
        public function read_single() {
            // create SQL query
            $query = 'SELECT
                    p.id,
                    p.category
                FROM '
                    . $this->table . ' p
                WHERE
                    p.id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            // set Category object properties
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $this->category = $row['category'];
            } else {
                $this->category = null;
            }
            
            return $stmt;
        }

        // Method create() to POST new Category
        public function create() {

            // create SQL query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                (category)
                VALUES
                (:category)';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
           
            // bind data
            $stmt->bindParam(':category', $this->category);
            
            // execute query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Method update() to PUT changes to Category
        public function update() {

            // create SQL query
            $query = 'UPDATE ' . 
                    $this->table . '
                SET
                    category = :category
                WHERE 
                    id =:id';
            
            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));
            
            // bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);
           
            // execute query
            if ($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Method delete() to DELETE Category by ID
        public function delete() {

            // create SQL query
            $query = 
                'DELETE FROM ' .
                    $this->table . '
                WHERE
                    id = :id';
            
            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // bind ID
            $stmt->bindParam(':id', $this->id);

            // execute query
            if ($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }
    }