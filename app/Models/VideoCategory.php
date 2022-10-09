
<?php 

namespace App\Models;

use App\Core\AbstractModel;
use ErrorException;
use PDO;


class VideoCategory extends AbstractModel {

private $_videoId = null;
private $_categoryId = null;

	/**
	 *
	 * @return mixed
	 */
	function _insert() {
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