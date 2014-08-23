<?php
namespace Model\Mapper;
use Model\SpeedInterface;

interface SpeedMapperInterface{
	public function findById($id);
	public function findAll(array $conditions = array());
	
	public function insert(SpeedInterface $speed);
	public function delete($id);
}