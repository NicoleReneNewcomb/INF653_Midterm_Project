<?php
    class Database {

        // DB Parameters
        private $host;
        private $port;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        // Gets environment variables
        public function __construct() {
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
            $this->dbname = getenv('DBNAME');
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
        }

        // DB Connection Method
        public function connect() {
            if ($this->conn) {
                return $this->conn;
            }
            else {
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";

                try {
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                }
                catch(PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }