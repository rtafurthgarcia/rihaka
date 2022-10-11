<?php 

namespace App\Models;

use App\Core\AbstractModel;
use DateTime;
use ErrorException;
use PDO;
use Ramsey\Collection\Exception\NoSuchElementException;

class Recording extends AbstractModel {
    
    private $_secondaryId = null;
    private $_videoLink = null;
    private $_title = null;
    private $_description = null;
    private $_userId = null;
	private $_length = null;
	private $_timeToDisplay = null;
	private $_calculatedRating = null;
    private $_isPrivate = null;
    private $_commentsAuthorized = null;
    private $_creationDate = null;
	private $_categories = array(); 

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

	function getBySecondaryId($id): Recording {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM {$this->_tableName} WHERE sekundaerid = :_secondaryId"
        );
		
        $addSupporter->bindValue(":_secondaryId", $id);
        $addSupporter->execute();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows)) {
			$record = $rows[0];

			$this->_primaryKey = (int)$record["id"];
			$this->_secondaryId = $record["sekundaerid"];
			$this->_videoLink = $record["video"];
			$this->_title = $record["titel"];
			$this->_length = (int)$record["dauer"];
			$this->_timeToDisplay = (int)$record["zuzeigendezeit"];
			$this->_userId = $record["benutzerid"];
			$this->_isPrivate = filter_var($record["istprivat"], FILTER_VALIDATE_BOOLEAN);
			$this->_commentsAuthorized = filter_var($record["istkommentierbar"], FILTER_VALIDATE_BOOLEAN);
			$this->_calculatedRating = (float)$record["berechnetebewertung"];
			$this->_creationDate = new DateTime($record["erstellungsdatum"]);

			$this->_categories = (new RecordingCategory())->getCategoriesByVideoId($this->_primaryKey);
		} else {
			throw new ErrorException("No recording with such primary key.", 1);
		}

		return $this;
	}

	function getRecordsByUserId($id): array {
		$addSupporter = $this->_connection->prepare(
			"SELECT sekundaerid FROM {$this->_tableName} WHERE benutzerid = :_userId"
        );
		
        $addSupporter->bindValue(":_userId", $id);
        $addSupporter->execute();

		$recordings = array();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows)) {
			foreach($rows as $record) {
				$recording = (new Recording())->getBySecondaryId($record["sekundaerid"]);
				array_push($recordings, $recording);
			}
		} else {
			throw new NoSuchElementException("No recording linked to this user.", 1);
		}

		return $recordings;
	}
	
    protected function _insert() {
        $addSupporter = $this->_connection->prepare(
            "INSERT INTO {$this->_tableName} (
                sekundaerid, 
                video, 
                titel, 
                beschreibung, 
				dauer,
				zuzeigendezeit,
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
				:_length,
				:_timeToDisplay,
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
		$addSupporter->bindValue(":_length", $this->_length);
		$addSupporter->bindValue(":_timeToDisplay", $this->_timeToDisplay);
        $addSupporter->bindValue(":_userId", $this->_userId);
        $addSupporter->bindValue(":_isPrivate", $isPrivate);
		$addSupporter->bindValue(":_commentsAuthorized", $commentsAuthorized);

        $execution_result = $addSupporter->execute();
        if($execution_result) {
            $this->_primaryKey = $this->_connection->lastInsertId();
        }

		$this->_saveCategories();
    }

	/**
	 *
	 * @return mixed
	 */
	function _update() {
		$addSupporter = $this->_connection->prepare(
            "UPDATE {$this->_tableName} SET
                sekundaerid = :_secondaryId, 
                video = :_videoLink, 
                titel = :_title, 
                beschreibung = :_description, 
				dauer = :_length,
				zuzeigendezeit = :_timeToDisplay,
                benutzerid = :_userId, 
                istprivat = :_isPrivate, 
                istkommentierbar = :_commentsAuthorized
            WHERE id = :_primaryKey"
        );

		$isPrivate = var_export($this->_isPrivate, true);
		$commentsAuthorized = var_export($this->_commentsAuthorized, true);

        $addSupporter->bindValue(":_secondaryId", $this->_secondaryId);
        $addSupporter->bindValue(":_videoLink", $this->_videoLink);
        $addSupporter->bindValue(":_title", strip_tags($this->_title));
		$addSupporter->bindValue(":_description", strip_tags($this->_description));
		$addSupporter->bindValue(":_length", $this->_length);
		$addSupporter->bindValue(":_timeToDisplay", $this->_timeToDisplay);
		$addSupporter->bindValue(":_userId", $this->_userId);
        $addSupporter->bindValue(":_isPrivate", $isPrivate);
        $addSupporter->bindValue(":_commentsAuthorized", $commentsAuthorized);
        $addSupporter->bindValue(":_primaryKey", $this->_primaryKey);

        $addSupporter->execute();

		$this->_saveCategories();
	}

	private function _saveCategories() {
		$categoriesPresentInDB = (new Category())->getAllCategoriesNames();

		// Purge all categories linked to this record to recreate them later on
		(new RecordingCategory)->deleteAllFrom($this->_primaryKey);

		// Find each category that has to be inserted first
		foreach($this->_categories as &$category) {
			if(! isset($categoriesPresentInDB[$category->getName()])) {
				$category->save();
			} else {
				$category->getById($categoriesPresentInDB[$category->getName()]);
			}

			(new RecordingCategory())->setVideoId($this->_primaryKey)->setCategoryId($category->getPrimaryKey())->save();
		}	
	}

	function getCategories() {
		return $this->_categories;
	}

	function getCategoriesAsString(): string {
		$returnString = '';

		if (count($this->_categories) === 0) {
			return $returnString;
		}

		for ($i = 0; $i <= count($this->_categories) -1; $i++) {
			$returnString .= $this->_categories[$i]->getName();

			if ($i < count($this->_categories) -1) {
				$returnString .= ',';
			}
		}

		return $returnString;
	}
	
	/**
	 * @param mixed $_categories 
	 * @return Recording
	 */
	function setCategories(array $categories): self {
		$this->_categories = array();

		foreach($categories as &$categoryName) {
			$newCategory = new Category();
			$newCategory->setName($categoryName);
			array_push($this->_categories, $newCategory);
		}

		return $this;
	}

	function getUserName(): string {
		return (new User())->getById($this->_userId)->getUserName();
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
	
	/**
	 * @return mixed
	 */
	function getLength(): int {
		return $this->_length;
	}
	
	/**
	 * @param mixed $_length 
	 * @return Recording
	 */
	function setLength($length): self {
		$this->_length = $length;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getCalculatedRating(): float {
		return $this->_calculatedRating;
	}
	
	/**
	 * @param mixed $_calculatedRating 
	 * @return Recording
	 */
	function setCalculatedRating(int $calculatedRating): self {
		$this->_calculatedRating = $calculatedRating;
		return $this;
	}

	/**
	 * @return mixed
	 */
	function getTimeToDisplay(): int {
		return $this->_timeToDisplay;
	}
	
	/**
	 * @param mixed $_timeToDisplay 
	 * @return Recording
	 */
	function setTimeToDisplay(int $timeToDisplay): self {
		$this->_timeToDisplay = $timeToDisplay;
		return $this;
	}
}