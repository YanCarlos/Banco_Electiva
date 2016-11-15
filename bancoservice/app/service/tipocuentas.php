
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



/* Metodo que retorna los cargos*/
$app->get("/tipoCuenta",function() use($app){
	try{
		$connection= getConnection();
		$dbf=$connection->prepare("select * from tipos_cuenta" );
		$dbf->execute();
		$resultado= $dbf->fetchAll(PDO::FETCH_ASSOC);
		$connection=null;
		if (isset($resultado[0]["descripcion"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay tipos de cuentas registrados.');
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
  	$app->post('/tipoCuenta', function () use($app) {
        try{
            $input= $app->request->params();
            if ( !isset($input['descripcion'])) {
                $resultado = array('resultado' => false, 'mensaje' => 'Faltan parametros para registrar el tipo de cuenta.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();           	
                $sql = "INSERT INTO tipos_cuenta VALUES (null,:descripcion)";
                $sth = $connection->prepare($sql);
                $sth->bindParam("descripcion", $input['descripcion']);
                
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




/*------------------------------------------------------*/


/*Metodo que modifica los datos de un cargo*/
$app->put('/tipoCuenta', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['descripcion']) ) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar los datos del tipo de cuenta.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();               	
             	
                    $sql = "UPDATE tipos_cuenta SET descripcion=:descripcion WHERE id=:id";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("id", $input['id']);
                    $sth->bindParam("descripcion", $input['descripcion']);
                    
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'Tipo de cuenta modificado.' );
                    $app->withJSON($resultado,200);
                      	
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 




  
    /*------------------------------------------------------*/ 
 



    /*Metodo que elimina una sucursal*/
    $app->delete('/tipoCuenta', function () use($app) {
        try{
             $input= $app->request->params();
            if (!isset($input['id']) ) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para eliminar el tipo de cuenta.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                    $sth = $connection->prepare("Delete FROM tipos_cuenta WHERE id=" . $input['id']);
                      $sth->execute();
                      $resultado=array('resultado' =>true, 'mensaje' =>'El tipo de cuenta  fue eliminado.' );
                      $app->withJSON($resultado,200);
                  
                   $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' => 'El tipo de cuenta no puede ser eliminado.');
             $app->withJSON($resultado,400);
        }    
    });
