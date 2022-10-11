<?php 

namespace App\Models;

use App\Core\AbstractModel;
use ErrorException;
use PDO;

class Category extends AbstractModel {

    private $_name = null;
    private $_description = null;
    /**
     */
    public function __construct() {
        parent::__construct("kategorie");

        $this->_name = '';
        $this->_description = '';
    }

	public function getAllCategories(): array {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM {$this->_tableName}"
        );
		
		$categories = array();
        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);

		if (count($rows)) {
			foreach($rows as &$record) {
				$category = new Category();
				$category->setPrimaryKey($record["id"]);
				$category->setName($record["name"]);
				$category->setDescription($record["beschreibung"]);
	
				array_push($categories, $category);
			}
		} else {
			throw new ErrorException("No categories in database ?.", 3);
		}

		return $categories;
	}

	public function getAllCategoriesNames(): array {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM {$this->_tableName}"
        );
		
		$categories = array();
        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);

		if (count($rows)) {
			foreach($rows as &$record) {
				$categories[$record["name"]] = $record["id"];
			}
		} else {
			throw new ErrorException("No categories in database ?.", 3);
		}

		return $categories;
	}

	public function getByName($name): Category {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM {$this->_tableName} WHERE name = :_name"
        );

		$addSupporter->bindValue(":_name", $name);
		
        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);

		if (count($rows)) {
			$record = $rows[0];

			$this->_primaryKey = $record["id"];
			$this->_name = $record["name"];
			$this->_description =$record["beschreibung"];
		} else {
			throw new ErrorException("No category with such name.", 3);
		}

		return $this;
	}

	/**
	 *
	 * @return mixed
	 */
	protected function _insert() {
		$addSupporter = $this->_connection->prepare(
            "INSERT INTO {$this->_tableName} (
                name, 
                beschreibung
            ) 
            VALUES (
                :_name, 
                :_description
            )"
        );

        $addSupporter->bindValue(":_name", $this->_name);
        $addSupporter->bindValue(":_description", $this->_description);

		$execution_result = $addSupporter->execute();
        if($execution_result) {
            $this->_primaryKey = $this->_connection->lastInsertId();
        }
	}
	
	/**
	 *
	 * @return mixed
	 */
	protected function _update() {
	}

	function getCategoriesByVideoId($videoId): Array {
		$addSupporter = $this->_connection->prepare(
			"SELECT id, name, beschreibung FROM videokategorie
			 INNER JOIN kategorie ON id = kategorieId
			 WHERE videoid = :_videoId"
        );
		
        $addSupporter->bindValue(":_videoId", $videoId);
        $addSupporter->execute();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		$categories = array();

		foreach($rows as &$record) {
			$category = new Category();
			$category->setPrimaryKey($record['id']);
			$category->setName($record['name']);
			$category->setDescription($record['beschreibung']);

			array_push($categories, $category);
		}

		return $categories;
	}


	/**
	 * @return mixed
	 */
	function getName() {
		return $this->_name;
	}
	
	/**
	 * @param mixed $_name 
	 * @return category
	 */
	function setName($name): self {
		$this->_name = $name;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getDescription() {
		return $this->_description;
	}
	
	/**
	 * @param mixed $_description 
	 * @return category
	 */
	function setDescription($description): self {
		$this->_description = $description;
		return $this;
	}
}
