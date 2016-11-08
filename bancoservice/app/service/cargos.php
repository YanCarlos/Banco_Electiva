
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



/* Metodo que retorna los cargos*/
$app->get("/cargos",function() use($app){
	try{
		$connection= getConnection();
		$dbf=$connection->prepare("select * from cargos" );
		$dbf->execute();
		$resultado= $dbf->fetchAll();
		$connection=null;
		if (isset($resultado[0]["descripcion"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay cargos registrados.');
            $app->withJSON($resultado,400);
        }
	}catch(PDOException $e){
		$resultado = array('respuesta' => false, 'mensaje' => $e->getMessage());
        $app->withJSON($resultado,400);

	}
});




 /*------------------------------------------------------*/


 
    /* Metodo que retorna un cargo por su id*/
    $app->get('/cargos/:id', function($id) use($app) {
       $connection= getConnection();
        $sth = $connection->prepare("select * from cargos where id=" . $id);
        $sth->execute();
        $resultado =(array) $sth->fetchObject();
        $connection=null;
        if (isset($resultado["descripcion"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'El cargo con el id: ' . $id . ' no existe.' );
            $app->withJSON($resultado,400);
        }
    });
 


    /*------------------------------------------------------*/
 


    /*Metodo que busca un cargo por su descripcion*/
    $app->get('/cargos/buscar/:descripcion', function ($descripcion) use($app) {
        $connection= getConnection(); 
        $sth = $connection->prepare("select * from cargos where Upper(descripcion) Like '%" .strtoupper($descripcion)  . "%' ORDER BY descripcion");
        $sth->execute();
        $resultado = $sth->fetchAll();
        $connection=null;
        if (isset($resultado[0]["descripcion"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay cargos que coincidan con la busqueda: ' . $descripcion);
            $app->withJSON($resultado,400);
        }
    });







/*------------------------------------------------------*/


    /* Metodo que registra un cargo*/
  	$app->post('/cargos', function () use($app) {
        try{
            $input= $app->request->params();
            if ( !isset($input['descripcion']) || !isset($input['salario']) || !isset($input['horas']) || !isset($input['usuario']) || !isset($input['password'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar el cargo.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
               	$sth = $connection->prepare("select * FROM webmaster w join acceso a on a.persona=w.admin WHERE w.admin=" . $input["usuario"] ." and a.password='" .$input["password"] . "'");
               	$sth->execute();
               	$admin= (array)$sth->fetchObject();
               	if (isset($admin["admin"]) && $admin["admin"] == $input["usuario"]) {
         
	                    $sql = "INSERT INTO cargos VALUES (null,:descripcion,:salario,:horas)";
	                    $sth = $connection->prepare($sql);
	                    $sth->bindParam("descripcion", $input['descripcion']);
	                    $sth->bindParam("salario", $input['salario']);
	                    $sth->bindParam("horas", $input['horas']);
	                    $sth->execute();
	                    $resultado = $connection->lastInsertId();
	                    $resultado=array('resultado' =>true, 'mensaje' =>$resultado );
	                    $app->withJSON($resultado,200);
	    
               	}else{
               		$resultado=array('resultado' => false, 'mensaje' =>'Debe autenticarse como webmaster para poder registrar un cargo.' );
	                $app->withJSON($resultado,400);
               	}
                
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });




/*------------------------------------------------------*/


/*Metodo que modifica los datos de un cargo*/
$app->put('/cargos', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['descripcion']) || !isset($input['salario']) || !isset($input['horas']) || !isset($input['usuario']) || !isset($input['password'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar los datos del cargo.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
               	$sth = $connection->prepare("select * FROM webmaster w join acceso a on a.persona=w.admin WHERE w.admin=" . $input["usuario"] ." and a.password='" .$input["password"] . "'");
               	$sth->execute();
               	$admin= (array)$sth->fetchObject();
               	if (isset($admin["admin"]) && $admin["admin"] == $input["usuario"]) {
               		$sth = $connection->prepare("select * FROM cargos WHERE id=" . $input["id"]);
	                $sth->execute();
	                $resultado=(array) $sth->fetchObject(); 
	                if (isset($resultado["descripcion"])) {
	                    $sql = "UPDATE cargos SET descripcion=:descripcion,salario=:salario,horas_semanales=:horas WHERE id=:id";
	                    $sth = $connection->prepare($sql);
	                    $sth->bindParam("id", $input['id']);
	                    $sth->bindParam("descripcion", $input['descripcion']);
	                    $sth->bindParam("salario", $input['salario']);
	                    $sth->bindParam("horas", $input['horas']);
	                    $sth->execute();
	                    $resultado=array('resultado' =>true, 'mensaje' =>'Los datos del cargo '. $input["id"].' fueron modificados correctamente.' );
	                    $app->withJSON($resultado,200);
	                }else{
	                    $resultado=array('resultado' => false, 'mensaje' =>'No existe el cargo '. $input["id"] . '.' );
	                    $app->withJSON($resultado,400);
	                }   
               	}else{
               		$resultado=array('resultado' => false, 'mensaje' =>'Debe autenticarse como webmaster para poder actualizar los datos del cargo.' );
	                $app->withJSON($resultado,400);
               	}
                
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 




  
    /*------------------------------------------------------*/ 
 



    /*Metodo que elimina una sucursal*/
    $app->delete('/cargos', function () use($app) {
        try{
             $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['usuario']) || !isset($input['password'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para eliminar el cargo.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sth = $connection->prepare("select * FROM webmaster w join acceso a on a.persona=w.admin WHERE w.admin=" . $input["usuario"] ." and a.password='" .$input["password"] . "'");
                $sth->execute();
                $admin= (array)$sth->fetchObject();
                if (isset($admin["admin"]) && $admin["admin"] == $input["usuario"]) {
                  $sth = $connection->prepare("select * FROM cargos WHERE id=" . $input['id']);
                  $sth->execute();
                  $resultado=(array) $sth->fetchObject(); 
                  if (isset($resultado["descripcion"])) {
                      $sth = $connection->prepare("Delete FROM cargos WHERE id=" . $input['id']);
                      $sth->execute();
                      $resultado=array('resultado' =>true, 'mensaje' =>'El cargo ' . $resultado["descripcion"] . ' fue eliminado.' );
                      $app->withJSON($resultado,200);
                  }else{
                      $resultado=array('resultado' => false, 'mensaje' =>'El cargo con el id: ' . $input['id'] . ' no existe.' );
                      $app->withJSON($resultado,400);
                  }
                }else{
                  $resultado=array('resultado' => false, 'mensaje' =>'Debe autenticarse como webmaster para poder eliminar un cargo.' );
                  $app->withJSON($resultado,400);
                }   
                   $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 