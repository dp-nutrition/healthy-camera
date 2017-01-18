<?php
date_default_timezone_set('Asia/Tokyo');
if(false == setlocale(LC_CTYPE, "UTF8", "ja_JP.UTF-8")){
    die("skip setlocale() failed\n");
}
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/controller/IndexController.php';
require_once __DIR__.'/Enum.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$c = new \Slim\Container(['settings'=>$config]); //Create Your container
//Override the default Not Found Handler
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};

$app = new \Slim\App($c);

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('line_bot_logger');
    $file_handler = new \Monolog\Handler\StreamHandler(__DIR__.'/../logs/slim.log');
    $logger->pushHandler($file_handler);
    return $logger;
};

// ルーティング
$app->post('/',function (Request $request, Response $response) {
    $controller = new IndexController();
    $controller->index();
    return $response;
});
$app->get('/',function (Request $request, Response $response) {
    echo "Hello";
    return $response;
});
function error($msg)
{
    global $app;
    $app->getContainer()['logger']->addError($msg);
}

function debug($msg)
{
    global $app;
    if (is_array($msg)){
        foreach ($msg as $m){
            $app->getContainer()['logger']->addDebug($m);
        }
    }else {
        $app->getContainer()['logger']->addDebug($msg);
    }
}
require_once 'db.php';