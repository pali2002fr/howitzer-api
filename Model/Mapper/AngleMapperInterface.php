<?php
namespace Model\Mapper;
use Model\AngleInterface;

interface AngleMapperInterface{
	public function findById($id);
	public function findAll(array $conditions = array());
	
	public function insert(AngleInterface $angle);
	public function delete($id);
}