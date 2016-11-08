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
});