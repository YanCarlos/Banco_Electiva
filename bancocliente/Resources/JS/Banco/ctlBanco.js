"use strict";
app.controller('bancoController', function ($scope, $window, bancoService) {
	
	$scope.registrar=function(){
		bancoService.registrar($scope.nombre, $scope.nit, $scope.vision, $scope.mision).then(function (response) {
            if (response.data.resultado) {
            	alert('registrado exitosamente!');
            	$scope.limpiar();
            }else{
            	alert('Ocurrio un error: '+response.data.mensaje);
            }
        });
	}
	$scope.editar=function(){
		bancoService.editar($scope.id, $scope.nombre, $scope.nit, $scope.vision, $scope.mision).then(function (response) {
            if (response.data.resultado) {
            	alert('Editado exitosamente!');
            	$scope.listarBancos();
            }else{
            	console.log(response);
            	alert('Ocurrio un error: '+response.data.mensaje);
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