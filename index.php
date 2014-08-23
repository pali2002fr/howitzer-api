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

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim(array(
        'mode' => 'development'
    ));

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get('/users', function() use ($userMapper) {
    try {
        $users = array();
        $users_obj = $userMapper->findAll();
        foreach ($users_obj as $key => $value) {
            $users[$key]['id'] = $value->getId();
            $users[$key]['name'] = $value->getName();
        }
        echo '{"user": ' . json_encode($users) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/users/:id', function($id) use($userMapper){
    try {

        $user = array();

        $user_obj = $userMapper->findById($id);

        $user['id'] = $user_obj->getId();
        $user['name'] = $user_obj->getName();

        echo '{"user": ' . json_encode($user) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/users', function() use($app, $userMapper){
    
    $params = json_decode($app->request->getBody());

    try {

        $user = new User($params->user);

        $user_id = $userMapper->insert( $user );

        $user = $userMapper->findById($user_id);

        echo '{"user": ' . json_encode($user) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/howitzers', function() use($howitzerMapper){
    try {
        $howitzers = array();
        $howitzers_obj = $howitzerMapper->findAll();

        foreach ($howitzers_obj as $key => $value) {
            $howitzers[$key]['id'] = $value->getId();
            $howitzers[$key]['weight'] = $value->getWeight();
        }
        echo '{"howitzer": ' . json_encode($howitzers) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/howitzers/:id', function($id) use($howitzerMapper){
    try {
        $howitzer = array();
        $howitzers_obj = $howitzerMapper->findById($id);
        $howitzer['id'] = $howitzers_obj->getId();
        $howitzer['weight'] = $howitzers_obj->getWeight();
        echo '{"howitzer": ' . json_encode($howitzer) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/howitzers', function() use($app, $howitzerMapper){
    
    $params = json_decode($app->request->getBody());

    try {

        $howitzer = new Howitzer($params->howitzer);

        $distance_id = $howitzerMapper->insert( $howitzer );

        $howitzer = $howitzerMapper->findById($howitzer_id);

        echo '{"howitzer": ' . json_encode($howitzer) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/distances', function() use($distanceMapper){
    try {
        $distances = array();
        $distances_obj = $distanceMapper->findAll();
        foreach ($distances_obj as $key => $value) {
            $distances[$key]['id'] = $value->getId();
            $distances[$key]['distance'] = $value->getDistance();
        }
        echo '{"distance": ' . json_encode($distances) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/distances/:id', function($id) use($distanceMapper){
    try {
        $distance = array();
        $distance_obj = $distanceMapper->findById($id);
        $distance['id'] = $value->getId();
        $distance['distance'] = $value->getDistance();
        echo '{"distance": ' . json_encode($distance) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/distances', function() use($app, $distanceMapper){
    
    $params = json_decode($app->request->getBody());

    try {

        $distance = new Distance($params->distance);

        $distance_id = $distanceMapper->insert( $distance );

        $distance = $distanceMapper->findById($distance_id);

        echo '{"distance": ' . json_encode($distance) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/targets', function() use($targetMapper){
    try {
        $targets = array();
        $targets_obj = $targetMapper->findAll();
        foreach ($targets_obj as $key => $value) {
            $targets[$key]['id'] = $value->getId();
            $targets[$key]['size'] = $value->getSize();
        }
        echo '{"target": ' . json_encode($targets) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/targets/:id', function($id) use($targetMapper){
    try {
        $target = array();
        $target_obj = $targetMapper->findById($id);
        $target['id'] = $value->getId();
        $target['size'] = $value->getSize();
        echo '{"target": ' . json_encode($target) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/targets', function() use($app, $targetMapper){

    $params = json_decode($app->request->getBody());

    try {

        $target = new Target($params->target);

        $target_id = $targetMapper->insert( $target );

        $target = $targetMapper->findById($target_id);

        echo '{"target": ' . json_encode($target) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/speeds', function() use($speedMapper){
    try {
        $speeds = array();
        $speeds_obj = $speedMapper->findAll();
        foreach ($speeds_obj as $key => $value) {
            $speeds[$key]['id'] = $value->getId();
            $speeds[$key]['speed'] = $value->getSpeed();
        }
        echo '{"speed": ' . json_encode($speeds) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/speeds/:id', function($id) use($speedMapper){
    try {
        $speed = array();
        $speed_obj = $speedMapper->findById($id);
        $speed['id'] = $value->getId();
        $speed['speed'] = $value->getSpeed();
        echo '{"speed": ' . json_encode($speed) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/speed', function() use($app, $speedMapper){

    $params = json_decode($app->request->getBody());

    try {

        $speed = new Speed($params->speed);

        $speed_id = $speedMapper->insert( $speed );

        $speed = $speedMapper->findById($speed_id);

        echo '{"speed": ' . json_encode($speed) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/angles', function() use($angleMapper){
    try {
        $angles = array();
        $angles_obj = $angleMapper->findAll();
        foreach ($angles_obj as $key => $value) {
            $angles[$key]['id'] = $value->getId();
            $angles[$key]['angle'] = $value->getAngle();
        }
        echo '{"angle": ' . json_encode($angles) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/angles/:id', function($id) use($angleMapper){
    try {
        $angle = array();
        $angle_obj = $angleMapper->findById($id);
        $angle['id'] = $value->getId();
        $angle['angle'] = $value->getAngle();
        echo '{"angle": ' . json_encode($angle) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/angles', function() use($app, $angleMapper){

    $params = json_decode($app->request->getBody());

    try {

        $angle = new Angle($params->angle);

        $angle_id = $angleMapper->insert( $angle );

        $angle = $angleMapper->findById($angle_id);

        echo '{"angle": ' . json_encode($angle) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/shots', function() use($shotMapper){
    try {
        $shots = array();
        $shots_obj = $shotMapper->findAll();

        foreach ($shots_obj as $key => $value) {
            $shots[$key]['id'] = $value->getId();
            $shots[$key]['user']['id'] = $value->getUser()->getId();
            $shots[$key]['user']['name'] = $value->getUser()->getName();
            $shots[$key]['howitzer']['id'] = $value->getHowitzer()->getId();
            $shots[$key]['howitzer']['weight'] = $value->getHowitzer()->getWeight();
            $shots[$key]['target']['id'] = $value->getTarget()->getId();
            $shots[$key]['target']['size'] = $value->getTarget()->getSize();
            $shots[$key]['distance']['id'] = $value->getDistance()->getId();
            $shots[$key]['distance']['distance'] = $value->getDistance()->getDistance();
            $shots[$key]['speed']['id'] = $value->getSpeed()->getId();
            $shots[$key]['speed']['speed'] = $value->getSpeed()->getSpeed();
            $shots[$key]['angle']['id'] = $value->getAngle()->getId();
            $shots[$key]['angle']['angle'] = $value->getAngle()->getAngle();
        }
        echo '{"shot": ' . json_encode($shots) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/shots/:id', function($id) use($shotMapper){
    try {
        $shot = array();
        $shot_obj = $shotMapper->findById($id);

        $shot['id'] = $shot_obj->getId();
        $shot['user']['id'] = $shot_obj->getUser()->getId();
        $shot['user']['name'] = $shot_obj->getUser()->getName();
        $shot['howitzer']['id'] = $shot_obj->getHowitzer()->getId();
        $shot['howitzer']['weight'] = $shot_obj->getHowitzer()->getWeight();
        $shot['target']['id'] = $shot_obj->getTarget()->getId();
        $shot['target']['size'] = $shot_obj->getTarget()->getSize();
        $shot['distance']['id'] = $shot_obj->getDistance()->getId();
        $shot['distance']['distance'] = $shot_obj->getDistance()->getDistance();
        $shot['speed']['id'] = $shot_obj->getSpeed()->getId();
        $shot['speed']['speed'] = $shot_obj->getSpeed()->getSpeed();
        $shot['angle']['id'] = $shot_obj->getAngle()->getId();
        $shot['angle']['angle'] = $shot_obj->getAngle()->getAngle();
        echo '{"shot": ' . json_encode($shot) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/shots', function() use($app, $userMapper, $howitzerMapper, $targetMapper, $distanceMapper, $speedMapper, $angleMapper, $shotMapper){
    
    $params = json_decode($app->request()->getBody());

    try {
        $user = $userMapper->findById($params->user_id);
        $howitzer = $howitzerMapper->findById($params->howitzer_id);
        $target = $targetMapper->findById($params->target_id);
        $distance = $distanceMapper->findById($params->distance_id);
        $speed = $speedMapper->findById($params->speed_id);
        $angle = $angleMapper->findById($params->angle_id);

        $shot_id = $shotMapper->insert( 
                                    $user, 
                                    $howitzer, 
                                    $target, 
                                    $distance, 
                                    $speed, 
                                    $angle
                );

        $shot = $shotMapper->findById($shot_id);

        echo '{"shot": ' . json_encode($shot) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/results', function() use($resultMapper){
    try {
        $results = array();
        $results_obj = $resultMapper->findAll();
 
        foreach ($results_obj as $key => $value) {
            $results[$key]['id'] = $value->getId();
            $results[$key]['user']['id'] = $value->getUser()->getId();
            $results[$key]['user']['name'] = $value->getUser()->getName();
            $results[$key]['shot']['howitzer']['id'] = $value->getShot()->getHowitzer()->getId();
            $results[$key]['shot']['howitzer']['name'] = $value->getShot()->getHowitzer()->getWeight();
            $results[$key]['shot']['target']['id'] = $value->getShot()->getTarget()->getId();
            $results[$key]['shot']['target']['size'] = $value->getShot()->getTarget()->getSize();
            $results[$key]['shot']['distance']['id'] = $value->getShot()->getDistance()->getId();
            $results[$key]['shot']['distance']['distance'] = $value->getShot()->getDistance()->getDistance();
            $results[$key]['shot']['speed']['id'] = $value->getShot()->getSpeed()->getId();
            $results[$key]['shot']['speed']['speed'] = $value->getShot()->getSpeed()->getSpeed();
            $results[$key]['shot']['angle']['id'] = $value->getShot()->getAngle()->getId();
            $results[$key]['shot']['angle']['angle'] = $value->getShot()->getAngle()->getAngle();
            $results[$key]['hit'] = $value->getHit();
            $results[$key]['impact'] =  $value->getImpact();
        }
        echo '{"result": ' . json_encode($results) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/results/:id', function($id) use($resultMapper){
    try {
        $result = array();
        $result_obj = $resultMapper->findById($id);
        $result['id'] = $result_obj->getId();
        $result['user']['id'] = $result_obj->getUser()->getId();
        $result['user']['name'] = $result_obj->getUser()->getName();
        $result['shot']['howitzer']['id'] = $result_obj->getShot()->getHowitzer()->getId();
        $result['shot']['howitzer']['weight'] = $result_obj->getShot()->getHowitzer()->getWeight();
        $result['shot']['target']['id'] = $result_obj->getShot()->getTarget()->getId();
        $result['shot']['target']['size'] = $result_obj->getShot()->getTarget()->getSize();
        $result['shot']['distance']['id'] = $result_obj->getShot()->getDistance()->getId();
        $result['shot']['distance']['distance'] = $result_obj->getShot()->getDistance()->getDistance();
        $result['shot']['speed']['id'] = $result_obj->getShot()->getSpeed()->getId();
        $result['shot']['speed']['speed'] = $result_obj->getShot()->getSpeed()->getSpeed();
        $result['shot']['angle']['id'] = $result_obj->getShot()->getAngle()->getId();
        $result['shot']['angle']['angle'] = $result_obj->getShot()->getAngle()->getAngle();
        $result['hit'] = $result_obj->getHit();
        $result['impact'] =  $result_obj->getImpact();
        echo '{"result": ' . json_encode($result) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/results', function() use($app, $userMapper, $shotMapper, $resultMapper){

    $params = json_decode($app->request()->getBody());

    try {
        $user = $userMapper->findById($params->user_id);
        $shot = $shotMapper->findById($params->shot_id);
        $hit = $params->hit;
        $impact = $params->impact;

        $result_id = $resultMapper->insert($shot, $user, $hit, $impact);

        $result = $resultMapper->findById($result_id);

        echo '{"result": ' . json_encode($result) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/top/:limit', function($limit) use($resultMapper){
    try {
        $top = $resultMapper->getTopAcurateUsersByLimit($limit);
        echo '{"top": ' . json_encode($top) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/shots-total', function() use($shotMapper){
    try {
        $total = count($shotMapper->findAll());
        echo '{"total": ' . json_encode($total) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/users-total', function() use($userMapper){
    try {
        $total = count($userMapper->findAll());
        echo '{"total": ' . json_encode($total) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/shots-avg', function() use($shotMapper, $userMapper){
    try {
        $avg = count($shotMapper->findAll())/count($userMapper->findAll());
        echo '{"avg": ' . json_encode($avg) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/ranking', function() use($resultMapper){
    try {
        $ranking = array();
        $ranking_arr = $resultMapper->getRankingAllUsers();

        foreach ($ranking_arr as $key => $value) {
            $ranking[$key]['user']['id'] = $value['user']->getId();
            $ranking[$key]['user']['name'] = $value['user']->getName();
            $ranking[$key]['hits'] = $value['hits'];
        }
        echo '{"ranking": ' . json_encode($ranking) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/shots-total-by-user/:id', function($id) use($shotService){
    try {     
        $total = $shotService->getTotalShotByUser($id);
        echo '{"total": ' . $total . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/calculate-trajectoire/:id', function() use($shotMapper, $shotMapper){
    try {
        $shot = $shotMapper->findById($id);
        $impact = $shotService->calculateTrajectoire($shot);
        echo '{"impact": ' . $impact . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->run();
