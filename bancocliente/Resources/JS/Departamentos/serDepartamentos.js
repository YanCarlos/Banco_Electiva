"use strict";

app.service('departamentoService', function ($http, $httpParamSerializerJQLike) {
    
    this.registrar = function (nombre) {
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/departamento",
            data: $httpParamSerializerJQLike({
                nombre: nombre}),
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
            url: "http://localhost:8080/Banco_electiva/bancoservice/departamentosAll",
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


     this.listarSocios=function(){
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/socios",
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

    this.eliminar=function(id){
        var promise = $http({
            method: "delete",
            url: "http://localhost:8080/Banco_electiva/bancoservice/departamento",
            data: $httpParamSerializerJQLike({
                id: id}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }

    this.editar = function (id, nombre) {
        var promise = $http({
            method: "put",
            url: "http://localhost:8080/Banco_electiva/bancoservice/departamento",
            data: $httpParamSerializerJQLike({
                id: id,
                nombre: nombre}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    };

    this.listarBancos = function () {
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/bancos",
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