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
	function __construct($_videoId, $_categoryId) {
        parent::__construct("videokategorie");

	    $this->_videoId = $_videoId;
	    $this->_categoryId = $_categoryId;
	}
}