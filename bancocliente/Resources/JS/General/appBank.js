"use strict";
var app = angular.module("appBank", ['ngRoute']);

app.config(function ($routeProvider) {
    $routeProvider
            .when('/Banco/Registrar', {
                controller:'bancoController',
                templateUrl: 'pages/Admin/Banco/Crear.html'
            })
            .when('/Banco/Listar', {
                controller:'bancoController',
                templateUrl: 'pages/Admin/Banco/listar.html'
            })
            .when('/Sucursales/Registrar', {
                controller:'sucursalController',
                templateUrl: 'pages/Admin/Sucursales/Crear.html'
            })
            .when('/Sucursales/Listar', {
                controller:'sucursalController',
                templateUrl: 'pages/Admin/Sucursales/listar.html'
            })
            .otherwise({
                redirectTo: '/'
            });
});
