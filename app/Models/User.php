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

class User extends AbstractModel {
    
    private $_userName = null;
    private $_lastName = null;
    private $_firstName = null;
    private $_password = null;
    private $_isModerator = null;
    private $_email = null;
    private $_activationLink = null;
    private $_isActivated = null;
    private $_creationDate = null;    
    private $_lastConnectionDate = null;
    private $_ipAddress = null;
    /**
	 */
    public function __construct() {
        parent::__construct();

		$this->_firstName = '';
		$this->_lastName = '';
		$this->_isModerator = false;

		// Account enabled by default when on dev mode
		$this->_isActivated = false; //filter_var($_ENV["DEBUG_MODE"], FILTER_VALIDATE_BOOLEAN);

        $this->_creationDate = (New DateTime())->setTimestamp(time());
        $this->_lastConnectionDate = (New DateTime())->setTimestamp(time());
	}

	public function getById($primaryKey) {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM benutzer WHERE id = :_primaryKey"
        );
		
        $addSupporter->bindValue(":_primaryKey", $primaryKey);
        $addSupporter->execute();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows)) {
			$record = $rows[0];

			$this->_primaryKey = (int)$record["id"];
			$this->_userName = $record["benutzername"];
			$this->_lastName = $record["name"];
			$this->_firstName = $record["vorname"];
			$this->_password = $record["passwort"];
			$this->_isModerator = filter_var($record["ismoderator"], FILTER_VALIDATE_BOOLEAN);
			$this->_email = $record["email"];
			$this->_activationLink = $record["aktivierungslink"];
			$this->_isActivated = filter_var($record["isactivated"], FILTER_VALIDATE_BOOLEAN);
			$this->_creationDate = new DateTime($record["erstellungsdatum"]);
			$this->_lastConnectionDate = new DateTime($record["letzteverbindungsdatum"]);
			$this->_ipAddress = $record["ipaddresse"];
		} else {
			throw new ErrorException("No user with such primary key.", 1);
		}
	}

	public function getByUsername($username) {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM benutzer WHERE benutzername = :_userName"
        );
		
        $addSupporter->bindValue(":_userName", $this->_userName);
        $addSupporter->execute();

		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows)) {
			$record = $rows[0];

			$this->_primaryKey = (int)$record["id"];
			$this->_userName = $record["benutzername"];
			$this->_lastName = $record["name"];
			$this->_firstName = $record["vorname"];
			$this->_password = $record["passwort"];
			$this->_isModerator = filter_var($record["ismoderator"], FILTER_VALIDATE_BOOLEAN);
			$this->_email = $record["email"];
			$this->_activationLink = $record["aktivierungslink"];
			$this->_isActivated = filter_var($record["isactivated"], FILTER_VALIDATE_BOOLEAN);
			$this->_creationDate->setTimestamp((int) $record["erstellungsdatum"]);
			$this->_lastConnectionDate->setTimestamp((int) $record["letzteverbindungsdatum"]);
			$this->_ipAddress = $record["ipaddresse"];
		} else {
			throw new ErrorException("No user with such username.", 1);
		}
	}

	public function login($identifier, $password) {
		$addSupporter = $this->_connection->prepare(
			"SELECT id, passwort FROM benutzer WHERE (benutzername = :_userName OR email = :_email) AND isactivated = true"
        );
		
        $addSupporter->bindValue(":_userName", $identifier);
		$addSupporter->bindValue(":_email", $identifier);
		
        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows)) {
			$record = $rows[0];

			if (!password_verify($password, $record["passwort"])) {
				throw new ErrorException("Wrong password.", 1);
			}

			$this->getById($record["id"]);
			
			$this->_lastConnectionDate->setTimestamp(time());
			$this->_ipAddress = NetworkHelper::getIPAddress();

			$this->save();

			SessionHelper::regenerateSessionId();
			$_SESSION['authenticated'] = true;
			$_SESSION['id'] = $this->_primaryKey;
			$_SESSION['username'] = $this->_userName;
		} else {
			throw new ErrorException("No account found with such username or e-mail address.", 1);
		}
	}
    

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

    private function _insert() {
		$this->_activationLink = Uuid::uuid4()->toString();

        $addSupporter = $this->_connection->prepare(
            "INSERT INTO benutzer (
                benutzername, 
                name, 
                vorname, 
                passwort, 
                ismoderator, 
                email, 
                aktivierungslink, 
                isactivated, 
                erstellungsdatum, 
                letzteverbindungsdatum, 
                ipaddresse
            ) 
            VALUES (
                :_userName, 
                :_lastName, 
                :_firstName,
                :_password,
                :_isModerator,
                :_email,
                :_activationLink,
                :_isActivated,
                CURRENT_TIMESTAMP,
                CURRENT_TIMESTAMP,
                :_ipAddress
            )"
        );

		$isActivated = var_export($this->_isActivated, true);
		$isModerator = var_export($this->_isModerator, true);

        $addSupporter->bindValue(":_userName", $this->_userName);
        $addSupporter->bindValue(":_lastName", $this->_lastName);
        $addSupporter->bindValue(":_firstName", $this->_firstName);
		$addSupporter->bindValue(":_password", $this->_password);
        $addSupporter->bindValue(":_email", $this->_email);
        $addSupporter->bindValue(":_activationLink", $this->_activationLink);
        $addSupporter->bindValue(":_isActivated", $isActivated);
		$addSupporter->bindValue(":_isModerator", $isModerator);
        $addSupporter->bindValue(":_ipAddress", $this->_ipAddress);

        $execution_result = $addSupporter->execute();
        if($execution_result) {
            $this->_primaryKey = $this->_connection->lastInsertId();
        }
    }

    private function _update() {
        $addSupporter = $this->_connection->prepare(
            "UPDATE benutzer SET
                benutzername = :_userName, 
                name = :_lastName, 
                vorname = :_firstName, 
                passwort = :_password, 
                ismoderator = :_isModerator, 
                email = :_email, 
                aktivierungslink = :_activationLink, 
                isactivated = :_isActivated, 
                letzteverbindungsdatum = :_lastConnectionDate, 
                ipaddresse = :_ipAddress
            WHERE id = :_primaryKey"
        );

		$isActivated = var_export($this->_isActivated, true);
		$isModerator = var_export($this->_isModerator, true);

        $addSupporter->bindValue(":_userName", $this->_userName);
        $addSupporter->bindValue(":_lastName", $this->_lastName);
        $addSupporter->bindValue(":_firstName", $this->_firstName);
		$addSupporter->bindValue(":_password", $this->_password);
		$addSupporter->bindValue(":_isModerator", $isModerator);
        $addSupporter->bindValue(":_email", $this->_email);
        $addSupporter->bindValue(":_activationLink", $this->_activationLink);
        $addSupporter->bindValue(":_isActivated", $isActivated);
        $addSupporter->bindValue(":_lastConnectionDate", $this->_lastConnectionDate->format('Y-m-d H:i:s'));
        $addSupporter->bindValue(":_ipAddress", $this->_ipAddress);
        $addSupporter->bindValue(":_primaryKey", $this->_primaryKey);

        $addSupporter->execute();
    }
    
    /**
     *
     * @return mixed
     */
    public function delete() {
        $addSupporter = $this->_connection->prepare(
            "DELETE FROM benutzer WHERE id = :_primaryKey"
        );

        $addSupporter->bindValue(":_primaryKey", (int) $this->_primaryKey);

        $addSupporter->execute();    
    }
	/**
	 * @return mixed
	 */
	function getUserName() {
		return $this->_userName;
	}
	
	/**
	 * @param mixed $_userName 
	 * @return User
	 */
	function setUserName($userName): self {
		$this->_userName = trim($userName);
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getLastName() {
		return $this->_lastName;
	}
	
	/**
	 * @param mixed $_lastName 
	 * @return User
	 */
	function setLastName($lastName): self {
		$this->_lastName = $lastName;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getFirstName() {
		return $this->_firstName;
	}
	
	/**
	 * @param mixed $_firstName 
	 * @return User
	 */
	function setFirstName($firstName): self {
		$this->_firstName = $firstName;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getPassword() {
		return $this->_password;
	}
	
	/**
	 * @param mixed $_password 
	 * @return User
	 */
	function setPassword($password, $confirmation): self {
		if ( strcmp($password, $confirmation)) {
			throw new ErrorException("Passwords do not match.", 1);
		}

		if (strlen($password) < 10) {
			throw new LengthException("Password doesnt meet length requirements.", 2);
		}
			
		$this->_password = password_hash($password, PASSWORD_DEFAULT);
		
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getIsModerator() {
		return $this->_isModerator;
	}
	
	/**
	 * @param mixed $_isModerator 
	 * @return User
	 */
	function setIsModerator($isModerator): self {
		$this->_isModerator = $isModerator;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getEmail() {
		return $this->_email;
	}
	
	/**
	 * @param mixed $_email 
	 * @return User
	 */
	function setEmail($email): self {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new \InvalidArgumentException("E-Mail doesnt match a proper E-Mail pattern.");
		}
        //if(! $this->_email) raise 
		$this->_email = filter_var($email, FILTER_VALIDATE_EMAIL);

		return $this;
	}
	/**
	 * @return mixed
	 */
	function getActivationLink() {
		return $this->_activationLink;
	}
	
	/**
	 * @param mixed $_activationLink 
	 * @return User
	 */
	function setActivationLink($activationLink): self {
		$this->_activationLink = $activationLink;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getIsActivated() {
		return $this->_isActivated;
	}
	
	/**
	 * @param mixed $_isActivated 
	 * @return User
	 */
	function setIsActivated($isActivated): self {
		$this->_isActivated = $isActivated;
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
	 * @return User
	 */
	function setCreationDate($creationDate): self {
		$this->_creationDate = $creationDate;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getLastConnectionDate() {
		return $this->_lastConnectionDate;
	}
	
	/**
	 * @param mixed $_lastConnectionDate 
	 * @return User
	 */
	function setLastConnectionDate($lastConnectionDate): self {
		$this->_lastConnectionDate = $lastConnectionDate;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getIpAddress() {
		return $this->_ipAddress;
	}
	
	/**
	 * @param mixed $_ipAddress 
	 * @return User
	 */
	function setIpAddress($ipAddress): self {
		$this->_ipAddress = $ipAddress;
		return $this;
	}

	function verifyEmail() {
		$addSupporter = $this->_connection->prepare(
            "SELECT id FROM benutzer WHERE email = :_email"
        );

        $addSupporter->bindValue(":_email", $this->_email);

        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_COLUMN, 0);
		if (count($rows)) {
			throw new ErrorException("E-Mail address already in use. Sorry~~");
		}

		return true;
	}

	function verifyUsername() {
		$addSupporter = $this->_connection->prepare(
            "SELECT id FROM benutzer WHERE benutzername = :_userName"
        );

        $addSupporter->bindValue(":_userName", $this->_userName);

        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_COLUMN, 0);
		if (count($rows)) {
			throw new ErrorException("Username already in use. Sorry~~");
		}

		return true;
	}

	function verifyPassword() {

	}
}