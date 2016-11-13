<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



    /*------------------------------------------------------*/



	/*Metodo que retorna todas las sucursales ordenadas por el nombre*/
    $app->get('/empleados', function () use($app) {
    	$connection= getConnection();
        $sth = $connection->prepare("select p.cedula as cedula,p.nombre as nombre,p.apellidos as apellidos,c.descripcion as cargo,s.nombre as sucursal,c.nombre as ciudad from empleados e join cargos c on c.id=e.cargo join sucursales s on s.id=e.sucursal join personas p on p.cedula=e.persona join ciudades c on c.id=s.ciudad");
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if (isset($resultado[0]["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay empleados en la base de datos.');
            $app->withJSON($resultado,400);
        }
    });




    /*------------------------------------------------------*/


    /* Metodo que agrega un empleado*/
    $app->post('/empleado', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['cedula']) || !isset($input['nombre']) || !isset($input['apellidos'])
                || !isset($input['fecha_nacimiento']) || !isset($input['ciudad']) || !isset($input['telefono'])
                || !isset($input['email'])  || !isset($input['direccion']) || !isset($input['cargo']) || !isset($input['sucursal'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar el socio.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection(); 
                $sql= "SELECT * personas WHERE cedula=". $input['cedula'];
                $sth = $connection->prepare($sql);
                $sth->execute();
                $resultado = $sth->fetchObject();
                if($resultado==false){
                    $fecha_actual= date("Y-m-d");
                    $sql="INSERT INTO personas VALUES(:cedula,:nombre,:apellidos,:nacimiento,:ingreso,:ciudad,:telefono,:email,:direccion)";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("cedula", $input['cedula']);
                    $sth->bindParam("nombre", $input['nombre']);
                    $sth->bindParam("apellidos", $input['apellidos']);
                    $sth->bindParam("nacimiento", $input['fecha_nacimiento']);
                    $sth->bindParam("ingreso", $input['fecha_ingreso']);
                    $sth->bindParam("ciudad", $input['ciudad']);
                    $sth->bindParam("telefono", $input['telefono']);
                    $sth->bindParam("email", $input['email']);
                    $sth->bindParam("direccion", $input['direccion']);
                    $sth->execute();
                    $resultado = $connection->lastInsertId();
                    if(is_numeric($resultado)){
                        $sql = "INSERT INTO empleados VALUES (:cedula,:porcentaje)";
                        $sth = $connection->prepare($sql);
                        $sth->bindParam("cedula", $input['cedula']);
                        $sth->bindParam("porcentaje", $input['porcentaje']);
                        $sth->execute();
                        $resultado = $connection->lastInsertId();
                        $connection=null;
                        $resultado = array('respuesta' => true, 'resultado' => $resultado  );
                        $app->withJSON($resultado,200);                   
                    }else{
                         $resultado = array('respuesta' => false, 'resultado' => "Error al intentar registrar la persona."  );
                        $app->withJSON($resultado,400);  
                    }
                }else{
                     $resultado = array('respuesta' => false, 'resultado' => "Esa persona ya esta registrada en la base de datos."  );
                        $app->withJSON($resultado,400);  
                }
                
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
 

 