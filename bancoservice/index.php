<?php

//incluir el archivo principal
include("Slim/Slim.php");

//registran la instancia de slim
\Slim\Slim::registerAutoloader();
//aplicacion 
$app = new \Slim\Slim();

define("SPECIALCONSTANT", true);
require("app/libs/connect.php");
require("app/service/login.php");
require("app/service/personas.php");
require("app/service/locaciones.php");
require("app/service/banco.php");
require("app/service/sucursales.php");
require("app/service/cargos.php");
require("app/service/socios.php");
$app->run();