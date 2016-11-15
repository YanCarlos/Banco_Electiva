
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



/* Metodo que retorna las ciudades de un determinado departamento*/
$app->get("/ciudades/:departamento",function($departamento) use($app){
	$connection= getConnection();
        $sth = $connection->prepare("select * from ciudades where departamento=" . $departamento );
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay ciudades en la base de datos para el departamento ' . $departamento);
            $app->withJSON($resultado,400);
        }	
});



/*Metodo que modifica los datos de un cargo*/
$app->put('/ciudad', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['nombre']) || !isset($input['departamento'])) {
                $resultado = array('resultado' => false, 'mensaje' => 'Faltan parametros para modificar los datos de la ciudad.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                    $sql = "UPDATE ciudades SET nombre=:nombre,departamento=:departamento WHERE id=:id";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("id", $input['id']);
                    $sth->bindParam("nombre", $input['nombre']);
                    $sth->bindParam("departamento", $input['departamento']);
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'Ciudad editada correctamente.' );
                    $app->withJSON($resultado,200);
                        
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>"No se pudo editar los datos de la ciudad.");
             $app->withJSON($resultado,400);
        }    
    });



/* Metodo que retorna las ciudades de un determinado departamento*/
$app->get("/ciudadesAll/:departamento",function($departamento) use($app){
    $connection= getConnection();
        $sth = $connection->prepare("select c.id as id, c.nombre as nombre, d.nombre as departamento,d.id as id_departamento from ciudades c join departamentos d on d.id=c.departamento where departamento=" . $departamento );
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay ciudades en la base de datos para el departamento ' . $departamento);
            $app->withJSON($resultado,400);
        }   
});



/* Metodo que retorna el departamento de una determinada ciudad*/
$app->get("/departamentos",function() use($app){
	$connection= getConnection();
        $sth = $connection->prepare("select * from departamentos ");
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay departamentos en la base de datos.');
            $app->withJSON($resultado,400);
        }	
});


/* Metodo que retorna el departamento de una determinada ciudad*/
$app->get("/departamentosAll",function() use($app){
    $connection= getConnection();
        $sth = $connection->prepare("select d.id,d.nombre,p.nombre as pais from departamentos d join paises p on p.id=d.pais");
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay departamentos en la base de datos.');
            $app->withJSON($resultado,400);
        }   
});



/*Metodo que modifica los datos de un cargo*/
$app->put('/departamento', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['nombre'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar los datos del departamento.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();                   
                $sth = $connection->prepare("select * FROM departamentos WHERE id=" . $input["id"]);
                $sth->execute();
                $resultado=(array) $sth->fetchObject(); 
                if (isset($resultado["nombre"])) {
                    $sql = "UPDATE departamentos SET nombre=:nombre WHERE id=:id";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("id", $input['id']);
                    $sth->bindParam("nombre", $input['nombre']);
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'Los datos del departamento '. $input["id"].' fueron modificados correctamente.' );
                    $app->withJSON($resultado,200);
                }else{
                    $resultado=array('resultado' => false, 'mensaje' =>'No existe el departamento '. $input["id"] . '.' );
                    $app->withJSON($resultado,400);
                }               
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });




/* Metodo que registra un cargo*/
    $app->post('/departamento', function () use($app) {
        try{
            $input= $app->request->params();
            if ( !isset($input['nombre']) ) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar el departamento.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();               
                $sql = "INSERT INTO departamentos VALUES (null,:nombre,1)";
                $sth = $connection->prepare($sql);
                $sth->bindParam("nombre", $input['nombre']);
                
                $sth->execute();
                $resultado = $connection->lastInsertId();
                $resultado=array('resultado' =>true, 'mensaje' =>$resultado );
                $app->withJSON($resultado,200);                
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });


    /* Metodo que registra un cargo*/
    $app->post('/ciudad', function () use($app) {
        try{
            $input= $app->request->params();
            if ( !isset($input['nombre']) || !isset($input['departamento'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar la ciudad.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();               
                $sql = "INSERT INTO ciudades VALUES (null,:nombre,:departamento)";
                $sth = $connection->prepare($sql);
                $sth->bindParam("nombre", $input['nombre']);
                $sth->bindParam("departamento", $input['departamento']);
                $sth->execute();
                $resultado = $connection->lastInsertId();
                $resultado=array('resultado' =>true, 'mensaje' =>$resultado );
                $app->withJSON($resultado,200);                
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });

    /*Metodo que elimina una sucursal*/
    $app->delete('/departamento', function () use($app) {
        try{
             $input= $app->request->params();
            if (!isset($input['id']) ) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para eliminar el departamento.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
               
                  $sth = $connection->prepare("select * FROM ciudades WHERE departamento=" . $input['id']);
                  $sth->execute();
                   $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                  if ($resultado==false) {
                      $sth = $connection->prepare("Delete FROM departamentos WHERE id=" . $input['id']);
                      $sth->execute();
                      $resultado=array('resultado' =>true, 'mensaje' =>'El departamento fue eliminado.');
                      $app->withJSON($resultado,200);
                  }else{
                      $resultado=array('resultado' => false, 'mensaje' =>'El departamento tiene ciudades relacionadas con èl, imposible eliminarse.' );
                      $app->withJSON($resultado,400);
                  }
                
                   $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });





    /*Metodo que elimina una sucursal*/
    $app->delete('/ciudad', function () use($app) {
        try{
             $input= $app->request->params();
            if (!isset($input['id']) ) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para eliminar la ciudad.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sth = $connection->prepare("Delete FROM ciudades WHERE id=" . $input['id']);
                $sth->execute();
                $resultado=array('resultado' =>true, 'mensaje' =>'Ciudad eliminada.');
                $app->withJSON($resultado,200);                 
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>"No se puede eliminar la ciudad, tiene elementos relacionados a ella.");
             $app->withJSON($resultado,400);
        }    
    });
