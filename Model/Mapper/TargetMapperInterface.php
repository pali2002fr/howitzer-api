<?php
namespace Model\Mapper;
use Model\TargetInterface;

interface TargetMapperInterface{
	public function findById($id);
	public function findAll(array $conditions = array());
	
	public function insert(TargetInterface $target);
	public function delete($id);
}