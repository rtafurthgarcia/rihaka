<?php 

namespace App\Models;

use App\Core\AbstractModel;
use ErrorException;
use PDO;


class RecordingCategory extends AbstractModel {

	private $_videoId = null;
	private $_categoryId = null;

	/**
	 *
	 * @return mixed
	 */
	function _insert() {
		$addSupporter = $this->_connection->prepare(
            "INSERT INTO {$this->_tableName} (
                videoid, 
                kategorieid
            ) 
            VALUES (
                :_videoId, 
                :_categoryId
            )"
        );

        $addSupporter->bindValue(":_videoId", $this->_videoId);
        $addSupporter->bindValue(":_categoryId", $this->_categoryId);

        $addSupporter->execute();
	}

	/**
	 *
	 * @return mixed
	 */
	function _update() {
	}
	/**
	 * @param $_videoId mixed 
	 * @param $_categoryId mixed 
	 */
	function __construct() {
        parent::__construct("videokategorie");
	}

	function getCategoriesByVideoId($videoId): Array {
		$addSupporter = $this->_connection->prepare(
			"SELECT id, name, beschreibung FROM {$this->_tableName}
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

	function deleteAllFrom($videoId) {
		$addSupporter = $this->_connection->prepare(
			"DELETE FROM {$this->_tableName}
			 WHERE videoid = :_videoId"
        );
		
        $addSupporter->bindValue(":_videoId", $videoId);
        $addSupporter->execute();
	}
	/**
	 * @return mixed
	 */
	function getVideoId() {
		return $this->_videoId;
	}
	
	/**
	 * @param mixed $_videoId 
	 * @return RecordingCategory
	 */
	function setVideoId($videoId): self {
		$this->_videoId = $videoId;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getCategoryId() {
		return $this->_categoryId;
	}
	
	/**
	 * @param mixed $_categoryId 
	 * @return RecordingCategory
	 */
	function setCategoryId($categoryId): self {
		$this->_categoryId = $categoryId;
		return $this;
	}
}