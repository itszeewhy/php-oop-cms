<?php

class Database
{
    // Define database infos as properties
    private $host = "localhost";
    private $db_name = "cms";
    private $user = "root";
    private $password = "";

    // Create and test the connection function
    protected function connect_db()
    {
        try {
            // Set the DSN for the PDO connection -> in the function (important)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;

            // Instantiate the connection with DNS, username and pwd
            $connection = new PDO($dsn, $this->user, $this->password);

            // Set attributes for the connection -> e.g. fetch mode and error mode
            $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Return the connection for Model handling
            return $connection;
        } catch (PDOException $error) {
            echo "Connection failed" . $error->getMessage();
        }
    }
}
