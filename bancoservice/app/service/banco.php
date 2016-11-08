
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");

$app->get("/bancos",function() use($app){
  try{
    $connection= getConnection();
    $dbf=$connection->prepare("SELECT b.id,b.nombre,b.nit,b.vision,b.mision FROM banco b;");
    $dbf->execute();
    $resultado= $dbf->fetchAll(PDO::FETCH_ASSOC);
    $connection=null;
    if (isset($resultado[0]["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay bancos para listar');
            $app->withJSON($resultado,400);
        }
  }catch(PDOException $e){
    $resultado = array('respuesta' => false, 'mensaje' => $e->getMessage());
        $app->withJSON($resultado,400);

  }
});

/* Metodo que retorna los datos del banco*/
$app->get("/banco",function() use($app){
	try{
		$connection= getConnection();
		$dbf=$connection->prepare("select b.id,b.nombre,b.nit,b.vision,b.mision,s.nombre as sede,p.nombre as gerente,d.nombre departamento, c.nombre as ciudad from banco b join sucursales s on s.id=b.sede join ciudades c on c.id=s.ciudad join personas p on p.cedula=s.gerente join departamentos d on d.id=c.departamento" );
		$dbf->execute();
		$resultado= $dbf->fetchAll();
		$connection=null;
		if (isset($resultado[0]["nombre"])) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'El banco no tiene datos.');
            $app->withJSON($resultado,400);
        }
	}catch(PDOException $e){
		$resultado = array('respuesta' => false, 'mensaje' => $e->getMessage());
        $app->withJSON($resultado,400);

	}
});



/*------------------------------------------------------*/


 /* Metodo que registra los datos del banco*/
  	$app->post('/banco', function () use($app) {
        try{
            $input= $app->request->params();
            if ( !isset($input['nombre']) || !isset($input['nit']) || !isset($input['mision'])
                || !isset($input['vision'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para registrar los datos del banco.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
                $sql = "INSERT INTO banco VALUES (null,:nombre,:nit,:vision,:mision, null)";
                $sth = $connection->prepare($sql);
                $sth->bindParam("nombre", $input['nombre']);
                $sth->bindParam("nit", $input['nit']);
                $sth->bindParam("vision", $input['vision']);
                $sth->bindParam("mision", $input['mision']);
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


/*Metodo que modifica los datos del banco*/
$app->put('/banco', function () use($app) {
        try{
            $input= $app->request->params();
            if (!isset($input['id']) || !isset($input['nombre']) || !isset($input['nit']) || !isset($input['mision'])
                || !isset($input['vision']) || !isset($input['sede']) || !isset($input['usuario']) || !isset($input['password'])) {
                $resultado = array('respuesta' => false, 'mensaje' => 'Faltan parametros para modificar los datos del banco.');
                $app->withJSON($resultado,400);
            }else{
                $connection= getConnection();
               	$sth = $connection->prepare("select * FROM webmaster w join acceso a on a.persona=w.admin WHERE w.admin=" . $input["usuario"] ." and a.password='" .$input["password"] . "'");
               	$sth->execute();
               	$admin= (array)$sth->fetchObject();
               	if (isset($admin["admin"]) && $admin["admin"] == $input["usuario"]) {
               		$sth = $connection->prepare("select * FROM banco WHERE id=" . $input["id"]);
	                $sth->execute();
	                $resultado=(array) $sth->fetchObject(); 
	                if (isset($resultado["nombre"])) {
	                    $sql = "UPDATE banco SET nombre=:nombre,nit=:nit,vision=:vision,mision=:mision,sede=:sede WHERE id=:id";
	                    $sth = $connection->prepare($sql);
	                    $sth->bindParam("id", $input['id']);
	                    $sth->bindParam("nombre", $input['nombre']);
	                    $sth->bindParam("nit", $input['nit']);
	                    $sth->bindParam("vision", $input['vision']);
	                    $sth->bindParam("mision", $input['mision']);
	                    $sth->bindParam("sede", $input['sede']);
	                    $sth->execute();
	                    $resultado=array('resultado' =>true, 'mensaje' =>'Los datos del banco fueron modificados correctamente.' );
	                    $app->withJSON($resultado,200);
	                }else{
	                    $resultado=array('resultado' => false, 'mensaje' =>'No hay datos registrados para el banco '. $input["id"].', imposible actualizar.' );
	                    $app->withJSON($resultado,400);
	                }   
               	}else{
               		$resultado=array('resultado' => false, 'mensaje' =>'Debe autenticarse como webmaster para poder actualizar los datos del banco' );
	                $app->withJSON($resultado,400);
               	}
                
                $connection=null;
            }
        }catch(PDOException $e){
             $resultado=array('resultado' => false, 'mensaje' =>$e->getMessage());
             $app->withJSON($resultado,400);
        }    
    });
 