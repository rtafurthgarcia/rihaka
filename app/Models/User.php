<?php 

namespace App\Models;

use App\Core\AbstractModel;
use ErrorException;
use LengthException;
use PDO;
use Ramsey\Uuid\Uuid;
use App\Core\NetworkHelper;
//use parent;se parent;

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
	}

	public function login($email, $username, $password) {
		$addSupporter = $this->_connection->prepare(
			"SELECT * FROM benutzer WHERE (benutzername = :_userName OR email = :_email)"
        );
		
        $addSupporter->bindParam(":_userName", $username);
		$addSupporter->bindParam(":_email", $email);
		
        $addSupporter->execute();
		$rows = $addSupporter->fetchAll(PDO::FETCH_DEFAULT);
		if (count($rows)) {
			$record = $rows[0];

			if (!password_verify($password, $record["passwort"])) {
				throw new ErrorException("Wrong password.", 1);
			}

			$this->_primaryKey = $record["id"];
			$this->_userName = $record["benutzername"];
			$this->_lastName = $record["name"];
			$this->_firstName = $record["vorname"];
			$this->_password = $record["passwort"];
			$this->_isModerator = filter_var($record["ismoderator"], FILTER_VALIDATE_BOOLEAN);
			$this->_email = $record["email"];
			$this->_activationLink = $record["aktivierungslink"];
			$this->_isActivated = filter_var($record["isactivated"], FILTER_VALIDATE_BOOLEAN);
			$this->_creationDate->setTimestamp((int) $record["erstellungsdatum"]);
			
			$this->_lastConnectionDate = time();
			$this->_ipAddress = NetworkHelper::getIPAddress();

			$this->save();

			SessionHelper::regenerateSessionId();
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
		$this->_firstName = '';
		$this->_lastName = '';
		$this->_isModerator = false;

		// Account enabled by default when on dev mode
		$this->_isActivated = false; //filter_var($_ENV["DEBUG_MODE"], FILTER_VALIDATE_BOOLEAN);

        $this->_creationDate = time();
        $this->_lastConnectionDate = time();
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

        $addSupporter->bindParam(":_userName", $this->_userName);
        $addSupporter->bindParam(":_lastName", $this->_lastName);
        $addSupporter->bindParam(":_firstName", $this->_firstName);
		$addSupporter->bindParam(":_password", $this->_password);
        $addSupporter->bindParam(":_email", $this->_email);
        $addSupporter->bindParam(":_activationLink", $this->_activationLink);
        $addSupporter->bindParam(":_isActivated", $isActivated);
		$addSupporter->bindParam(":_isModerator", $isModerator);
        $addSupporter->bindParam(":_ipAddress", $this->_ipAddress);

        $execution_result = $addSupporter->execute();
        if($execution_result) {
            $this->_primaryKey = $this->_connection->lastInsertId();
        }
    }

    private function _update() {
        $addSupporter = $this->_connection->prepare(
            "UDPATE benutzer SET
                benutzername = :_userName, 
                name = :_lastName, 
                vorname = :_firstName, 
                passwort = :_password, 
                ismoderator = :_isModerator, 
                email = :_email, 
                aktivierungslink = :_activationLink, 
                isactivated = :_isActivated, 
                erstellungsdatum = :_creationDate, 
                letzteverbindungsdatum = :_lastConnectionDate, 
                ipaddresse = :_ipAddress
            WHERE id = :_primaryKey"
        );

        $addSupporter->bindParam(":_userName", $this->_userName);
        $addSupporter->bindParam(":_lastName", $this->_lastName);
        $addSupporter->bindParam(":_firstName", $this->_firstName);
        $addSupporter->bindParam(":_email", $this->_email);
        $addSupporter->bindParam(":_activationLink", $this->_activationLink);
        $addSupporter->bindParam(":_isActivated", $this->_isActivated);
        $addSupporter->bindParam(":_creationDate", $this->_creationDate);
        $addSupporter->bindParam(":_lastConnectionDate", $this->_lastConnectionDate);
        $addSupporter->bindParam(":_ipAddress", $this->_ipAddress);

        $addSupporter->bindParam(":_primaryKey", $this->_primaryKey);

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

        $addSupporter->bindParam(":_primaryKey", $this->_primaryKey);

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

        $addSupporter->bindParam(":_email", $this->_email);

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

        $addSupporter->bindParam(":_userName", $this->_userName);

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