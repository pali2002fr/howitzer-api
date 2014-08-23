<?php
namespace Service;
use Model\Mapper\UserMapperInterface;

class UserService {
	protected $userMapper;
	public function __construct(UserMapperInterface $userMapper){
		$this->userMapper = $userMapper;
	}
	public function getTotalAllUser(){
		return count($this->userMapper->findAll());
	}
}