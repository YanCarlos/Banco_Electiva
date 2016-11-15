<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



    /*------------------------------------------------------*/



	/*Metodo que retorna todas las sucursales ordenadas por el nombre*/
    $app->get('/empleados', function () use($app) {
    	$connection= getConnection();
        $sth = $connection->prepare("SELECT p.cedula, p.nombre, p.apellidos, p.fecha_nacimiento AS fecha, p.telefono, p.direccion, p.email, c.nombre as ciudad, c.id AS id_ciudad, d.nombre AS depto, d.id AS id_depto, s.id AS id_sucursal, s.nombre AS sucursal, k.id AS id_cargo, k.descripcion AS cargo FROM personas p JOIN empleados e ON e.persona=p.cedula JOIN ciudades c on c.id=p.ciudad JOIN departamentos d ON c.departamento=d.id JOIN sucursales s ON s.id=e.sucursal JOIN cargos k ON k.id=e.cargo;");
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
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar el empleado.');
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
                        $sql = "INSERT INTO empleados VALUES (:persona,:sucursal, :cargo)";
                        $sth = $connection->prepare($sql);
                        $sth->bindParam("persona", $input['cedula']);
                        $sth->bindParam("sucursal", $input['sucursal']);
                        $sth->bindParam("cargo", $input['cargo']);
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
    $app->put('/empleado', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['cedula']) || !isset($input['nombre']) || !isset($input['apellidos'])
                || !isset($input['fecha_nacimiento']) || !isset($input['ciudad']) || !isset($input['telefono'])
                || !isset($input['email'])  || !isset($input['direccion']) || !isset($input['cargo']) || !isset($input['sucursal'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar el empleado.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sth = $connection->prepare("select * FROM empleados WHERE persona=" . $input["cedula"]);
                $sth->execute();
                $resultado=(array) $sth->fetchObject(); 
                if ($resultado!=false) {
                    $sql="UPDATE personas SET nombre=:nombre,apellidos=:apellidos,fecha_nacimiento=:fecha,ciudad=:ciudad,telefono=:telefono,email=:correo,direccion=:direccion WHERE 1;";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("nombre", $input['nombre']);
                    $sth->bindParam("apellidos", $input['apellidos']);
                    $sth->bindParam("fecha", $input['fecha_nacimiento']);
                    $sth->bindParam("ciudad", $input['ciudad']);
                    $sth->bindParam("correo", $input['email']);
                    $sth->bindParam("telefono", $input['telefono']);
                    $sth->bindParam("direccion", $input['direccion']);
                    $sth->execute();
                    $sql = "UPDATE empleados SET persona=:cedula,sucursal=:sucursal,cargo=:cargo WHERE 1";
                    $sth = $connection->prepare($sql);
                    $sth->bindParam("cedula", $input['cedula']);
                    $sth->bindParam("sucursal", $input['sucursal']);
                    $sth->bindParam("cargo", $input['cargo']);                 
                    $sth->execute();
                    $resultado=array('resultado' =>true, 'mensaje' =>'El empleado fue modificado.' );
                    $app->withJSON($resultado,200);
                }else{
                    $resultado=array('resultado' => false, 'mensaje' =>'El empleado no existe.' );
                    $app->withJSON($resultado,400);
                }   
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 

 