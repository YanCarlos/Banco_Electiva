<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



    /*------------------------------------------------------*/



	/*Metodo que retorna todas las sucursales ordenadas por el nombre*/
    $app->get('/socios', function () use($app) {
    	$connection= getConnection();
        $sth = $connection->prepare("select * from socios");
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if (isset($resultado[0]["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay socios en la base de datos.');
            $app->withJSON($resultado,400);
        }
    });




    /*------------------------------------------------------*/


 
/*Metodo que retorna la cantidad de porcentaje que queda*/
    $app->get('/porcentaje', function () use($app) {
        $connection= getConnection();
        $sth = $connection->prepare("SELECT (100-sum(porcentaje)) as resto from socios");
        $sth->execute();
        $resultado = $sth->fetchObject();
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay informacion del porcentaje');
            $app->withJSON($resultado,400);
        }
    });

  




    /*------------------------------------------------------*/

 
    /* Metodo que agrega una sucursal a la base de datos*/
    $app->post('/socio', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['cedula']) || !isset($input['pocentaje'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar el socio.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection(); 
                $sql = "INSERT INTO socios VALUES (:cedula,:porcentaje)";
                $sth = $connection->prepare($sql);
                $sth->bindParam("cedula", $input['cedula']);
                $sth->bindParam("porcentaje", $input['porcentaje']);
                $sth->execute();
                $resultado = $connection->lastInsertId();
                $connection=null;
                $resultado = array('respuesta' => true, 'resultado' => $resultado  );
                $app->withJSON($resultado,200);
            }
        
        }catch(PDOException $e){
              $resultado = array('respuesta' => false, 'mensaje' => $e->getMessage());
              $app->withJSON($resultado,400);
        }
    });
        


    /*------------------------------------------------------*/ 
 

 


    /*Metodo que modifica una sucursal, recibe el id de la sucursal
      y todos sus demas datos*/
    $app->put('/socio', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['cedula']) || !isset($input['porcentaje'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar el socio.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sth = $connection->prepare("select * FROM socios WHERE cedula=" . $input["cedula"]);
                $sth->execute();
                $resultado=(array) $sth->fetchObject(); 
                if ($resultado!=false) {
                    $sql = "UPDATE socios SET porcentaje=:porcentaje WHERE id=:id";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("cedula", $input['cedula']);
                    $sth->bindParam("porcentaje", $input['porcentaje']);                 
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'El socio ' . $resultado["cedula"] . ' fue modificado.' );
                    $app->withJSON($resultado,200);
                }else{
                    $resultado=array('resultado' => false, 'mensaje' =>'El socio con la cedula: ' . $input["id"] . ' no existe.' );
                    $app->withJSON($resultado,400);
                }   
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 

 