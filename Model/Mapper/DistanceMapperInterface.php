<?php
namespace Model\Mapper;
use Model\DistanceInterface;

interface DistanceMapperInterface{
	public function findById($id);
	public function findAll(array $conditions = array());
	
	public function insert(DistanceInterface $distance);
	public function delete($id);
}