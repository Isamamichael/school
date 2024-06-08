<?php


    class Dbh{
        private $host = "localhost";
        private $user = "root";
        private $password = "soundofrevival";
        private $dbname = "gmotion";


        protected function connect() {
            $dsn = 'mysqli:host='.$this->host .';dbname='.$this->dbname;
            $pdo = new PDO("mysql:host=".$this->host . ";dbname=".$this->dbname.";", $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }
    }


?>