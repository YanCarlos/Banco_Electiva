"use strict";
app.controller('sociosController', function ($scope, $window, $timeout, sociosService) {
	$scope.msj="";
	$scope.registrar=function(){
		bancoService.registrar($scope.nombre, $scope.nit, $scope.vision, $scope.mision).then(function (response) {
			console.log(response);
            if (response.data.respuesta) {
            	console.log(response);
            	$scope.colorText='success';
            	$scope.msj='Registrado exitosamente!';
            	$scope.limpiar();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            	
            }else{
            	console.log(response);
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}
	$scope.editar=function(){
		bancoService.editar($scope.id, $scope.nombre, $scope.nit, $scope.vision, $scope.mision).then(function (response) {
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Editado exitosamente!';
            	$scope.listarBancos();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }else{
            	console.log(response);
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.listarBancos=function(){
		bancoService.listarBancos().then(
			function (response) {
				$scope.bancos=response.data.resultado;
        	}
        );
	}
	$scope.limpiar= function(){
		$scope.nombre="";
		$scope.nit="";
		$scope.vision="";
		$scope.mision="";
	}
	$scope.datos=function(obj){
		$scope.id=obj.id;
		$scope.nombre=obj.nombre;
		$scope.nit=obj.nit;
		$scope.vision=obj.vision;
		$scope.mision=obj.mision;
	}
});