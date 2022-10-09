<?php 

namespace App\Core;

use PDO;

abstract class AbstractModel {
    protected $_connection;

    protected $_tableName;
    
    protected $_primaryKey;

    public function __construct(string $tableName)
    {
        $password = $_ENV["POSTGRES_PASSWORD"];
        $user = $_ENV["POSTGRES_USER"];
        $db = $_ENV["POSTGRES_DB"];
        $host = $_ENV["DB_HOST"];

        $this->_connection = new PDO("pgsql:host=$host;dbname=$db;user=$user;password=$password");
        $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->_tableName = $tableName;
    }

    protected abstract function _insert();
    protected abstract function _update();

        /**
     *
     * @return mixed
     */
    public function save() {
        if ($this->_primaryKey) {
            $this->_update();
        } else {
            $this->_insert();
        }
    }

    /**
     *
     * @return mixed
     */
    public function delete() {
        $addSupporter = $this->_connection->prepare(
            "DELETE FROM {$this->_tableName} WHERE id = :_primaryKey"
        );

        $addSupporter->bindValue(":_primaryKey", (int) $this->_primaryKey);

        $addSupporter->execute();    
    }

	/**
	 * @return mixed
	 */
	public function getPrimaryKey() {
		return $this->_primaryKey;
	}
	/**
	 * @param mixed $_primaryKey 
	 * @return AbstractModel
	 */
	function setPrimaryKey($primaryKey): self {
		$this->_primaryKey = $primaryKey;
		return $this;
	}
}