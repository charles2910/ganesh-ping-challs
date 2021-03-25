<?php

class SQL {
    public $query = '';
    public $conn;

    public function __construct() {}
    
    public function connect() {
        $servername = "localhost";
        $username = "db_user";
        $password = "w3b_4_Th3_W!n";
        $database = "cereal";

        $this->conn = new mysqli($servername, $username, $password, $database);

        if (!$this->conn)
            die("Debugging error[" . mysqli_connect_errno() . "]: " . mysqli_connect_error() . PHP_EOL);
        //echo "Success: A proper connection to MySQL was made! The cereal database is great.";
        //echo "Host information: " . mysqli_get_host_info($this->conn);
    }

    public function SQL_query($query) {
        $this->query = $query;
        echo "QUERY:" . $this->query;
    }

    public function execute() {
        //echo "<br>QUERY:" . $this->query . "<br>";
        return $this->conn->query($this->query);
    }

    public function __destruct() {
        if (!isset ($this->conn))
            $this->connect();
        
        $ret = $this->execute();

        if ($ret !== false) {   
            echo "<h2> Resposta: </h2>";
            while ($row = $ret->fetch_assoc()) {
                echo '<p class="user"><strong>Username:<strong> ' . $row['username'] . '</p>';
            }
        }
    }
}
