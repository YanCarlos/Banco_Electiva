"use strict";

app.service('empleadosService', function ($http, $httpParamSerializerJQLike) {
    
    this.registrar = function (nombre, apellidos, cedula, fecha, telefono, correo, ciudad, direccion, sucursal, cargo) {
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/empleado",
            data: $httpParamSerializerJQLike({
                cedula: cedula,
                nombre: nombre,
                apellidos: apellidos,
                fecha_nacimiento: fecha,
                ciudad: ciudad,
                telefono: telefono,
                email: correo,
                direccion: direccion,
                sucursal: sucursal,
                cargo: cargo}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarDeptos=function(){
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/departamentos",
            data: $httpParamSerializerJQLike({}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }


    this.listarSucursales = function () {
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/sucursales",
            data: $httpParamSerializerJQLike({}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarCargos = function () {
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/cargos",
            data: $httpParamSerializerJQLike({}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarMunicipios=function(departamento){
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/ciudades/"+departamento,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }    

    this.editar = function (nombre, apellidos, cedula, fecha, telefono, correo, ciudad, direccion, sucursal, cargo) {
        var promise = $http({
            method: "put",
            url: "http://localhost:8080/Banco_electiva/bancoservice/empleado",
            data: $httpParamSerializerJQLike({
                cedula: cedula,
                nombre: nombre,
                apellidos: apellidos,
                fecha_nacimiento: fecha,
                ciudad: ciudad,
                telefono: telefono,
                email: correo,
                direccion: direccion,
                sucursal: sucursal,
                cargo: cargo}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarEmpleados = function () {
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/empleados",
            data: $httpParamSerializerJQLike({}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };
});