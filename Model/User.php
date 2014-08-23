<?php
namespace Model;
use Model\UserInterface;

class User extends AbstractEntity implements UserInterface
{
    protected $_id;
    protected $_name;

    public function __construct($name) {
        $this->setName($name);
    }
    
    public function setId($id) {
        if ($this->_id !== null) {
            throw new \BadMethodCallException(
                "The ID for this user has been set already.");
        }
 
        if (!is_numeric($id) || $id < 1) {
            throw new \InvalidArgumentException("The user ID is invalid.");
        }
 
        $this->_id = $id;
        return $this;
    }
    
    public function getId() {
        return $this->_id;
    }
    
    public function setName($name) {
        if (strlen($name) < 2 || strlen($name) > 30) {
            throw new \InvalidArgumentException("The user name is invalid.");
        }
 
        $this->_name = htmlspecialchars(trim($name), ENT_QUOTES);
;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }
}