<?php if(!defined("SPECIALCONSTANT")) die("Acceso denegado.");







/*Metodo que consulta personas*/
$app->get("/personas",function() use($app){
	$connection= getConnection();
        $sth = $connection->prepare("select * from personas");
        $sth->execute();
        $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
        $connection=null;
        if ($resultado!=false) {
            $resultado = array('respuesta' => true, 'resultado' => $resultado  );
            $app->withJSON($resultado,200);
        }else{
            $resultado = array('respuesta' => false, 'mensaje' => 'No hay personas en la base de datos.');
            $app->withJSON($resultado,400);
        }	
});

/*Metodo que consulta persona a partir de una cedula*/
$app->get("/personas/:cedula",function($cedula) use($app){
	try{
		$connection= getConnection();
		$dbf=$connection->prepare("select * from personas where cedula=" . $cedula);
		$dbf->execute();
		$resultado= $dbf->fetchAll();
		$connection=null;
		
		$app->response->headers->set("Content-type","application/json");
		$app->response->status(200);
		print_r($resultado);
		//pp->response->body(json_encode($resultado));
	}catch(PDOException $e){
		echo "Error: " . $e->getMessage();

	}
});


/*Metodo que registra una persona*/
$app->post("/personas/",function() use($app){
	 $cedula = $app->request->post("title");
	 $nombre = $app->request->post("isbn");
	 $apellidos = $app->request->post("author");
	 try{
		 $connection = getConnection();
		 $dbh = $connection->prepare("INSERT INTO books VALUES(null, ?, ?, ?, NOW())");
		 $dbh->bindParam(1,$title);
		 $dbh->bindParam(2,$isbn);
		 $dbh->bindParam(3,$author);
		 $dbh->execute();
		 $booksId = $connection->lastInsertId();
		 $connection = null;
		 
		 $app->response->headers->set("Content-type", "application/json");
		 $aap->response->status(200);
		 $aap->response->body(json_encode($booksId));
	 
	 }catch(PDOException $e){
		 echo "Error: ".$e->getMessage();
	 }
	 
});

