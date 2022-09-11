<?php 

namespace App\Models;

use App\Core\AbstractModel;

class User extends AbstractModel {
    
    private $_userName;
    private $_lastName;
    private $_firstName;
    private $_isModerator;
    private $_email;
    private $_activationLink;
    private $_isActivated;
    private $_creationDate;    


    /**
	 */
    public function __construct() {
        parent::__construct();
	}

    /**
     *
     * @return mixed
     */
    public function save() {
    }

    private function _insert() {
        //parent::$_connection->
    } 
    
    /**
     *
     * @return mixed
     */
    public function delete() {
    }
}