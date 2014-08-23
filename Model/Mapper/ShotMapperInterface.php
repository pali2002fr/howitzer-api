<?php
namespace Model\Mapper;
use Model\UserInterface,
	Model\HowitzerInterface,
	Model\TargetInterface,
	Model\DistanceInterface,
	Model\SpeedInterface,
	Model\AngleInterface;

interface ShotMapperInterface{
	public function findById($id);
	public function findAll(array $conditions = array());
	
	public function insert(UserInterface $user, HowitzerInterface $howitzer, TargetInterface $target, DistanceInterface $distance, SpeedInterface $speed, AngleInterface $angle);
	public function delete($id);
}