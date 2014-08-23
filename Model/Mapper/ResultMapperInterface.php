<?php
namespace Model\Mapper;
use Model\ShotInterface,
	Model\UserInterface;

interface ResultMapperInterface{
	public function findById($id);
	public function findAll(array $conditions = array());
	
	public function insert( ShotInterface $shot, UserInterface $user, $hit, $impact);
	public function delete($id);
}