<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



    /*------------------------------------------------------*/



	/*Metodo que retorna todas las sucursales ordenadas por el nombre*/
    $app->get('/sucursales', function () use($app) {
    	$connection= getConnection();
        $sth = $connection->prepare("select s.id,s.nombre ,p.nombre as gerente,c.nombre as ciudad,
                                     s.direccion,d.nombre as departamento
                                     from sucursales s join ciudades c on c.id=s.ciudad
                                     join departamentos d on d.id=c.departamento
                                     join personas p on p.cedula=s.gerente ORDER BY s.nombre");
        $sth->execute();
        $resultado = $sth->fetchAll();
        $connection=null;
        if (isset($resultado[0]["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay sucursales en la base de datos.');
            $app->withJSON($resultado,400);
        }
    });




    /*------------------------------------------------------*/


 
    /* Metodo que retorna la sucursal por su id*/
    $app->get('/sucursales/:id', function($id) use($app) {
       $connection= getConnection();
        $sth = $connection->prepare("select s.id,s.nombre ,p.nombre as gerente,c.nombre as ciudad,
                                     s.direccion,d.nombre as departamento
                                     from sucursales s join ciudades c on c.id=s.ciudad
                                     join departamentos d on d.id=c.departamento
                                     join personas p on p.cedula=s.gerente where s.id=" . $id);
        $sth->execute();
        $resultado =(array) $sth->fetchObject();
        $connection=null;
        if (isset($resultado["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'La sucursal con el id: ' . $id . ' no existe.' );
            $app->withJSON($resultado,400);
        }
    });
 


    /*------------------------------------------------------*/
 


    /*Metodo que busca una sucursal por su nombre*/
    $app->get('/sucursales/buscar/:nombre', function ($nombre) use($app) {
        $connection= getConnection(); 
        $sth = $connection->prepare("select s.id,s.nombre ,p.nombre as gerente,c.nombre as ciudad,
                                     s.direccion,d.nombre as departamento
                                     from sucursales s join ciudades c on c.id=s.ciudad
                                     join departamentos d on d.id=c.departamento
                                     join personas p on p.cedula=s.gerente where Upper(s.nombre) Like '%" .strtoupper($nombre)  . "%' ORDER BY s.nombre");
        $sth->execute();
        $resultado = $sth->fetchAll();
        $connection=null;
        if (isset($resultado[0]["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay sucursales que coincidan con la busqueda: ' . $nombre);
            $app->withJSON($resultado,400);
        }
    });




    /*------------------------------------------------------*/

 
    /* Metodo que agrega una sucursal a la base de datos*/
    $app->post('/sucursales', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['nombre']) || !isset($input['gerente']) || !isset($input['ciudad'])
                || !isset($input['direccion'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar la sucursal.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection(); 
                $sql = "INSERT INTO sucursales VALUES (null,:nombre,:gerente,:ciudad,:direccion)";
                $sth = $connection->prepare($sql);
                $sth->bindParam("nombre", $input['nombre']);
                $sth->bindParam("gerente", $input['gerente']);
                $sth->bindParam("ciudad", $input['ciudad']);
                $sth->bindParam("direccion", $input['direccion']);
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
 



    /*Metodo que elimina una sucursal*/
    $app->delete('/sucursales', function () use($app) {
        try{
            $input= $app->request->params();
            if(isset($input["id"])){
                $connection= getConnection();
                $sth = $connection->prepare("select * FROM sucursales WHERE id=" . $input["id"]);
                $sth->execute();
                $resultado=(array) $sth->fetchObject(); 
                if (isset($resultado["nombre"])) {
                    $sth = $connection->prepare("Delete FROM sucursales WHERE id=" . $input["id"]);
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'La sucursal ' . $resultado["nombre"] . ' fue eliminada.' );
                    $app->withJSON($resultado,200);
                }else{
                    $resultado=array('resultado' => false, 'mensaje' =>'La sucursal con el id: ' . $input["id"] . ' no existe.' );
                    $app->withJSON($resultado,400);
                }   
                 $connection=null;
            }else{
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para eliminar la sucursal.');
                $app->withJSON($resultado,400);
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 

    /*------------------------------------------------------*/ 
 


    /*Metodo que modifica una sucursal, recibe el id de la sucursal
      y todos sus demas datos*/
    $app->put('/sucursales', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['nombre']) || !isset($input['gerente']) || !isset($input['ciudad'])
                || !isset($input['direccion'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar la sucursal.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sth = $connection->prepare("select * FROM sucursales WHERE id=" . $input["id"]);
                $sth->execute();
                $resultado=(array) $sth->fetchObject(); 
                if (isset($resultado["nombre"])) {
                    $sql = "UPDATE sucursales SET nombre=:nombre,gerente=:gerente,ciudad=:ciudad,direccion=:direccion WHERE id=:id";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("id", $input['id']);
                    $sth->bindParam("nombre", $input['nombre']);
                    $sth->bindParam("gerente", $input['gerente']);
                    $sth->bindParam("ciudad", $input['ciudad']);
                    $sth->bindParam("direccion", $input['direccion']);
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'La sucursal ' . $resultado["nombre"] . ' fue modificada.' );
                    $app->withJSON($resultado,200);
                }else{
                    $resultado=array('resultado' => false, 'mensaje' =>'La sucursal con el id: ' . $input["id"] . ' no existe.' );
                    $app->withJSON($resultado,400);
                }   
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 

 