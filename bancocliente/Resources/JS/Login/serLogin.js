"use strict";

app.service('loginService', function ($http, $httpParamSerializerJQLike) {
    
    this.login = function (cedula, password) {
        
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/login",
            data: $httpParamSerializerJQLike({
                cedula: cedula,
                password: password}),
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