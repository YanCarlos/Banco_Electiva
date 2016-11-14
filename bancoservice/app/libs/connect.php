<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado");


function getConnection(){
	try{
		$db_username="root";
		$db_password= "root";
		$connection= new PDO("mysql:host=localhost;dbname=banco;charset=utf8",
					 $db_username,$db_password/*,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")*/);
		$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		return $connection;
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();

	}

}
