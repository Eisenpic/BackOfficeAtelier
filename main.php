<?php

use backoffice\model\Producteur;
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

session_start();

$r = new Router();
$r->addRoute('accueil', '/accueil/', '\backoffice\control\BackController', 'viewAccueil',\mf\auth\AbstractAuthentification::ACCESS_LEVEL_NONE);
$r->addRoute('check_login', '/check_login/', '\backoffice\control\BackController', 'checklogin',\mf\auth\AbstractAuthentification::ACCESS_LEVEL_NONE);
$r->addRoute('tableau_de_bord', '/tableau_de_bord/', '\backoffice\control\BackController', 'viewTDB',\mf\auth\AbstractAuthentification::ACCESS_LEVEL_PROD);
$r->addRoute('admin_panel', '/admin_panel/', '\backoffice\control\BackController', 'viewAdminPanel',\mf\auth\AbstractAuthentification::ACCESS_LEVEL_ADMIN);
$r->addRoute('liste', '/liste/', '\backoffice\control\BackController', 'viewList', \mf\auth\AbstractAuthentification::ACCESS_LEVEL_ADMIN);
$r->addRoute('logout', '/logout/', '\backoffice\control\BackController', 'logout', \mf\auth\AbstractAuthentification::ACCESS_LEVEL_NONE);
$r->addRoute('validcommande', '/validcommande/', '\backoffice\control\BackController', 'validcommande', \mf\auth\AbstractAuthentification::ACCESS_LEVEL_ADMIN);
$r->addRoute('commande', '/commande/', '\backoffice\control\BackController', 'viewCommande', \mf\auth\AbstractAuthentification::ACCESS_LEVEL_ADMIN);
$r->addRoute('logout', '/logout/', '\backoffice\control\BackController', 'logout', \mf\auth\AbstractAuthentification::ACCESS_LEVEL_PROD);
$r->setDefaultRoute('/accueil/');


$r->run();