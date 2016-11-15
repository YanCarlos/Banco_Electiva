"use strict";
app.controller('sucursalController', function ($scope, $window, $timeout, sucursalesService) {
	$scope.msj="";
	$scope.registrar=function(){
		sucursalesService.registrar($scope.nombre, $scope.gerente, $scope.ciudad, $scope.direccion).then(function (response) {
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Registrado exitosamente!';
            	$scope.limpiar();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }else{
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.editar=function(){
		sucursalesService.editar($scope.id, $scope.nombre, $scope.gerente, $scope.ciudad, $scope.direccion).then(function (response) {
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Editado exitosamente!';
            	$scope.limpiar();
            	$scope.listarSucursales();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }else{
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.listarSucursales=function(){
		sucursalesService.listarSucursales().then(
			function (response) {
				$scope.sucursales=response.data.resultado;
        	}
		);
	}

	$scope.cargar=function(){
		$scope.listarEmpleados();
		$scope.listarDeptos();
	}
	$scope.listarEmpleados= function(){
		sucursalesService.listarEmpleados().then(
			function (response) {
				$scope.empleados=response.data.resultado;
        	}
        );
	}
	$scope.listarDeptos=function(){
		sucursalesService.listarDeptos().then(
			function (response) {
				$scope.deptos=response.data.resultado;
        	}
        );
	}
	$scope.listarMunicipios=function(){
		sucursalesService.listarMunicipios($scope.depto).then(
			function (response) {
				$scope.municipios=response.data.resultado;
        	}
        );
	}
	$scope.limpiar= function(){
		$scope.id="";
		$scope.nombre="";
		$scope.gerente="";
		$scope.depto="0";
		$scope.ciudad="0";
		$scope.direccion="";
	}

	$scope.datos=function(obj){
		$scope.cargar();
		$scope.id=obj.id;
		$scope.nombre=obj.nombre;
		$scope.gerente=obj.id_gerente;
		$scope.depto=obj.id_departamento;
		$scope.listarMunicipios();
		$scope.ciudad=obj.id_ciudad;
		$scope.direccion=obj.direccion;
	}
});