"use strict";
app.controller('sucursalController', function ($scope, $window, sucursalesService) {
	$scope.registrar=function(){
		sucursalesService.registrar($scope.nombre, $scope.gerente, $scope.ciudad, $scope.direccion).then(function (response) {
            if (response.data.resultado) {
            	alert('registrado exitosamente!');
            	$scope.limpiar();
            }else{
            	alert('Ocurrio un error: '+response.data.mensaje);
            }
        });
	}

	$scope.editar=function(){
		sucursalesService.editar($scope.id, $scope.nombre, $scope.gerente, $scope.ciudad, $scope.direccion).then(function (response) {
            if (response.data.resultado) {
            	alert('Editado exitosamente!');
            	$scope.limpiar();
            }else{
            	alert('Ocurrio un error: '+response.data.mensaje);
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
		$scope.nombre="";
		$scope.gerente="";
		$scope.ciudad="";
		$scope.direccion="";
	}

	$scope.datos=function(obj){
		console.log(obj);
		$scope.cargar();
		$scope.nombre=obj.nombre;
		$scope.gerente=obj.id_gerente;
		$scope.depto=obj.id_departamento;
		$scope.listarMunicipios();
		$scope.ciudad=obj.id_ciudad;
		$scope.direccion=obj.direccion;
	}
});