"use strict";
app.controller('sociosController', function ($scope, $window, $timeout, sociosService) {
	$scope.msj="";
    $scope.ciudad="0";
    $scope.listarDeptos=function(){
        sociosService.listarDeptos().then(
            function (response) {
                $scope.deptos=response.data.resultado;
                $scope.depto='0';
            }
        );
    }

    $scope.listarMunicipios=function(){
        sociosService.listarMunicipios($scope.depto).then(
            function (response) {
                $scope.municipios=response.data.resultado;
                $scope.ciudad="0";
            }
        );
    }




    $scope.calPorcentaje=function(){
        sociosService.calPorcentaje().then(function(response){
            if (response.data.respuesta) {
                $scope.porDisponible=response.data.resultado.resto;
            };
            
        });
    }


     $scope.listarSocios=function(){
        sociosService.listarSocios().then(
            function (response) {
                $scope.socios=response.data.resultado;
                
            }
        );
    }

	$scope.registrar=function(){
        sociosService.registrar($scope.nombre, $scope.apellidos, $scope.cedula, $scope.fecha, $scope.telefono, $scope.correo,
         $scope.ciudad, $scope.direccion, $scope.porcentaje).then(function (response) {
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
        alert("hola");
		sociosService.editar($scope.nombre, $scope.apellidos, $scope.cedula, $scope.fecha, $scope.telefono, $scope.correo,
         $scope.ciudad, $scope.direccion, $scope.porcentaje).then(function (response) {
            console.log(response);
            if (response.data.resultado) {
            	$scope.colorText='success';
            	$scope.msj='Editado exitosamente!';
            	$scope.listarBancos();
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }else{
            	$scope.colorText='error';
            	$scope.msj=response.data.mensaje;
            	$timeout( function(){ $scope.msj=""; }, 3000);
            }
        });
	}

	$scope.listarBancos=function(){
		sociosService.listarBancos().then(
			function (response) {
				$scope.bancos=response.data.resultado;
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
        $scope.porcentaje="";
        $scope.calPorcentaje();
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
        $scope.calPorcentaje();
        $scope.porcentaje=parseInt(obj.porcentaje,10);
	}
});