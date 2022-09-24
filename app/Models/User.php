<?php 

namespace App\Models;

use App\Core\AbstractModel;
use DateTime;
use DateTimeInterface;

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

        $this->_creationDate = new DateTime();
        $this->_lastConnectionDate = New DateTime();
	}

    public function get($primaryKey) {
        foreach (parent::$_connection->query("SELECT * FROM user") as $record) {
            $this->_primaryKey = $primaryKey;
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
            $this->_ipAddress = filter_var($record["ipaddresse"], FILTER_VALIDATE_IP);
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
        $addSupporter = parent::$_connection->prepare(
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
                :_creationDate,
                :_lastConnectionDate,
                :_ipAddress
            )"
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

        $execution_result = $addSupporter->execute();
        if($execution_result) {
            $this->_primaryKey = parent::$_connection->lastInsertId();
        }
    }

    private function _update() {
        $addSupporter = parent::$_connection->prepare(
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
        $addSupporter = parent::$_connection->prepare(
            "DELETE FROM benutzer WHERE id = :_primaryKey"
        );

        $addSupporter->bindParam(":_primaryKey", $this->_primaryKey);

        $addSupporter->execute();    
    }
	/**
	 * @return mixed
	 */
	function getuserName() {
		return $this->_userName;
	}
	
	/**
	 * @param mixed $_userName 
	 * @return User
	 */
	function setuserName($_userName): self {
		$this->_userName = $_userName;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getlastName() {
		return $this->_lastName;
	}
	
	/**
	 * @param mixed $_lastName 
	 * @return User
	 */
	function setlastName($_lastName): self {
		$this->_lastName = $_lastName;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getfirstName() {
		return $this->_firstName;
	}
	
	/**
	 * @param mixed $_firstName 
	 * @return User
	 */
	function setfirstName($_firstName): self {
		$this->_firstName = $_firstName;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getpassword() {
		return $this->_password;
	}
	
	/**
	 * @param mixed $_password 
	 * @return User
	 */
	function setpassword($_password): self {
		$this->_password = $_password;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getisModerator() {
		return $this->_isModerator;
	}
	
	/**
	 * @param mixed $_isModerator 
	 * @return User
	 */
	function setisModerator($_isModerator): self {
		$this->_isModerator = $_isModerator;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getemail() {
		return $this->_email;
	}
	
	/**
	 * @param mixed $_email 
	 * @return User
	 */
	function setemail($_email): self {
		$this->_email = filter_var($_email, FILTER_VALIDATE_EMAIL);
        //if(! $this->_email) raise 
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getactivationLink() {
		return $this->_activationLink;
	}
	
	/**
	 * @param mixed $_activationLink 
	 * @return User
	 */
	function setactivationLink($_activationLink): self {
		$this->_activationLink = $_activationLink;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getisActivated() {
		return $this->_isActivated;
	}
	
	/**
	 * @param mixed $_isActivated 
	 * @return User
	 */
	function setisActivated($_isActivated): self {
		$this->_isActivated = $_isActivated;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getcreationDate() {
		return $this->_creationDate;
	}
	
	/**
	 * @param mixed $_creationDate 
	 * @return User
	 */
	function setcreationDate($_creationDate): self {
		$this->_creationDate = $_creationDate;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getlastConnectionDate() {
		return $this->_lastConnectionDate;
	}
	
	/**
	 * @param mixed $_lastConnectionDate 
	 * @return User
	 */
	function setlastConnectionDate($_lastConnectionDate): self {
		$this->_lastConnectionDate = $_lastConnectionDate;
		return $this;
	}
	/**
	 * @return mixed
	 */
	function getipAddress() {
		return $this->_ipAddress;
	}
	
	/**
	 * @param mixed $_ipAddress 
	 * @return User
	 */
	function setipAddress($_ipAddress): self {
		$this->_ipAddress = $_ipAddress;
		return $this;
	}
}