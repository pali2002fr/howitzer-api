<?php
namespace Model\Mapper;
use Library\Database\DatabaseAdapterInterface,
	Model\HowitzerInterface,
	Model\Howitzer;
	
class HowitzerMapper extends AbstractDataMapper implements HowitzerMapperInterface {
	protected $entityTable = "howitzer";
	
	public function insert(HowitzerInterface $howitzer){
		$howitzer->id = $this->adapter->insert(
			$this->entityTable,
			array(
				'weight' => $howitzer->weight
			)
		);
		return $howitzer->id;
	}
	
	public function delete($id){
		if($id instanceOf HowitzerInterface){
			$id = $id->id;
		}
		
		return $adapter->delete($this->entityTable, "id = $id");
	}
	
	protected function createEntity(array $row){
		$howitzer = new Howitzer($row['weight']);
		$howitzer->setId($row['id']);
		return $howitzer;
	}
}