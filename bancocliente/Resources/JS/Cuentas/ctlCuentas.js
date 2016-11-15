"use strict";
app.controller('tipoCuentaController', function ($scope, $window, $timeout, tipoCuentaService) {
	$scope.msj="";
    

    $scope.listarTipoCuentas=function(){
      
        tipoCuentaService.listarDeptos().then(
            function (response) {
            	console.log(response);
                $scope.tipos=response.data.resultado;
                
                
            }
        );
    }

    $scope.eliminar=function(obj){
        tipoCuentaService.eliminar(obj.id).then(function (response) {

            if (response.data.resultado) {
            	console.log(response);
            	$scope.colorText='success';
            	$scope.msj='Eliminado exitosamente!';
                $scope.listarTipoCuentas();
            	
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
        tipoCuentaService.registrar($scope.nombre).then(function (response) {
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
		tipoCuentaService.editar($scope.id, $scope.descripcion).then(function (response) {
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Editado exitosamente!';
            	$scope.listarTipoCuentas();
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
		$scope.descripcion=obj.descripcion;
	
	}
});