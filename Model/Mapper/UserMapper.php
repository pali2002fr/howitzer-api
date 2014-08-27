<?php
namespace Model\Mapper;
use Library\Database\DatabaseAdapterInterface,
	Model\UserInterface,
	Model\User;
	
class UserMapper extends AbstractDataMapper implements UserMapperInterface {
	protected $entityTable = "user";

	public function insert(UserInterface $user){
		$user->id = $this->adapter->insert(
			$this->entityTable,
			array(
				'name' => $user->name,
				'created_date' => date("Y-m-d H:i:s")
			)
		);
		return $user->id;
	}
	
	public function delete($id){
		if($id instanceOf UserInterface){
			$id = $id->id;
		}
		
		return $adapter->delete($this->entityTable, "id = $id");
	}
	
	protected function createEntity(array $row){
		$user = new User($row['name']);
		$user->setId($row['id']);
		return $user ;
	}
}