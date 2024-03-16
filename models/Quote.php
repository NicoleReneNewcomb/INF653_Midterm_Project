<?php
    class Quote {

        // DB Parameters
        private $conn;
        private $table = 'quotes';

        // Quote Fields
        public $id;
        public $quote;
        public $author;
        public $category;
        public $author_id;
        public $category_id;

        // Database Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Method read() to GET all Quotes
        public function read() {

            // create SQL query
            $query = 'SELECT
                    q.id,
                    q.quote,
                    a.author as author,
                    c.category as category
                FROM '
                    . $this->table . ' q
                LEFT JOIN authors a ON q.author_id = a.id
                LEFT JOIN categories c ON q.category_id = c.id
                ORDER BY
                    q.id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Method read_single() to GET single Quote by ID
        public function read_single() {
            // create SQL query
            $query = 'SELECT
                    q.id,
                    q.quote,
                    a.author as author,
                    c.category as category
                FROM '
                    . $this->table . ' q
                LEFT JOIN authors a ON q.author_id = a.id
                LEFT JOIN categories c ON q.category_id = c.id
                WHERE
                    q.id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            // set Quote object properties
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $this->quote = $row['quote'];
                $this->author = $row['author'];
                $this->category = $row['category'];
            } else {
                $this->quote = null;
            }
            
            return $stmt;
        }

        // Method create() to POST new Quote
        public function create() {

            // create SQL query
            $query = 'INSERT INTO ' . 
                    $this->table . '
                (quote, author_id, category_id)
                VALUES
                (:quote, :author_id, :category_id)';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
           
            // bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
            
            // execute query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Method update() to PUT changes to Quote
        public function update() {

            // create SQL query
            $query = 'UPDATE ' . 
                    $this->table . '
                SET
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                WHERE 
                    id =:id';
            
            // prepare statement
            $stmt = $this->conn->prepare($query);

            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            
            // bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);
           
            // execute query
            if ($stmt->execute()) {
                return true;
            }

            // print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Method delete() to DELETE Quote by ID
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

        // Method to check if an author exists by their ID
        public function authorExists($author_id) {

            // create SQL query
            $query = 'SELECT * FROM authors WHERE id = ?';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // bind id
            $stmt->bindParam(1, $author_id);

            // execute query
            $stmt->execute();

            // return true if author exists and false otherwise
            return $stmt->rowCount() > 0;
        }

        // Method to check if a category exists by their ID
        public function categoryExists($category_id) {

            // create SQL query
            $query = 'SELECT * FROM categories WHERE id = ?';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // bind id
            $stmt->bindParam(1, $category_id);

            // execute query
            $stmt->execute();

            // return true if category exists and false otherwise
            return $stmt->rowCount() > 0;
        }

        public function idExists($id) {

            // create SQL query
            $query = 'SELECT * FROM quotes WHERE id = ?';

            // prepare statement
            $stmt = $this->conn->prepare($query);

            // bind id
            $stmt->bindParam(1, $id);

            // execute query
            $stmt->execute();

            // return true if category exists and false otherwise
            return $stmt->rowCount() > 0;
        }
    }