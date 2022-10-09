<?php 

namespace App\Models;

use App\Core\AbstractModel;
use App\Core\SessionHelper;
use DateTime;
use ErrorException;
use LengthException;
use PDO;
use Ramsey\Uuid\Uuid;
use App\Core\NetworkHelper;

class Recording extends AbstractModel {
    
    private $_secondaryId = null;
    private $_videoLink = null;
    private $_title = null;
    private $_description = null;
    private $_userId = null;
    private $_isPrivate = null;
    private $_commentsAuthorized = null;
    private $_creationDate = null;

	/**
	 */
	function __construct() {
        parent::__construct("video");

		$this->_secondaryId = uniqid();
		$this->_videoLink = '';
        $this->_description = '';
        $this->_userId = 0;
		$this->_isPrivate = false;
        $this->_commentsAuthorized = true;
        $this->_creationDate = New DateTime();
	}

	/**
	 * @return mixed
	 */
	function getSecondaryId() {
		return $this->_secondaryId;
	}
	
	/**
	 * @param mixed $_secondaryId 
	 * @return Recording
	 */
	function setSecondaryId($secondaryId): self {
		$this->_secondaryId = $secondaryId;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getVideoLink() {
		return $this->_videoLink;
	}
	
	/**
	 * @param mixed $_videoLink 
	 * @return Recording
	 */
	function setVideoLink($videoLink): self {
		$this->_videoLink = $videoLink;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getTitle() {
		return $this->_title;
	}
	
	/**
	 * @param mixed $_title 
	 * @return Recording
	 */
	function setTitle($title): self {
		$this->_title = $title;
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
	 * @return Recording
	 */
	function setDescription($description): self {
		$this->_description = $description;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getUserId() {
		return $this->_userId;
	}
	
	/**
	 * @param mixed $_userId 
	 * @return Recording
	 */
	function setUserId($userId): self {
		$this->_userId = $userId;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getIsPrivate() {
		return $this->_isPrivate;
	}
	
	/**
	 * @param mixed $_isPrivate 
	 * @return Recording
	 */
	function setIsPrivate($isPrivate): self {
		$this->_isPrivate = $isPrivate;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getCommentsAuthorized() {
		return $this->_commentsAuthorized;
	}
	
	/**
	 * @param mixed $_commentsAuthorized 
	 * @return Recording
	 */
	function setCommentsAuthorized($commentsAuthorized): self {
		$this->_commentsAuthorized = $commentsAuthorized;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getCreationDate() {
		return $this->_creationDate;
	}
	
	/**
	 * @param mixed $_creationDate 
	 * @return Recording
	 */
	function setCreationDate($creationDate): self {
		$this->_creationDate = $creationDate;
		return $this;
	}
	
    protected function _insert() {
        $addSupporter = $this->_connection->prepare(
            "INSERT INTO {$this->_tableName} (
                sekundaerid, 
                video, 
                titel, 
                beschreibung, 
                benutzerid, 
                istprivat, 
                istkommentierbar, 
                erstellungsdatum
            ) 
            VALUES (
                :_secondaryId, 
                :_videoLink, 
                :_title,
                :_description,
                :_userId,
                :_isPrivate,
                :_commentsAuthorized,
                CURRENT_TIMESTAMP
            )"
        );

		$isPrivate = var_export($this->_isPrivate, true);
		$commentsAuthorized = var_export($this->_commentsAuthorized, true);

        $addSupporter->bindValue(":_secondaryId", $this->_secondaryId);
        $addSupporter->bindValue(":_videoLink", $this->_videoLink);
        $addSupporter->bindValue(":_title", strip_tags($this->_title));
		$addSupporter->bindValue(":_description", strip_tags($this->_description));
        $addSupporter->bindValue(":_userId", $this->_userId);
        $addSupporter->bindValue(":_isPrivate", $isPrivate);
		$addSupporter->bindValue(":_commentsAuthorized", $commentsAuthorized);

        $execution_result = $addSupporter->execute();
        if($execution_result) {
            $this->_primaryKey = $this->_connection->lastInsertId();
        }
    }
	
	/**
	 *
	 * @return mixed
	 */
	function _update() {
	}
}