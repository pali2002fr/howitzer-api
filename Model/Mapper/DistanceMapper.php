<?php
namespace Model\Mapper;
use Library\Database\DatabaseAdapterInterface,
	Model\DistanceInterface,
	Model\Distance;
	
class DistanceMapper extends AbstractDataMapper implements DistanceMapperInterface {
	protected $entityTable = "distance";
	
	public function insert(DistanceInterface $distance){
		$distance->id = $this->adapter->insert(
			$this->entityTable,
			array(
				'distance' => $distance->distance
			)
		);
		return $distance->id;
	}
	
	public function delete($id){
		if($id instanceOf DistanceInterface){
			$id = $id->id;
		}
		
		return $adapter->delete($this->entityTable, "id = $id");
	}
	
	protected function createEntity(array $row){
		$distance = new Distance($row['distance']);
		$distance->setId($row['id']);
		return $distance;
	}
}