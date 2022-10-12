<?php 

namespace App\Models;

use App\Core\AbstractModel;
use DateTime;
use ErrorException;
use PDO;
use Ramsey\Collection\Exception\NoSuchElementException;

/**
 * Is the Active Record Object linked to the "video" table in the database.  
 * 
 */
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

	// Useful for pagination
	public const MAX_RECORDINGS_PER_PAGE = 6;

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
	 * Returns a recording based on its secondary ID, its ressource
	 * @param mixed $id: secondary ID of the recording
	 * @return Recording object 
	 */
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

	/**
	 * Get all records from a specific user based on a range. Ordered by latest created recordings. 
	 * @param mixed $id: User ID
	 * @param int $start: Start of the range
	 * @param int $limit: How much has to be returned
	 * @return array An array of Recordings
	 */
	function getRecordingsByUserId($id, int $start, int $limit): array {
		$addSupporter = $this->_connection->prepare(
			"SELECT sekundaerid FROM {$this->_tableName} 
			WHERE benutzerid = :_userId
			ORDER BY erstellungsdatum DESC
			LIMIT :_limit OFFSET :_offset"
        );
		
        $addSupporter->bindValue(":_userId", $id);
		$addSupporter->bindValue(":_limit", $limit);
		$addSupporter->bindValue(":_offset", $start);
        $addSupporter->execute();

		$recordings = array();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		foreach($rows as $record) {
			$recording = (new Recording())->getBySecondaryId($record["sekundaerid"]);
			array_push($recordings, $recording);
		}

		return $recordings;
	}

    /**
	 * Returns the amounts of recordings created by a specific user. 
	 * Useful for pagination. 
	 * @param mixed $id : User ID 
	 * @return int Number of recordings created by this one user
	 */
	function getNumberRecordingsByUserId($id): int {
		$addSupporter = $this->_connection->prepare(
			"SELECT COUNT(sekundaerid) AS total FROM {$this->_tableName} WHERE benutzerid = :_userId"
        );
		
        $addSupporter->bindValue(":_userId", $id);
        $addSupporter->execute();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows) > 0) {
			return (int) $rows[0]['total'];
		} else {
			return 0;
		}
	}

	function getAllRecords(): array {
		$allSupporter = $this->_connection->prepare(
			"SELECT * FROM {$this->_tableName}"
		);

		$recordings = array ();


		$allSupporter->execute();
		$rows = $allSupporter->fetchAll(PDO::FETCH_DEFAULT);
		foreach($rows as $record){

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

			array_push($recordings, $this);
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

	function getCategories(): array {
		return $this->_categories;
	}

	/**
	 * Get all categories as a single string. 
	 * Useful for when you want to quickly define an input value in your form. 
	 * 
	 * @return string: Categories separated by a ','
	 */
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
	
	function setCategories(array $categories): self {
		$this->_categories = array();

		foreach($categories as &$categoryName) {
			$newCategory = new Category();
			$newCategory->setName($categoryName);
			array_push($this->_categories, $newCategory);
		}

		return $this;
	}

	// From now on, its basically only setters and getters
	function getUserName(): string {
		return (new User())->getById($this->_userId)->getUserName();
	}

	function getSecondaryId() {
		return $this->_secondaryId;
	}
	
	function setSecondaryId($secondaryId): self {
		$this->_secondaryId = $secondaryId;
		return $this;
	}

	function getVideoLink() {
		return $this->_videoLink;
	}

	function setVideoLink($videoLink): self {
		$this->_videoLink = $videoLink;
		return $this;
	}

	function getTitle() {
		return $this->_title;
	}
	
	function setTitle($title): self {
		$this->_title = $title;
		return $this;
	}

	function getDescription() {
		return $this->_description;
	}
	

	function setDescription($description): self {
		$this->_description = $description;
		return $this;
	}

	function getUserId() {
		return $this->_userId;
	}
	
	function setUserId($userId): self {
		$this->_userId = $userId;
		return $this;
	}

	function getIsPrivate() {
		return $this->_isPrivate;
	}
	
	function setIsPrivate($isPrivate): self {
		$this->_isPrivate = $isPrivate;
		return $this;
	}

	function getCommentsAuthorized() {
		return $this->_commentsAuthorized;
	}
	
	function setCommentsAuthorized($commentsAuthorized): self {
		$this->_commentsAuthorized = $commentsAuthorized;
		return $this;
	}

	function getCreationDate() {
		return $this->_creationDate;
	}
	
	function setCreationDate($creationDate): self {
		$this->_creationDate = $creationDate;
		return $this;
	}
	
	function getLength(): int {
		return $this->_length;
	}
	
	function setLength($length): self {
		$this->_length = $length;
		return $this;
	}

	function getCalculatedRating(): float {
		return $this->_calculatedRating;
	}

	function setCalculatedRating(int $calculatedRating): self {
		$this->_calculatedRating = $calculatedRating;
		return $this;
	}

	function getTimeToDisplay(): int {
		return $this->_timeToDisplay;
	}
	
	function setTimeToDisplay(int $timeToDisplay): self {
		$this->_timeToDisplay = $timeToDisplay;
		return $this;
	}
}