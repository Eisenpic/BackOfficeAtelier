<?php

use mf\router\Router;
use mf\utils\ClassLoader;
use \mf\auth\Authentification;

require_once 'vendor/autoload.php';
require_once 'src/mf/utils/AbstractClassLoader.php';
require_once 'src/mf/utils/ClassLoader.php';


$loader = new ClassLoader('src');
$loader->register();


$config = parse_ini_file("config.ini");

/* une instance de connexion  */
$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection($config);
$db->setAsGlobal();
$db->bootEloquent();

$r = new Router();
$r->addRoute('accueil', '/accueil/', '\backoffice\control\BackController', 'viewAccueil',\mf\auth\AbstractAuthentification::ACCESS_LEVEL_NONE);
$r->setDefaultRoute('/accueil/');
$r->run();
