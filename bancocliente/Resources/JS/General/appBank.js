"use strict";
var app = angular.module("appBank", ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
            .when('/Banco/Registrar', {
                controller:'',
                templateUrl: 'pages/Admin/Banco/Crear.html'
            })
            .when('/Banco/Listar', {
                controller:'',
                templateUrl: 'pages/Admin/Banco/listar.html'
            })
            .otherwise({
                redirectTo: '/'
            });
});
