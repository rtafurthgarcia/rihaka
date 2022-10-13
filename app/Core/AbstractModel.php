<?php 

namespace App\Core;

use PDO;

/** 
 * Parent class for all of our Model classes. 
 * PDO $_connection will be used to directly query and update tables.
 * $_tableName will be used as a way to avoid typing manually the table's name everytime.
 * $_primaryKey is present cause supposedly all records have one. 
 *
 * Because all of our models will probably share some insert and update functions, _insert() and _update() have been as abstact as to force their 
 * implementation. Both delete() and save() are managed directly by the parent for it is universal for (nearly) all records. 
 * Actually just noticed it didnt apply if u had a pk made of many different fk. 
 *
**/
abstract class AbstractModel {
    protected $_connection;
    protected $_tableName;
    protected $_primaryKey;

    /** 
      * Constructor
      * @param string $tableName: table linked to our new Model
      */ 
    public function __construct(string $tableName)
    {
	// Loads db settings from the env variables
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
     * Apply modifications to the real linked record on the table. 
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
     * Delete the real record in the db. Doesnt destroy the object!
     */
    public function delete() {
        $addSupporter = $this->_connection->prepare(
            "DELETE FROM {$this->_tableName} WHERE id = :_primaryKey"
        );

        $addSupporter->bindValue(":_primaryKey", (int) $this->_primaryKey);

        $addSupporter->execute();    
    }

	/**
	 * Returns the pk
	 * @return pk
	 */
	public function getPrimaryKey() {
		return $this->_primaryKey;
	}
	/**
	 * Sets the pk
	 * @param mixed $_primaryKey 
	 * @return AbstractModel
	 */
	function setPrimaryKey($primaryKey): self {
		$this->_primaryKey = $primaryKey;
		return $this;
	}
}
