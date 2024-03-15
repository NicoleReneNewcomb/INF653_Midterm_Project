<?php
    class Author {

        // DB Parameters
        private $conn;
        private $table = 'authors';

        // Author Fields
        public $id;
        public $author;

        // Database Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Method read() to GET all Authors
        public function read() {

            // create SQL query
            $query = 'SELECT
                    p.id,
                    p.author
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

        // Method read_single() to GET single Author by ID
        public function read_single() {
            // create SQL query
            $query = 'SELECT
                    p.id,
                    p.author
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

            // set Author object properties
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->author = $row['author'];
            
            return $stmt;
        }

        // Method create() to POST new Author
        public function create() {

            // create SQL query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                (author)
                VALUES
                (:author)';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
           
            // bind data
            $stmt->bindParam(':author', $this->author);
            
            // execute query
            if ($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Method update() to PUT changes to Author
        public function update() {

            // create SQL query
            $query = 'UPDATE ' . 
                    $this->table . '
                SET
                    author = :author
                WHERE 
                    id =:id';
            
            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));
            
            // bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);
           
            // execute query
            if ($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Method delete() to DELETE Author by ID
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