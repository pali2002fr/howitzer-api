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
        $users = array();
        $users_obj = $userMapper->findAll();
        foreach ($users_obj as $key => $value) {
            $users[$key]['id'] = $value->getId();
            $users[$key]['name'] = $value->getName();
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"user": ' . json_encode($users) . '}';
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
        $user['id'] = $user_obj->getId();
        $user['name'] = $user_obj->getName();
        echo '{"user": ' . json_encode($user) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new user
 */
$app->post('/users', function() use($app, $userMapper){
    $params = $app->request()->post();
    try {
        $user = new \Model\User($params->user_id);
        $user_id = $userMapper->insert( $user );
        $user = $userMapper->findById($user_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"user": ' . json_encode($user) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get howitzers
 */
$app->get('/howitzers', function() use($app, $howitzerMapper){
    try {
        $howitzers = array();
        $howitzers_obj = $howitzerMapper->findAll();
        foreach ($howitzers_obj as $key => $value) {
            $howitzers[$key]['id'] = $value->getId();
            $howitzers[$key]['weight'] = $value->getWeight();
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"howitzer": ' . json_encode($howitzers) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single howitzer
 */
$app->get('/howitzers/:id', function($id) use($app, $howitzerMapper){
    try {
        $howitzer = array();
        $howitzers_obj = $howitzerMapper->findById($id);
        $howitzer['id'] = $howitzers_obj->getId();
        $howitzer['weight'] = $howitzers_obj->getWeight();
        $app->response()->header("Content-Type", "application/json");
        echo '{"howitzer": ' . json_encode($howitzer) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new howitzer
 */
$app->post('/howitzers', function() use($app, $howitzerMapper){
    $params = $app->request()->post();
    try {
        $howitzer = new \Model\Howitzer($params->howitzer_weight);
        $distance_id = $howitzerMapper->insert( $howitzer );
        $howitzer = $howitzerMapper->findById($howitzer_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"howitzer": ' . json_encode($howitzer) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get distances
 */
$app->get('/distances', function() use($app, $distanceMapper){
    try {
        $distances = array();
        $distances_obj = $distanceMapper->findAll();
        foreach ($distances_obj as $key => $value) {
            $distances[$key]['id'] = $value->getId();
            $distances[$key]['distance'] = $value->getDistance();
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"distance": ' . json_encode($distances) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single distance
 */
$app->get('/distances/:id', function($id) use($app, $distanceMapper){
    try {
        $distance = array();
        $distance_obj = $distanceMapper->findById($id);
        $distance['id'] = $value->getId();
        $distance['distance'] = $value->getDistance();
        $app->response()->header("Content-Type", "application/json");
        echo '{"distance": ' . json_encode($distance) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new distance
 */
$app->post('/distances', function() use($app, $distanceMapper){
    $params = $app->request()->post();
    try {
        $distance = new \Model\Distance($params->distance_value);
        $distance_id = $distanceMapper->insert( $distance );
        $distance = $distanceMapper->findById($distance_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"distance": ' . json_encode($distance) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get targets
 */
$app->get('/targets', function() use($app, $targetMapper){
    try {
        $targets = array();
        $targets_obj = $targetMapper->findAll();
        foreach ($targets_obj as $key => $value) {
            $targets[$key]['id'] = $value->getId();
            $targets[$key]['size'] = $value->getSize();
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"target": ' . json_encode($targets) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get targets
 */
$app->get('/targets/:id', function($id) use($app, $targetMapper){
    try {
        $target = array();
        $target_obj = $targetMapper->findById($id);
        $target['id'] = $value->getId();
        $target['size'] = $value->getSize();
        $app->response()->header("Content-Type", "application/json");
        echo '{"target": ' . json_encode($target) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new target
 */
$app->post('/targets', function() use($app, $targetMapper){
    $params = $app->request()->post();
    try {
        $target = new \Model\Target($params->target_size);
        $target_id = $targetMapper->insert( $target );
        $target = $targetMapper->findById($target_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"target": ' . json_encode($target) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get speeds
 */
$app->get('/speeds', function() use($app, $speedMapper){
    try {
        $speeds = array();
        $speeds_obj = $speedMapper->findAll();
        foreach ($speeds_obj as $key => $value) {
            $speeds[$key]['id'] = $value->getId();
            $speeds[$key]['speed'] = $value->getSpeed();
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"speed": ' . json_encode($speeds) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single speed
 */
$app->get('/speeds/:id', function($id) use($app, $speedMapper){
    try {
        $speed = array();
        $speed_obj = $speedMapper->findById($id);
        $speed['id'] = $value->getId();
        $speed['speed'] = $value->getSpeed();
        $app->response()->header("Content-Type", "application/json");
        echo '{"speed": ' . json_encode($speed) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new speed
 */
$app->post('/speed', function() use($app, $speedMapper){
    $params = $app->request()->post();
    try {
        $speed = new \Model\Speed($params->speed_value);
        $speed_id = $speedMapper->insert( $speed );
        $speed = $speedMapper->findById($speed_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"speed": ' . json_encode($speed) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get angles
 */
$app->get('/angles', function() use($app, $angleMapper){
    try {
        $angles = array();
        $angles_obj = $angleMapper->findAll();
        foreach ($angles_obj as $key => $value) {
            $angles[$key]['id'] = $value->getId();
            $angles[$key]['angle'] = $value->getAngle();
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"angle": ' . json_encode($angles) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single angle
 */
$app->get('/angles/:id', function($id) use($app, $angleMapper){
    try {
        $angle = array();
        $angle_obj = $angleMapper->findById($id);
        $angle['id'] = $value->getId();
        $angle['angle'] = $value->getAngle();
        $app->response()->header("Content-Type", "application/json");
        echo '{"angle": ' . json_encode($angle) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new angle
 */
$app->post('/angles', function() use($app, $angleMapper){
    $params = $app->request()->post();
    try {
        $angle = new \Model\Angle($params->angle_value);
        $angle_id = $angleMapper->insert( $angle );
        $angle = $angleMapper->findById($angle_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"angle": ' . json_encode($angle) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get shots
 */
$app->get('/shots', function() use($app, $shotMapper){
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
        $app->response()->header("Content-Type", "application/json");
        echo '{"shot": ' . json_encode($shots) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get single shot
 */
$app->get('/shots/:id', function($id) use($app, $shotMapper){
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
        $app->response()->header("Content-Type", "application/json");
        echo '{"shot": ' . json_encode($shot) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Create new shot
 */
$app->post('/shots', function() use($app, $userMapper, $howitzerMapper, $targetMapper, $distanceMapper, $speedMapper, $angleMapper, $shotMapper){
    $params = json_decode($app->request()->getBody());
    error_log($params->{'user_id'},0);
    try {
        $user = $userMapper->findById($params->{'user_id'});
        $howitzer = $howitzerMapper->findById($params->{'howitzer_id'});
        $target = $targetMapper->findById($params->{'target_id'});
        $distance = $distanceMapper->findById($params->{'distance_id'});
        $speed = $speedMapper->findById($params->{'speed_id'});
        $angle = $angleMapper->findById($params->{'angle_id'});
        $shot_id = $shotMapper->insert( 
                                    $user, 
                                    $howitzer, 
                                    $target, 
                                    $distance, 
                                    $speed, 
                                    $angle
                );
        
        $shot = $shotMapper->findById($shot_id);
        error_log(json_encode($shot), 0);
        $app->response()->header("Content-Type", "application/json");
        echo '{"shot": ' . json_encode($shot) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get results
 */
$app->get('/results', function() use($app, $resultMapper){
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
        $app->response()->header("Content-Type", "application/json");
        echo '{"result": ' . json_encode($results) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get result
 */
$app->get('/results/:id', function($id) use($app, $resultMapper){
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
        $app->response()->header("Content-Type", "application/json");
        echo '{"result": ' . json_encode($result) . '}';
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
        $user = $userMapper->findById($params->user_id);
        $shot = $shotMapper->findById($params->shot_id);
        $hit = $params->hit;
        $impact = $params->impact;
        $result_id = $resultMapper->insert($shot, $user, $hit, $impact);
        $result = $resultMapper->findById($result_id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"result": ' . json_encode($result) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get top best shotters
 */
$app->get('/top/:limit', function($limit) use($app, $resultMapper){
    try {
        $top = array();
        $top_arr = $resultMapper->getTopAcurateUsersByLimit($limit);
        foreach ($top_arr as $key => $value) {
            $top[$key]['user']['id'] = $value['user']->getId();
            $top[$key]['user']['name'] = $value['user']->getName();
            $top[$key]['hits'] = $value['hits'];
            $top[$key]['avg-closed-target'] = $value['avg-closed-target'];
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"top": ' . json_encode($top) . ',"limit": ' . $limit . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get total shots
 */
$app->get('/shots-total', function() use($app, $shotMapper){
    try {
        $total = count($shotMapper->findAll());
        $app->response()->header("Content-Type", "application/json");
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
        $total = count($userMapper->findAll());
        $app->response()->header("Content-Type", "application/json");
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
        $avg = count($shotMapper->findAll())/count($userMapper->findAll());
        $app->response()->header("Content-Type", "application/json");
        echo '{"avg": ' . json_encode($avg) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get ranking by user
 */
$app->get('/ranking', function() use($app, $resultMapper){
    try {
        $ranking = array();
        $ranking_arr = $resultMapper->getRankingAllUsers();
        foreach ($ranking_arr as $key => $value) {
            $ranking[$key]['user']['id'] = $value['user']->getId();
            $ranking[$key]['user']['name'] = $value['user']->getName();
            $ranking[$key]['hits'] = $value['hits'];
        }
        $app->response()->header("Content-Type", "application/json");
        echo '{"ranking": ' . json_encode($ranking) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get total shots by user
 */
$app->get('/shots-total-by-user/:id', function($id) use($app, $shotService){
    try {     
        $total = $shotService->getTotalShotByUser($id);
        $app->response()->header("Content-Type", "application/json");
        echo '{"total": ' . $total . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

/*
 * Get calculate impact on target
 */
$app->get('/calculate-trajectoire/:id', function($id) use($app, $shotMapper, $shotMapper){
    try {
        $shot = $shotMapper->findById($id);
        $impact = $shotService->calculateTrajectoire($shot);
        $app->response()->header("Content-Type", "application/json");
        echo '{"impact": ' . $impact . '}';
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
            </style>
        </head>
        <body>
            <header>
                <a href="http://www.slimframework.com"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHIAAAA6CAYAAABs1g18AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABRhJREFUeNrsXY+VsjAMR98twAo6Ao4gI+gIOIKOgCPICDoCjCAjXFdgha+5C3dcv/QfFB5i8h5PD21Bfk3yS9L2VpGnlGW5kS9wJMTHNRxpmjYRy6SycgRvL18OeMQOTYQ8HvIoJKiiz43hgHkq1zvK/h6e/TyJQXeV/VyWBOSHA4C5RvtMAiCc4ZB9FPjgRI8+YuKcrySO515a1hoAY3nc4G2AH52BZsn+MjaAEwIJICKAIR889HljMCcyrR0QE4v/q/BVBQva7Q1tAczG18+x+PvIswHEAslLbfGrMZKiXEOMAMy6LwlisQCJLPFMfKdBtli5dIihRyH7A627Iaiq5sJ1ThP9xoIgSdWSNVIHYmrTQgOgRyRNqm/M5PnrFFopr3F6B41cd8whRUSufUBU5EL4U93AYRnIWimCIiSI1wAaAZpJ9bPnxx8eyI3Gt4QybwWa6T/BvbQECUMQFkhd3jSkPFgrxwcynuBaNT/u6eJIlbGOBWSNIUDFEIwPZFAtBfYrfeIOSRSXuUYCsprCXwUIZWYnmEhJFMIocMDWjn206c2EsGLCJd42aWSyBNMnHxLEq7niMrY2qyDbQUbqrrTbwUPtxN1ZZCitQV4ZSd6DyoxhmRD6OFjuRUS/KdLGRHYowJZaqYgjt9Lchmi3QYA/cXBsHK6VfWNR5jgA1DLhwfFe4HqfODBpINEECCLO47LT/+HSvSd/OCOgQ8qE0DbHQUBqpC4BkKMPYPkFY4iAJXhGAYr1qmaqQDbECCg5A2NMchzR567aA4xcRKclI405Bmt46vYD7/Gcjqfk6GP/kh1wovIDSHDfiAs/8bOCQ4cf4qMt7eH5Cucr3S0aWGFfjdLHD8EhCFvXQlSqRrY5UV2O9cfZtk77jUFMXeqzCEZqSK4ICkSin2tE12/3rbVcE41OBjBjBPSdJ1N5lfYQpIuhr8axnyIy5KvXmkYnw8VbcwtTNj7fDNCmT2kPQXA+bxpEXkB21HlnSQq0gD67jnfh5KavVJa/XQYEFSaagWwbgjNA+ywstLpEWTKgc5gwVpsyO1bTII+tA6B7BPS+0PiznuM9gPKsPVXbFdADMtwbJxSmkXWfRh6AZhyyzBjIHoDmnCGaMZAKjd5hyNJYCBGDOVcg28AXQ5atAVDO3c4dSALQnYblfa3M4kc/cyA7gMIUBQCTyl4kugIpy8yA7ACqK8Uwk30lIFGOEV3rPDAELwQkr/9YjkaCPDQhCcsrAYlF1v8W8jAEYeQDY7qn6tNGWudfq+YUEr6uq6FZzBpJMUfWFDatLHMCciw2mRC+k81qCCA1DzK4aUVfrJpxnloZWCPVnOgYy8L3GvKjE96HpweQoy7iwVQclVutLOEKJxA8gaRCjSzgNI2zhh3bQhzBCQQPIHGaHaUd96GJbZz3Smmjy16u6j3FuKyNxcBarxqWWfYFE0tVVO1Rl3t1Mb05V00MQCJ71YHpNaMcsjWAfkQvPPkaNC7LqTG7JAhGXTKYf+VDeXAX9IvURoAwtTFHvyYIxtnd5tPkywrPafcwbeSuGVwFau3b76NO7SHQrvqhfFE8kM0Wvpv8gVYiYBlxL+fW/34bgP6bIC7JR7YPDubcHCPzIp4+cum7U6NlhZgK7lua3KGLeFwE2m+HblDYWSHG2SAfINuwBBfxbJEIuWZbBH4fAExD7cvaGVyXyH0dhiAYc92z3ZDfUVv+jgb8HrHy7WVO/8BFcy9vuTz+nwADAGnOR39Yg/QkAAAAAElFTkSuQmCC" alt="Slim"/></a>
            </header>
            <h1>Welcome to Slim!</h1>
            <p>
                Congratulations! Your Slim application is running. If this is
                your first time using Slim, start with this <a href="http://www.slimframework.com/learn" target="_blank">"Hello World" Tutorial</a>.
            </p>
            <section>
                <h2>Get Started</h2>
                <ol>
                    <li>The application code is in <code>index.php</code></li>
                    <li>Read the <a href="http://docs.slimframework.com/" target="_blank">online documentation</a></li>
                    <li>Follow <a href="http://www.twitter.com/slimphp" target="_blank">@slimphp</a> on Twitter</li>
                </ol>
            </section>
            <section>
                <h2>Slim Framework Community</h2>

                <h3>Support Forum and Knowledge Base</h3>
                <p>
                    Visit the <a href="http://help.slimframework.com" target="_blank">Slim support forum and knowledge base</a>
                    to read announcements, chat with fellow Slim users, ask questions, help others, or show off your cool
                    Slim Framework apps.
                </p>

                <h3>Twitter</h3>
                <p>
                    Follow <a href="http://www.twitter.com/slimphp" target="_blank">@slimphp</a> on Twitter to receive the very latest news
                    and updates about the framework.
                </p>
            </section>
            <section style="padding-bottom: 20px">
                <h2>Slim Framework Extras</h2>
                <p>
                    Custom View classes for Smarty, Twig, Mustache, and other template
                    frameworks are available online in a separate repository.
                </p>
                <p><a href="https://github.com/codeguy/Slim-Extras" target="_blank">Browse the Extras Repository</a></p>
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
