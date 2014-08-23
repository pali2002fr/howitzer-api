<?php
namespace Model\Mapper;
use Library\Database\DatabaseAdapterInterface,
	Model\AngleInterface,
	Model\Angle;
	
class AngleMapper extends AbstractDataMapper implements AngleMapperInterface {
	protected $entityTable = "angle";
	
	public function insert(AngleInterface $angle){
		$angle->id = $this->adapter->insert(
			$this->entityTable,
			array(
				'angle' => $angle->angle
			)
		);
		return $angle->id;
	}
	
	public function delete($id){
		if($id instanceOf AngleInterface){
			$id = $id->id;
		}
		
		return $adapter->delete($this->entityTable, "id = $id");
	}
	
	protected function createEntity(array $row){
		$angle = new Angle($row['angle']);
		$angle->setId($row['id']);
		return $angle;
	}
}