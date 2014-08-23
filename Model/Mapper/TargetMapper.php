<?php
namespace Model\Mapper;
use Library\Database\DatabaseAdapterInterface,
	Model\TargetInterface,
	Model\Target;
	
class TargetMapper extends AbstractDataMapper implements TargetMapperInterface {
	protected $entityTable = "target";
	
	public function insert(TargetInterface $target){
		$target->id = $this->adapter->insert(
			$this->entityTable,
			array(
				'size' => $target->size
			)
		);
		return $target->id;
	}
	
	public function delete($id){
		if($id instanceOf TargetInterface){
			$id = $id->id;
		}
		
		return $adapter->delete($this->entityTable, "id = $id");
	}
	
	protected function createEntity(array $row){
		$target = new Target($row['size']);
		$target->setId($row['id']);
		return $target;
	}
}