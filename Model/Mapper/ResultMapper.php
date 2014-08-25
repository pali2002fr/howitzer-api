<?php
namespace Model\Mapper;
use Library\Database\DatabaseAdapterInterface,
	Model\ResultInterface,
	Model\ShotInterface,
	Model\UserInterface,
	Model\Result,
	Model\Shot,
	Model\User;
	
class ResultMapper extends AbstractDataMapper implements ResultMapperInterface {
	protected $userMapper;
	protected $shotMapper;
	protected $entityTable = "result";
	
	public function __construct(DatabaseAdapterInterface $adapter, 
								UserMapperInterface $userMapper,
								ShotMapperInterface $shotMapper){
		$this->userMapper = $userMapper;
		$this->shotMapper = $shotMapper;
		parent::__construct($adapter);
	}

	public function insert(ShotInterface $shot, UserInterface $user, $hit, $impact){
		return $this->adapter->insert(
			$this->entityTable,
			array(
				'id_shot' => $shot->getId(),
				'id_user' => $user->getId(),
				'hit' => $hit,
				'impact' => $impact
			)
		);
	}
	
	public function delete($id){
		if($id instanceOf ResultInterface){
			$id = $id->id;
		}
		return $adapter->delete($this->entityTable, "id = $id");
	}
	
	public function getTopAcurateUsersByLimit($number){
		$sql = "SELECT id_user, sum(hit) as 'hits', AVG(impact) as 'avg'
								FROM result
								GROUP BY  id_user
								ORDER BY hits DESC
								LIMIT " . $number;

		$this->adapter->prepare($sql)->execute();
		$rows = $this->adapter->fetchAll();
		foreach($rows as $row){
			$user = $this->userMapper->findById($row['id_user']);
			$return[] = array(
								'user' => $user,
								'hits' => $row['hits'],
								'avg-closed-target' => $row['avg']
						);
		}
		return $return;
	}
	
	public function getRankingAllUsers(){
		$sql = "SELECT id_user, sum(hit) as 'hits'
				FROM result
				GROUP BY  id_user
				ORDER BY hits DESC";

		$this->adapter->prepare($sql)->execute();
		$rows = $this->adapter->fetchAll();
		foreach($rows as $row){
			$user = $this->userMapper->findById($row['id_user']);
			$return[] = array(
								'user' => $user,
								'hits' => $row['hits']
						);
		}
		return $return;
	}
	
	protected function createEntity(array $row){
		$user = $this->userMapper->findById($row["id_user"]);
		$shot = $this->shotMapper->findById($row["id_shot"]);
		$result = new Result($shot, $user, $row['hit'], $row['impact']);
		$result->setId($row['id']);
		return $result;
	}
}

