"use strict";

app.service('sucursalesService', function ($http, $httpParamSerializerJQLike) {
    
    this.registrar = function (nombre, gerente, ciudad, direccion) {
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/sucursales",
            data: $httpParamSerializerJQLike({
                nombre: nombre,
                gerente: gerente,
                ciudad: ciudad,
                direccion: direccion}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.editar = function (id,nombre, gerente, ciudad, direccion) {
        var promise = $http({
            method: "put",
            url: "http://localhost:8080/Banco_electiva/bancoservice/sucursales",
            data: $httpParamSerializerJQLike({
                id: id,
                nombre: nombre,
                gerente: gerente,
                ciudad: ciudad,
                direccion: direccion}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarEmpleados= function(){
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/personas",
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
});