"use strict";
app.controller('ciudadController', function ($scope, $window, $timeout, ciudadService) {
	$scope.msj="";
    $scope.depto='24';

    $scope.listarDepartamentos=function(){
      
        ciudadService.listarDeptos().then(
            function (response) {
            	console.log(response);
                $scope.deptos=response.data.resultado;
                
                
            }
        );
    }


    $scope.listarCiudades=function(){
      
        ciudadService.listarMunicipios($scope.depto).then(
            function (response) {
                console.log(response);
                $scope.ciudades=response.data.resultado;
               
                
            }
        );
    }

    $scope.eliminar=function(obj){
        ciudadService.eliminar(obj.id).then(function (response) {

            if (response.data.resultado) {
            	console.log(response);
            	$scope.colorText='success';
            	$scope.msj='Eliminado exitosamente!';
                $scope.listarCiudades();
            	
            	$timeout( function(){ $scope.msj=""; }, 3000);
            	
            }else{
            	console.log(response);
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
                console.log($scope.msj);
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.registrar=function(){
        ciudadService.registrar($scope.nombre,$scope.depto).then(function (response) {
            if (response.data.resultado) {
            	console.log(response);
            	$scope.colorText='success';
            	$scope.msj='Registrado exitosamente!';
            	$scope.limpiar();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            	
            }else{
            	console.log(response);
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
                console.log($scope.msj);
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.editar=function(){
		ciudadService.editar($scope.id,$scope.nombre, $scope.depto).then(function (response) {
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Editado exitosamente!';
            	$scope.listarCiudades();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }else{
            	console.log(response);
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	
	$scope.limpiar= function(){
		$scope.nombre="";
		$scope.apellidos="";
        $scope.cedula="";
        $scope.fecha="";
        $scope.telefono="";
        $scope.correo="";
        $scope.depto="0";
        $scope.ciudad="0";
        $scope.direccion="";
        $scope.porcentaje="";
       
	}
	$scope.datos=function(obj){
		$scope.id=obj.id;
		$scope.nombre=obj.nombre;
		$scope.nit=obj.nit;
		$scope.vision=obj.vision;
		$scope.mision=obj.mision;
	}
});