<?php
    // MySQL PDO Connection Class
    class MySQLPDO
    {
		private $connection;
		private $hostname;
		private $database;
        private $username;
        private $password;
        /*
        This constructor set the global variable with the required information and
        call the function that create the connection to the database
        */
        public function __construct()
        {
           
           
            $this->hostname = "94.254.0.43";
            $this->database = "sgta";
            $this->username = "sgta";
            $this->password = "sgta2022";
            $this->database_connection();
        }
        /* This function create an mysql database connection */
        public function database_connection()
        {
            try {
                $this->connection = new PDO("mysql:host=$this->hostname;dbname=$this->database", $this->username, $this->password, array(PDO::MYSQL_ATTR_FOUND_ROWS => true));
            } catch (PDOException $e) {
                echo "Connexão falhada: ".$e->getMessage();
            }
        }
        // Get MySQL PDO Connection
        public function getConnection()
        {
            return $this->connection;
        }
    }
