
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");


/*Metodo que loguea un administrador*/
$app->post("/login",function() use($app){
	try{
		$input= $app->request->params();
		if (isset($input['cedula']) || isset($input['password'])) {
			$connection= getConnection();
			$dbf=$connection->prepare("SELECT p.cedula, p.nombre, p.apellidos, p.email FROM webmaster w JOIN acceso a ON a.persona=w.admin JOIN personas p ON p.cedula=a.persona WHERE a.persona=".$input['cedula']." AND a.password='".$input['password']."';");
			$dbf->execute();
			$resultado= $dbf->fetchObject();
			$connection=null;
	        
			if ($resultado!= false) {
	            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
	            $app->withJSON($resultado,200);
	        }else{
	            $resultado = array('respuesta' => false, 'mensaje' => 'Datos incorrectos');
	            $app->withJSON($resultado,400);
	        }

		}else{
			$resultado = array('respuesta' => false, 'mensaje' => 'No se encontraron los datos necesarios');
	        $app->withJSON($resultado,400);
		}	
	}catch(PDOException $e){
		$resultado = array('respuesta' => false, 'mensaje' => $e->getMessage());
        $app->withJSON($resultado,400);
	}
});