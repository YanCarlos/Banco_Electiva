"use strict";

app.service('sociosService', function ($http, $httpParamSerializerJQLike) {
    
    this.registrar = function (nombre, apellidos, cedula, fecha, telefono, correo, ciudad, direccion, porcentaje) {
        var promise = $http({
            method: "post",
            url: "http://localhost:8080/Banco_electiva/bancoservice/socio",
            data: $httpParamSerializerJQLike({
                cedula: cedula,
                nombre: nombre,
                apellidos: apellidos,
                fecha_nacimiento: fecha,
                ciudad: ciudad,
                telefono: telefono,
                email: correo,
                direccion: direccion,
                porcentaje: porcentaje}),
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

    this.calPorcentaje=function(){
        var promise = $http({
            method: "get",
            url: "http://localhost:8080/Banco_electiva/bancoservice/porcentaje",
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function mySucces(response) {
            return response;
        }, function myError(response) {
            return response;
        });

        /*Luego se retorna la promesa*/
        return promise;
    }

    this.editar = function (id, nombre, nit, vision, mision) {
        var promise = $http({
            method: "put",
            url: "http://localhost:8080/Banco_electiva/bancoservice/banco",
            data: $httpParamSerializerJQLike({
                id: id,
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