"use strict";
app.controller('empleadosController', function ($scope, $window, $timeout, empleadosService) {
	$scope.msj="";
    $scope.ciudad="0";
    $scope.listarDeptos=function(){
        empleadosService.listarDeptos().then(
            function (response) {
                $scope.deptos=response.data.resultado;
                $scope.depto='0';
            }
        );
    }

    $scope.listarMunicipios=function(){
        empleadosService.listarMunicipios($scope.depto).then(
            function (response) {
                $scope.municipios=response.data.resultado;
                $scope.ciudad="0";
            }
        );
    }

    $scope.listarSucursales=function(){
        empleadosService.listarSucursales().then(function(response){
            $scope.sucursales=response.data.resultado;
            $scope.sucursal="0";
        });
    }

    $scope.listarCargos=function(){
        empleadosService.listarCargos().then(function(response){
            $scope.cargos=response.data.resultado;
            $scope.cargo="0";
        });
    }

	$scope.registrar=function(){
        empleadosService.registrar($scope.nombre, $scope.apellidos, $scope.cedula, $scope.fecha, $scope.telefono, $scope.correo,
         $scope.ciudad, $scope.direccion, $scope.sucursal, $scope.cargo).then(function (response) {
            console.log(response);
            if (response.data.respuesta) {
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
		empleadosService.editar($scope.nombre, $scope.apellidos, $scope.cedula, $scope.fecha, $scope.telefono, $scope.correo,
         $scope.ciudad, $scope.direccion, $scope.sucursal, $scope.cargo).then(function (response) {
            console.log(response);
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Editado exitosamente!';
            	$scope.listarEmpleados();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }else{
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.listarEmpleados=function(){
		empleadosService.listarEmpleados().then(
			function (response) {
				$scope.empleados=response.data.resultado;
        	}
        );
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
        $scope.sucursal="0";
        $scope.cargo="0";
	}
	$scope.datos=function(obj){
		$scope.nombre=obj.nombre;
		$scope.apellidos=obj.apellidos;
        $scope.cedula = parseInt(obj.cedula, 10);
        $scope.fecha= new Date(obj.fecha);
        $scope.telefono= parseInt(obj.telefono, 10);
        $scope.correo=obj.email
        $scope.listarDeptos();
        $scope.depto=obj.id_depto;
        $scope.listarMunicipios();
        $scope.ciudad=obj.id_ciudad;
        $scope.direccion=obj.direccion;
        $scope.listarSucursales();
        $scope.sucursal=obj.id_sucursal;
        $scope.listarCargos();
        $scope.cargo=obj.id_cargo;
	}
});