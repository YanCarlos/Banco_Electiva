<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



    /*------------------------------------------------------*/



	/*Metodo que retorna todas las sucursales ordenadas por el nombre*/
    $app->get('/socios', function () use($app) {
    	$connection= getConnection();
        $sth = $connection->prepare("select p.cedula as cedula,p.nombre as nombre,p.apellidos as apellidos,
                                     p.email as email, c.nombre as ciudad,s.porcentaje as porcentaje, sum(s.porcentaje) as total,(100-sum(s.porcentaje)) as disponible
                                     from socios s join personas p on p.cedula=s.persona join ciudades c on c.id=p.ciudad");
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
        $sth = $connection->prepare("SELECT IFNULL((100-sum(porcentaje)),100) as resto from socios");
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
            if (!isset($input['cedula']) || !isset($input['nombre']) || !isset($input['apellidos'])
                || !isset($input['fecha_nacimiento']) || !isset($input['ciudad']) || !isset($input['telefono'])
                || !isset($input['email'])  || !isset($input['direccion']) || !isset($input['porcentaje'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar el socio.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection(); 
                $sql= "SELECT * FROM personas WHERE cedula=". $input['cedula'];
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
                    $sth->bindParam("ingreso", $fecha_actual);
                    $sth->bindParam("ciudad", $input['ciudad']);
                    $sth->bindParam("telefono", $input['telefono']);
                    $sth->bindParam("email", $input['email']);
                    $sth->bindParam("direccion", $input['direccion']);
                    $sth->execute();
                    $resultado = $connection->lastInsertId();
                    if(is_numeric($resultado)){
                        $sql = "INSERT INTO socios VALUES (null,:cedula,:porcentaje)";
                        $sth = $connection->prepare($sql);
                        $sth->bindParam("cedula", $input['cedula']);
                        $sth->bindParam("porcentaje", $input['porcentaje']);
                        $sth->execute();
                        $resultado = $connection->lastInsertId();
                        $connection=null;
                        $resultado = array('respuesta' => true, 'resultado' => $resultado  );
                        $app->withJSON($resultado,200);                   
                    }else{
                         $resultado = array('respuesta' => false, 'mensaje' => "Error al intentar registrar la persona."  );
                        $app->withJSON($resultado,400);  
                    }
                }else{
                     $resultado = array('respuesta' => false, 'mensaje' => "Esa persona ya esta registrada en la base de datos."  );
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
            if (!isset($input['cedula']) || !isset($input['nombre']) || !isset($input['apellidos'])
                || !isset($input['fecha_nacimiento']) || !isset($input['ciudad']) || !isset($input['telefono'])
                || !isset($input['email'])  || !isset($input['direccion']) || !isset($input['porcentaje'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar el socio.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sth = $connection->prepare("select * FROM socios WHERE cedula=" . $input["cedula"]);
                $sth->execute();
                $resultado=(array) $sth->fetchObject(); 
                if ($resultado!=false) {
                    /*Modificamos en la tabla socios*/
                    $sql = "UPDATE socios SET porcentaje=:porcentaje WHERE persona=:cedula";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("cedula", $input['cedula']);
                    $sth->bindParam("porcentaje", $input['porcentaje']);                 
                    $sth->execute();

                    /*Modificado en la tabla personas*/
                    $sql = "UPDATE personas SET nombre=:nombre,apellidos=:apellidos,fecha_nacimiento=:nacimiento,
                            fecha_ingreso=:ingreso,ciudad=:ciudad,telefono=:telefono,email=:email,direccion=:direccion WHERE cedula=:cedula";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("cedula", $input['cedula']);
                    $sth->bindParam("nombre", $input['nombre']);
                    $sth->bindParam("apellidos", $input['apellido']);
                    $sth->bindParam("nacimiento", $input['nacimiento']);
                    $sth->bindParam("ingreso", $input['ingreso']);
                    $sth->bindParam("ciudad", $input['ciudad']);
                    $sth->bindParam("telefono", $input['telefono']); 
                    $sth->bindParam("email", $input['email']);
                    $sth->bindParam("direccion", $input['direccion']);                                       
                    $sth->execute();



                    /*Retornamos el resultado*/
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
 

 