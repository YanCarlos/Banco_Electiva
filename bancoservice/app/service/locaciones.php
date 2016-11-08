
<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");



/* Metodo que retorna las ciudades de un determinado departamento*/
$app->get("/ciudades/:departamento",function($departamento) use($app){
	$connection= getConnection();
        $sth = $connection->prepare("select * from ciudades where departamento=" . $departamento );
        $sth->execute();
        $resultado = $sth->fetchAll();
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
        $sth = $connection->prepare("select * from departamentos");
        $sth->execute();
        $resultado = $sth->fetchAll();
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay departamentos en la base de datos.');
            $app->withJSON($resultado,400);
        }	
});