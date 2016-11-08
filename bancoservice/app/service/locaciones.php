
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



/* Metodo que retorna las ciudades de un determinado departamento*/
$app->get("/ciudades/:departamento",function($departamento) use($app){
	try{
		$connection= getConnection();
		$dbf=$connection->prepare("select * from ciudades where departamento=" . $departamento);
		$dbf->execute();
		$resultado= $dbf->fetchAll();
		$connection=null;

        
		$app->response->headers->set("Content-type","application/json");
		$app->response->status(200);
		print_r($resultado);
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();

	}
});


/* Metodo que retorna el departamento de una determinada ciudad*/
$app->get("/departamento/:ciudad",function($ciudad) use($app){
	try{
		$connection= getConnection();
		$dbf=$connection->prepare("select d.id,d.nombre from departamentos as d join ciudades as c on d.id=c.departamento where c.id=" . $ciudad);
		$dbf->execute();
		$resultado= $dbf->fetchAll();
		$connection=null;

        
		$app->response->headers->set("Content-type","application/json");
		$app->response->status(200);
		print_r($resultado);
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();

	}
});