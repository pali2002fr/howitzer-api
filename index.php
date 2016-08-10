<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
/****** Bootstrap ******/

function autoLoader($className){
    $path = str_replace('\\', '/', $className . '.php');
    if(file_exists($path)) {
        require_once($path);
        return;
    }
    
}
spl_autoload_register('autoLoader');

/****** Bootstrap ******/

use Model\Howitzer,
    Model\Angle,
    Model\User,
    Model\Shot,
    Model\Distance,
    Model\Result,
    Model\Speed,
    Model\Target,
    Library\Database\PdoAdapter,
    Model\Mapper\AngleMapper,
    Model\Mapper\DistanceMapper,
    Model\Mapper\HowitzerMapper,
    Model\Mapper\ResultMapper,
    Model\Mapper\ShotMapper,
    Model\Mapper\SpeedMapper,
    Model\Mapper\TargetMapper,
    Model\Mapper\UserMapper,
    Model\Mapper\TopNumberAcurateUsersMapper,
    Service\ShotService,
    Service\UserService;

require 'Config/Database.php';

// create a PDO adapter
$adapter = new PdoAdapter("mysql:host=" . HOSTNAME . ";dbname=" . DBNAME, USER, PASSWORD );

// create the mappers
$angleMapper = new AngleMapper($adapter);
$distanceMapper = new DistanceMapper($adapter);
$howitzerMapper = new HowitzerMapper($adapter);
$userMapper = new UserMapper($adapter);
$speedMapper = new SpeedMapper($adapter);
$targetMapper = new TargetMapper($adapter);
$shotMapper = new ShotMapper(   $adapter, 
                                $userMapper,
                                $howitzerMapper,
                                $targetMapper,
                                $distanceMapper,
                                $speedMapper,
                                $angleMapper
                            );

$resultMapper = new ResultMapper($adapter, $userMapper, $shotMapper);

$shotService = new ShotService($shotMapper);

require 'Library/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/*
 * Creating new Slim application
 */
$app = new \Slim\Slim(array(
        'mode' => 'development'
    ));
/* 
 * Force th request to be XMLHttpRequest
 */
$app->request->isAjax();


/*
 * Get users
 */
$app->get('/users', function() use ($userMapper, $app) {
    try {
        $app->response()->header("Content-Type", "application/json");
        $users = array();
        $users_obj = $userMapper->findAll();
        if($users_obj){
            foreach ($users_obj as $key => $value) {
                $users[$key]['id'] = $value->getId();
                $users[$key]['name'] = $value->getName();
            }
            echo '{"users": ' . json_encode($users) . '}';
        } else {
            echo '{"warning":{text:"No user!"}}';
        } 
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single user
 */
$app->get('/users/:id', function($id) use($app, $userMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $user = array();
        $user_obj = $userMapper->findById($id);
        if($user_obj){
            $user['id'] = $user_obj->getId();
            $user['name'] = $user_obj->getName();
            echo '{user: ' . json_encode($user) . '}';
        } else {
            echo '{"warning":{text:"User does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new user
 */
$app->post('/users', function() use($app, $userMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $user_exists = $userMapper->findAll('name=' . $params->{'user_name'});
        if(!$user_exists){
            $user = new User($params->{'user_name'});
            $user_id = $userMapper->insert( $user );
            echo '{"user_id": ' . $user_id . '}';
        } else {
            echo '{"warning":{text:"User already exists!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get howitzers
 */
$app->get('/howitzers', function() use($app, $howitzerMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $howitzers = array();
        $howitzers_obj = $howitzerMapper->findAll();
        if($howitzers_obj){
            foreach ($howitzers_obj as $key => $value) {
                $howitzers[$key]['id'] = $value->getId();
                $howitzers[$key]['weight'] = $value->getWeight();
            }
            echo '{"howitzers": ' . json_encode($howitzers) . '}';
        } else {
            echo '{"warning":{text:"No howitzer!"}}';
        } 
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single howitzer
 */
$app->get('/howitzers/:id', function($id) use($app, $howitzerMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $howitzer = array();
        $howitzers_obj = $howitzerMapper->findById($id);
        if($howitzers_obj){
            $howitzer['id'] = $howitzers_obj->getId();
            $howitzer['weight'] = $howitzers_obj->getWeight();
            echo '{"howitzer": ' . json_encode($howitzer) . '}';
        } else {
            echo '{"warning":{text:"Howitzer does not exist!"}}';
        } 
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new howitzer
 */
$app->post('/howitzers', function() use($app, $howitzerMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $howitzer_exists = $howitzerMapper->findAll('weight=' . $params->{'howitzer_weight'});
        if(!$howitzer_exists){
            $howitzer = new Howitzer($params->{'howitzer_weight'});
            $howitzer_id = $howitzerMapper->insert( $howitzer );
            echo '{"howitzer_id": ' . $howitzer_id . '}';
        } else {
            echo '{"warning":{text:"Howitzer already exists!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get distances
 */
$app->get('/distances', function() use($app, $distanceMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $distances = array();
        $distances_obj = $distanceMapper->findAll();
        if($distances_obj){
            foreach ($distances_obj as $key => $value) {
                $distances[$key]['id'] = $value->getId();
                $distances[$key]['distance'] = $value->getDistance();
            }
            echo '{"distances": ' . json_encode($distances) . '}';
        } else {
            echo '{"warning":{text:"No distance!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single distance
 */
$app->get('/distances/:id', function($id) use($app, $distanceMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $distance = array();
        $distance_obj = $distanceMapper->findById($id);
        if($distance_obj){
            $distance['id'] = $distance_obj->getId();
            $distance['distance'] = $distance_obj->getDistance();
            echo '{"distance": ' . json_encode($distance) . '}';
        } else {
            echo '{"warning":{text:"Distance does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new distance
 */
$app->post('/distances', function() use($app, $distanceMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $distance_exists = $distanceMapper->findAll(array('distance=' . $params->{'distance_value'}));
        if(!$distance_exists){
            $distance = new Distance($params->{'distance_value'});
            $distance_id = $distanceMapper->insert( $distance );
            echo '{"distance": ' . $distance_id . '}';
        } else {
            echo '{"warning":{text:"Distance already exists!"}}';
        } 
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get targets
 */
$app->get('/targets', function() use($app, $targetMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $targets = array();
        $targets_obj = $targetMapper->findAll();
        if($targets_obj){
            foreach ($targets_obj as $key => $value) {
                $targets[$key]['id'] = $value->getId();
                $targets[$key]['size'] = $value->getSize();
            }
            echo '{"targets": ' . json_encode($targets) . '}';
        } else {
            echo '{"warning":{text:"No target!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get targets
 */
$app->get('/targets/:id', function($id) use($app, $targetMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $target = array();
        $target_obj = $targetMapper->findById($id);
        if($target_obj){
            $target['id'] = $target_obj->getId();
            $target['size'] = $target_obj->getSize();
            echo '{"target": ' . json_encode($target) . '}';
        } else {
            echo '{"warning":{text:"Target does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new target
 */
$app->post('/targets', function() use($app, $targetMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $target_exists = $targetMapper->findAll(array('target=' . $params->{'target_size'}));
        if(!$target_exists){
            $target = new Target($params->{'target_size'});
            $target_id = $targetMapper->insert( $target );
            echo '{"target": ' . $target_id . '}';
        } else {
            echo '{"warning":{text:"Target already exists!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get speeds
 */
$app->get('/speeds', function() use($app, $speedMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $speeds = array();
        $speeds_obj = $speedMapper->findAll();
        if($speeds_obj){
            foreach ($speeds_obj as $key => $value) {
                $speeds[$key]['id'] = $value->getId();
                $speeds[$key]['speed'] = $value->getSpeed();
            }
            echo '{"speeds": ' . json_encode($speeds) . '}';
        } else {
            echo '{"warning":{text:"No speed!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single speed
 */
$app->get('/speeds/:id', function($id) use($app, $speedMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $speed = array();
        $speed_obj = $speedMapper->findById($id);
        if($speed_obj){
            $speed['id'] = $speed_obj->getId();
            $speed['speed'] = $speed_obj->getSpeed();
            echo '{"speed": ' . json_encode($speed) . '}';
        } else {
            echo '{"warning":{text:"Speed does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new speed
 */
$app->post('/speed', function() use($app, $speedMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $speed_exists = $speedMapper->findAll(array('speed=' . $params->{'speed_value'}));
        if(!$speed_exists){
            $speed = new Speed($params->{'speed_value'});
            $speed_id = $speedMapper->insert( $speed );
            echo '{"speed": ' . $speed_id . '}';
        } else {
            echo '{"warning":{text:"Speed already exists!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get angles
 */
$app->get('/angles', function() use($app, $angleMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $angles = array();
        $angles_obj = $angleMapper->findAll();
        if($angles_obj){
            foreach ($angles_obj as $key => $value) {
                $angles[$key]['id'] = $value->getId();
                $angles[$key]['angle'] = $value->getAngle();
            }
            echo '{"angles": ' . json_encode($angles) . '}';
        } else {
            echo '{"warning":{text:"No angle!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single angle
 */
$app->get('/angles/:id', function($id) use($app, $angleMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $angle = array();
        $angle_obj = $angleMapper->findById($id);
        if($angle_obj){
            $angle['id'] = $angle_obj->getId();
            $angle['angle'] = $angle_obj->getAngle();
            echo '{"angle": ' . json_encode($angle) . '}';
        } else {
            echo '{"warning":{text:"Angle does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new angle
 */
$app->post('/angles', function() use($app, $angleMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $angle_exists = $angleMapper->findAll(array('angle=' . $params->{'angle_value'}));
        if(!$angle_exists){
            $angle = new Angle($params->{'angle_value'});
            $angle_id = $angleMapper->insert( $angle );
            echo '{"angle": ' . $angle_id . '}';
        } else {
            echo '{"warning":{text:"Angle already exists!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get shots
 */
$app->get('/shots', function() use($app, $shotMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $_toJson = array();
        $shots_obj = $shotMapper->findAll();
        if($shots_obj){
            foreach ($shots_obj as $key => $value) {
                $_toJson['shots'][$key]['id'] = $value->getId();
                $_toJson['shots'][$key]['user']['id'] = $value->getUser()->getId();
                $_toJson['shots'][$key]['user']['name'] = $value->getUser()->getName();
                $_toJson['shots'][$key]['howitzer']['id'] = $value->getHowitzer()->getId();
                $_toJson['shots'][$key]['howitzer']['weight'] = $value->getHowitzer()->getWeight();
                $_toJson['shots'][$key]['target']['id'] = $value->getTarget()->getId();
                $_toJson['shots'][$key]['target']['size'] = $value->getTarget()->getSize();
                $_toJson['shots'][$key]['distance']['id'] = $value->getDistance()->getId();
                $_toJson['shots'][$key]['distance']['distance'] = $value->getDistance()->getDistance();
                $_toJson['shots'][$key]['speed']['id'] = $value->getSpeed()->getId();
                $_toJson['shots'][$key]['speed']['speed'] = $value->getSpeed()->getSpeed();
                $_toJson['shots'][$key]['angle']['id'] = $value->getAngle()->getId();
                $_toJson['shots'][$key]['angle']['angle'] = $value->getAngle()->getAngle();
            }
            echo json_encode($_toJson);
        } else {
            echo '{"warning":{text:"No shot!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single shot
 */
$app->get('/shots/:id', function($id) use($app, $shotMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $_toJson['shot'] = array();
        $shot_obj = $shotMapper->findById($id);
        if($shot_obj){
            $_toJson['id'] = $shot_obj->getId();
            $_toJson['user']['id'] = $shot_obj->getUser()->getId();
            $_toJson['user']['name'] = $shot_obj->getUser()->getName();
            $_toJson['howitzer']['id'] = $shot_obj->getHowitzer()->getId();
            $_toJson['howitzer']['weight'] = $shot_obj->getHowitzer()->getWeight();
            $_toJson['target']['id'] = $shot_obj->getTarget()->getId();
            $_toJson['target']['size'] = $shot_obj->getTarget()->getSize();
            $_toJson['distance']['id'] = $shot_obj->getDistance()->getId();
            $_toJson['distance']['distance'] = $shot_obj->getDistance()->getDistance();
            $_toJson['speed']['id'] = $shot_obj->getSpeed()->getId();
            $_toJson['speed']['speed'] = $shot_obj->getSpeed()->getSpeed();
            $_toJson['angle']['id'] = $shot_obj->getAngle()->getId();
            $_toJson['angle']['angle'] = $shot_obj->getAngle()->getAngle();
            echo json_encode($_toJson);
        } else {
            echo '{"warning":{text:"Shot does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new shot
 */
$app->post('/shots', function() use($app, $userMapper, $howitzerMapper, $targetMapper, $distanceMapper, $speedMapper, $angleMapper, $shotMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $proceed = true;
        $user = $userMapper->findById($params->{'user_id'});
        $howitzer = $howitzerMapper->findById($params->{'howitzer_id'});
        $target = $targetMapper->findById($params->{'target_id'});
        $distance = $distanceMapper->findById($params->{'distance_id'});
        $speed = $speedMapper->findById($params->{'speed_id'});
        $angle = $angleMapper->findById($params->{'angle_id'});
        if(!$user) {
            echo '{"warning":{text:"User does not exist!"}}';
            $proceed = false;
        }
        if(!$howitzer) {
            echo '{"warning":{text:"Howitzer does not exist!"}}';
            $proceed = false;
        }
        if(!$target) {
            echo '{"warning":{text:"Target does not exist!"}}';
            $proceed = false;
        }
        if(!$distance) {
            echo '{"warning":{text:"Distance does not exist!"}}';
            $proceed = false;
        }
        if(!$speed) {
            echo '{"warning":{text:"Speed does not exist!"}}';
            $proceed = false;
        }
        if(!$angle) {
            echo '{"warning":{text:"Angle does not exist!"}}';
            $proceed = false;
        }
        if($proceed){
            $shot_id = $shotMapper->insert( 
                                        $user, 
                                        $howitzer, 
                                        $target, 
                                        $distance, 
                                        $speed, 
                                        $angle
                    );
            
            echo '{"shot_id": ' . $shot_id . '}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get results
 */
$app->get('/results', function() use($app, $resultMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $_toJson = array();
        $results_obj = $resultMapper->findAll();
        if($results_obj){
            foreach ($results_obj as $key => $value) {
                $_toJson['results'][$key]['id'] = $value->getId();
                $_toJson['results'][$key]['user']['id'] = $value->getUser()->getId();
                $_toJson['results'][$key]['user']['name'] = $value->getUser()->getName();
                $_toJson['results'][$key]['shot']['howitzer']['id'] = $value->getShot()->getHowitzer()->getId();
                $_toJson['results'][$key]['shot']['howitzer']['name'] = $value->getShot()->getHowitzer()->getWeight();
                $_toJson['results'][$key]['shot']['target']['id'] = $value->getShot()->getTarget()->getId();
                $_toJson['results'][$key]['shot']['target']['size'] = $value->getShot()->getTarget()->getSize();
                $_toJson['results'][$key]['shot']['distance']['id'] = $value->getShot()->getDistance()->getId();
                $_toJson['results'][$key]['shot']['distance']['distance'] = $value->getShot()->getDistance()->getDistance();
                $_toJson['results'][$key]['shot']['speed']['id'] = $value->getShot()->getSpeed()->getId();
                $_toJson['results'][$key]['shot']['speed']['speed'] = $value->getShot()->getSpeed()->getSpeed();
                $_toJson['results'][$key]['shot']['angle']['id'] = $value->getShot()->getAngle()->getId();
                $_toJson['results'][$key]['shot']['angle']['angle'] = $value->getShot()->getAngle()->getAngle();
                $_toJson['results'][$key]['hit'] = $value->getHit();
                $_toJson['results'][$key]['impact'] =  $value->getImpact();
            }
            echo json_encode($_toJson);
        } else {
            echo '{"warning":{text:"No result!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get result
 */
$app->get('/results/:id', function($id) use($app, $resultMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $_toJson = array();
        $result_obj = $resultMapper->findById($id);
        if($result_obj){
            $_toJson['result']['id'] = $result_obj->getId();
            $_toJson['result']['user']['id'] = $result_obj->getUser()->getId();
            $_toJson['result']['user']['name'] = $result_obj->getUser()->getName();
            $_toJson['result']['shot']['howitzer']['id'] = $result_obj->getShot()->getHowitzer()->getId();
            $_toJson['result']['shot']['howitzer']['weight'] = $result_obj->getShot()->getHowitzer()->getWeight();
            $_toJson['result']['shot']['target']['id'] = $result_obj->getShot()->getTarget()->getId();
            $_toJson['result']['shot']['target']['size'] = $result_obj->getShot()->getTarget()->getSize();
            $_toJson['result']['shot']['distance']['id'] = $result_obj->getShot()->getDistance()->getId();
            $_toJson['result']['shot']['distance']['distance'] = $result_obj->getShot()->getDistance()->getDistance();
            $_toJson['result']['shot']['speed']['id'] = $result_obj->getShot()->getSpeed()->getId();
            $_toJson['result']['shot']['speed']['speed'] = $result_obj->getShot()->getSpeed()->getSpeed();
            $_toJson['result']['shot']['angle']['id'] = $result_obj->getShot()->getAngle()->getId();
            $_toJson['result']['shot']['angle']['angle'] = $result_obj->getShot()->getAngle()->getAngle();
            $_toJson['result']['hit'] = $result_obj->getHit();
            $_toJson['result']['impact'] =  $result_obj->getImpact();
            echo json_encode($_toJson);
        } else {
            echo '{"warning":{text:"Result does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new result
 */
$app->post('/results', function() use($app, $userMapper, $shotMapper, $resultMapper){
    $params = json_decode($app->request()->getBody());
    try {
        $app->response()->header("Content-Type", "application/json");
        $_toJson = array();
        $user = $userMapper->findById($params->{'user_id'});
        $shot = $shotMapper->findById($params->{'shot_id'});
        $hit = $params->{'hit'};
        $impact = $params->{'impact'};
        $_toJson['result_id'] = $resultMapper->insert($shot, $user, $hit, $impact);
        echo json_encode($_toJson);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get top best shotters
 */
$app->get('/top/:limit', function($limit) use($app, $resultMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $top = array();
        $top_arr = $resultMapper->getTopAcurateUsersByLimit($limit);
        if($top_arr){
            foreach ($top_arr as $key => $value) {
                $top[$key]['user']['id'] = $value['user']->getId();
                $top[$key]['user']['name'] = $value['user']->getName();
                $top[$key]['hits'] = $value['hits'];
                $top[$key]['avg-closed-target'] = $value['avg-closed-target'];
            }
            echo '{"top": ' . json_encode($top) . ',"limit": ' . $limit . '}';
        } else {
            echo '{"warning":{text:"No top!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get total shots
 */
$app->get('/shots-total', function() use($app, $shotMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $total = count($shotMapper->findAll());
        echo '{"total": ' . json_encode($total) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get total users
 */
$app->get('/users-total', function() use($app, $userMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $total = count($userMapper->findAll());
        echo '{"total": ' . json_encode($total) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get average shot by user
 */
$app->get('/shots-avg', function() use($app, $shotMapper, $userMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $avg = count($shotMapper->findAll())/count($userMapper->findAll());
        echo '{"avg": ' . json_encode(number_format($avg, 2)) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get ranking by user
 */
$app->get('/ranking', function() use($app, $resultMapper){
    try {
        $app->response()->header("Content-Type", "application/json");
        $ranking = array();
        $ranking_arr = $resultMapper->getRankingAllUsers();
        if($ranking_arr){
            foreach ($ranking_arr as $key => $value) {
                $ranking[$key]['user']['id'] = $value['user']->getId();
                $ranking[$key]['user']['name'] = $value['user']->getName();
                $ranking[$key]['hits'] = $value['hits'];
            }
            echo '{"rankings": ' . json_encode($ranking) . '}';
        } else {
            echo '{"warning":{text:"No ranking!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get total shots by user
 */
$app->get('/shots-total-by-user/:id', function($id) use($app, $shotService){
    try {
        $app->response()->header("Content-Type", "application/json");    
        $total = $shotService->getTotalShotByUser($id);
        echo '{"total": ' . $total . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get calculate impact on target
 */
$app->get('/calculate-trajectoire/:id', function($id) use($app, $shotMapper, $shotService){
    try {
        $app->response()->header("Content-Type", "application/json");
        $_toJson = array();
        $shot = $shotMapper->findById($id);
        if($shot){
            $impact = $shotService->calculateTrajectoire($shot);
            $_toJson['impact'] = $impact;
            $_toJson['user_id'] = $shot->getUser()->getId();
            $_toJson['shot_id'] = $shot->getId();
            $_toJson['hit'] = $impact == 0 ? 1 : 0;
            echo json_encode($_toJson);
        } else {
            echo '{"warning":{text:"Shot does not exist!"}}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get(
    '/',
    function () {
        $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Slim Framework for PHP 5</title>
            <style>
                html,body,div,span,object,iframe,
                h1,h2,h3,h4,h5,h6,p,blockquote,pre,
                abbr,address,cite,code,
                del,dfn,em,img,ins,kbd,q,samp,
                small,strong,sub,sup,var,
                b,i,
                dl,dt,dd,ol,ul,li,
                fieldset,form,label,legend,
                table,caption,tbody,tfoot,thead,tr,th,td,
                article,aside,canvas,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section,summary,
                time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
                body{line-height:1;}
                article,aside,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section{display:block;}
                nav ul{list-style:none;}
                blockquote,q{quotes:none;}
                blockquote:before,blockquote:after,
                q:before,q:after{content:'';content:none;}
                a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent;}
                ins{background-color:#ff9;color:#000;text-decoration:none;}
                mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold;}
                del{text-decoration:line-through;}
                abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help;}
                table{border-collapse:collapse;border-spacing:0;}
                hr{display:block;height:1px;border:0;border-top:1px solid #cccccc;margin:1em 0;padding:0;}
                input,select{vertical-align:middle;}
                html{ background: #EDEDED; height: 100%; }
                body{background:#FFF;margin:0 auto;min-height:100%;padding:0 30px;width:440px;color:#666;font:14px/23px Arial,Verdana,sans-serif;}
                h1,h2,h3,p,ul,ol,form,section{margin:0 0 20px 0;}
                h1{color:#333;font-size:20px;}
                h2,h3{color:#333;font-size:14px;}
                h3{margin:0;font-size:12px;font-weight:bold;}
                ul,ol{list-style-position:inside;color:#999;}
                ul{list-style-type:square;}
                code,kbd{background:#EEE;border:1px solid #DDD;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:0 4px;color:#666;font-size:12px;}
                pre{background:#EEE;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:5px 10px;color:#666;font-size:12px;}
                pre code{background:transparent;border:none;padding:0;}
                a{color:#70a23e;}
                header{padding: 30px 0;text-align:center;}
                code {
                    display:block;
                }
            </style>
        </head>
        <body>
            <header>
            </header>
            <h1>Welcome!</h1>
            <p>
                Here is a Howitzer Game application as my sample code.<br>
                <b>How it works</b> : You pick a user, weight of howitzer, distance of target, size of the target, speed, angle of shot and you fire.
                The results are saved in the database and a stats are processed against that.
                <br/><br/
                <b>Demo:</b> <a href="http://ec2-52-90-251-194.compute-1.amazonaws.com/public/">http://ec2-52-90-251-194.compute-1.amazonaws.com/public/</a>
            </p>
            <section>
                <h2>Technologies</h2>
                <ul>
                    <li>Linux(Amazon Web Services Cloud) : Ubuntu 12
                    <li>Apache : Apache</li>
                    <li>Mysql : version 5.5</li>
                    <li>PHP : PHP 5 & Framework Slim</li>
                    <li>HTML / CSS : Bootstrap Library</li>
                    <li>Javascrpit : Straight Javascrpit, Jquery, Handlebars</li>
                </ul>
            </section>
            <section>
                <h1>API</h1>
                <section>
                    <h2>Show Multiple user</h2>
                    <p>Returns json data about a multiple users.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/users</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"user": [{"id":"1","name":"user_1"},{"id":"2","name":"user_2"}]}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single User</h2>
                    <p>Returns json data about a single user.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/users/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{ id : 12, name : "Michael Bloom" }</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create User</h2>
                    <p>Returns json data about user ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/users</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p><i>Required:</i> `name=[alpha numeric]`</p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{user_id: 12}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Howitzer</h2>
                    <p>Returns json data about a multiple howitzers.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/howitzers</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"howitzer": [{"id":"1","weight":"1000"},{"id":"2","weight":"2000"}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Howitzer</h2>
                    <p>Returns json data about a single howitzer.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/howitzers/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"howitzer": {"id":"1","weight":"1000"}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Howitzer</h2>
                    <p>Returns json data about howitzer ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/howitzers</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p><i>Required:</i> `weight = [integer]`</p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{howitzer_id: 13}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Distance</h2>
                    <p>Returns json data about a multiple distances.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/distances</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"distances": [{"id":"1","distance":"1000"},{"id":"2","distance":"2000"}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Distance</h2>
                    <p>Returns json data about a single distance.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/distances/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id = [integer]`
                    </p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"distance": {"id":"1","distance":"1000"}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Distance</h2>
                    <p>Returns json data about distance ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/distances</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p><i>Required:</i> `distance=[alphanumeric]`</p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{distance_id: 16}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Target</h2>
                    <p>Returns json data about a multiple targets.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/targets</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"targets": [{"id":"1","size":"10"},{"id":"2","size":"20"}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Target</h2>
                    <p>Returns json data about a single target.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/targets/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`
                    </p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"target": {"id":"1","size":"10"}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Target</h2>
                    <p>Returns json data about target ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/targets</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p><i>Required:</i> `size=[integer]`</p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{target_id: 16}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Speed</h2>
                    <p>Returns json data about a multiple speeds.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/speeds</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"speeds": [{"id":"1","speed":"10"},{"id":"2","speed":"20"}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Speed</h2>
                    <p>Returns json data about a single speed.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/speeds/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`
                    </p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"speed": {"id":"1","speed":"10"}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Speed</h2>
                    <p>Returns json data about speed ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/speeds</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p><i>Required:</i> `speed=[integer]`</p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{speed_id: 16}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Angle</h2>
                    <p>Returns json data about a multiple angles.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/angles</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"angles": [{"id":"1","angle":"10"},{"id":"2","angle":"20"}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Angle</h2>
                    <p>Returns json data about a single angle.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/angles/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`
                    </p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"angle": {"id":"1","angle":"10"}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Angle</h2>
                    <p>Returns json data about angle ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/angles</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p><i>Required:</i> `angle=[integer]`</p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{angle_id: 16}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Shot</h2>
                    <p>Returns json data about a multiple shots.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"shots": [{"id":"1","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},{"id":"21","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"5","angle":"25"}}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Shot</h2>
                    <p>Returns json data about a single shot.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`
                    </p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"shot": {"id":"1","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Shot</h2>
                    <p>Returns json data about shot ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p>
                        <i>Required:</i>
                        <ul style="margin-left: 30px;">
                            <li>angle_id = [integer]</li>
                            <li>howitzer_id = [integer]</li>
                            <li>target_id = [integer]</li>
                            <li>distance_id = [integer]</li>
                            <li>speed_id = [integer]</li>
                            <li>user_id = [integer]</li>
                        </ul>
                    </p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"shot_id": 19}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Get List Result</h2>
                    <p>Returns json data about a multiple results.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/results</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"results": [{"id":"1","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},{"id":"21","user":{"id":"1","name":"user_1"},"howitzer":{"id":"1","weight":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"5","angle":"25"}}]}</code></li>
                    <ul>
                </section>
                <hr>
                <section>
                    <h2>Show Single Result</h2>
                    <p>Returns json data about a single shot.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/results/:id</p>
                    <h4>Method</h4>
                    <p>GET</p>
                    <h4>URL Params</h4>
                    <p>
                        <i>Required:</i> `id=[integer]`
                    </p>
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"result": {"id":"1","user":{"id":"1","name":"user_1"},"shot":{"howitzer":{"id":"1","name":"1000"},"target":{"id":"1","size":"10"},"distance":{"id":"1","distance":"100"},"speed":{"id":"1","speed":"5"},"angle":{"id":"1","angle":"5"}},"hit":"1","impact":"0"}}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Create Result</h2>
                    <p>Returns json data about result ID.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/results</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p>
                        <i>Required:</i>
                        <ul style="margin-left: 30px;">
                            <li>user_id = [integer]</li>
                            <li>shot_id = [integer]</li>
                            <li>hit = [integer]</li>
                            <li>impact = [integer]</li>
                        </ul>
                    </p>
                    
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"result_id": 19}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show List Top Best Shotters</h2>
                    <p>Returns json data about a Top Best Shotters.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/top/:limit</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>limit = [integer]</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"top": [{"user":{"id":"1","name":"user_1"},"hits":"4","avg-closed-target":"88.8800"},{"user":{"id":"5","name":"user_5"},"hits":"0","avg-closed-target":"282.0000"}]}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Total Shots</h2>
                    <p>Returns json data about a total shotters.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-total</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"total": 31}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Total Users</h2>
                    <p>Returns json data about a Total users.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/users-total</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"total": 31}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Average Shot</h2>
                    <p>Returns json data about average shot.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-avg</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"avg": 2.88}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Ranking by User</h2>
                    <p>Returns json data about ranking by user.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-avg</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>None</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"ranking": [{"user":{"id":"1","name":"user_1"},"hits":"4"}]}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Total Shots by User</h2>
                    <p>Returns json data about total shots by user.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/shots-total-by-user/:id</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>id = [integer]</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"total": 25}</code></li>
                    </ul>
                </section>
                <hr>
                <section>
                    <h2>Show Calculate Impact on Target</h2>
                    <p>Returns json data about calculate impact on target.</p>
                    <h4>URL</h4>
                    <p>http://ec2-52-90-251-194.compute-1.amazonaws.com/calculate-trajectoire/:id</p>
                    <h4>Method</h4>
                    <p>POST</p>
                    <h4>URL Params</h4>
                    <p>id = [integer]</p>
                        
                    <h4>Data Params</h4>
                    <p>None</p>
                    <h4>Success Response:</h4>
                    <ul>
                        <li><b>Code</b>: 200</li>
                        <li><b>Content</b>: <code>{"impact":101.38639426832,"user_id":"1","shot_id":"1","hit":0}</code></li>
                    </ul>
                </section>
            </section>
        </body>
    </html>
EOT;
        echo $template;
    }
);

/*
* Runing the Slim app
*/
$app->run();
