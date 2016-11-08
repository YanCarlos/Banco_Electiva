"use strict";

app.service('bancoService', function ($http, $httpParamSerializerJQLike) {
    
    this.registrar = function (nombre, nit, vision, mision) {
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/banco",
            data: $httpParamSerializerJQLike({
                nombre: nombre,
                nit: nit,
                vision: vision,
                mision: mision}),
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