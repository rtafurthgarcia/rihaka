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

class category extends AbstractModel {

    private $_name = null;
    private $_description = null;
    /**
     */
    public function __construct() {
        parent::__construct("kategorie");

        $this->_name = '';
        $this->_description = '';
    }
	/**
	 *
	 * @return mixed
	 */
	protected function _insert() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	protected function _update() {
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
