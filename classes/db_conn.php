<?php

class Db_conn {
    private $user = 'root';
    private $password = '';
    private $dbname = 'majstori';
    private $host = 'localhost';
    private $dbh;
    private $error;

    public function __construct() {
        $dsn = "mysql:dbname=".$this->dbname.";host=".$this->host;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (Exception $ex) {
            $this->error = $ex->getMessage();
            echo $this->error;
            echo "GRESKA: Nije uspostavljena veza sa bazom!";
        }
    }
    
    public function getDbh(){
        return $this->dbh;
    }

}
