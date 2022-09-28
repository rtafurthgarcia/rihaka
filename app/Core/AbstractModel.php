<?php 

namespace App\Core;

use PDO;

abstract class AbstractModel {
    protected $_connection;
    
    protected $_primaryKey;

    public function __construct()
    {
        $password = $_ENV["POSTGRES_PASSWORD"];
        $user = $_ENV["POSTGRES_USER"];
        $db = $_ENV["POSTGRES_DB"];
        $host = $_ENV["DB_HOST"];

        $this->_connection = new PDO("pgsql:host=$host;dbname=$db;user=$user;password=$password");

        $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public abstract function save();
    public abstract function delete();
    public abstract function get($primaryKey);
    public abstract function verify();
}