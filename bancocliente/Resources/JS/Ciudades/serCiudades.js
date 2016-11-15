"use strict";

app.service('ciudadService', function ($http, $httpParamSerializerJQLike) {
    
    this.registrar = function (nombre,departamento) {
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/ciudad",
            data: $httpParamSerializerJQLike({
                nombre: nombre,
                departamento:departamento}),
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
            url: "http://localhost:8080/Banco_electiva/bancoservice/ciudadesAll/"+departamento,
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
            url: "http://localhost:8080/Banco_electiva/bancoservice/ciudad",
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

    this.editar = function (id, nombre,departamento) {
        var promise = $http({
            method: "put",
            url: "http://localhost:8080/Banco_electiva/bancoservice/ciudad",
            data: $httpParamSerializerJQLike({
                id: id,
                nombre: nombre,
                departamento: departamento}),
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