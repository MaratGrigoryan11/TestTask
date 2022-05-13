<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$_POST = json_decode(file_get_contents("php://input"), true);
define('ENV', include 'env.php');

require_once 'Router.php';
require_once 'Controllers/HomeController.php';
require_once 'Models/Interfaces/Model.php';
require_once 'Models/Model.php';
require_once 'Models/RedisModel.php';
require_once 'Models/Post.php';
require_once 'Controllers/PostController.php';


$router = new Router;

try {
    $router();
} catch (Exception $e) {
    //todo add exception handler and handle exceptions for example 404 500 ...
}
