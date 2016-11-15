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
            .when('/Socios/Registrar', {
                controller:'sociosController',
                templateUrl: 'pages/Admin/Socios/Crear.html'
            })
            .when('/Socios/Listar', {
                controller:'sociosController',
                templateUrl: 'pages/Admin/Socios/listar.html'
            })
            .when('/Sucursales/Registrar', {
                controller:'sucursalController',
                templateUrl: 'pages/Admin/Sucursales/Crear.html'
            })
            .when('/Sucursales/Listar', {
                controller:'sucursalController',
                templateUrl: 'pages/Admin/Sucursales/listar.html'
            })
            .when('/Empleados/Registrar', {
                controller:'sucursalController',
                templateUrl: 'pages/Admin/Empleados/Crear.html'
            })
            .when('/Empleados/Listar', {
                controller:'empleadosController',
                templateUrl: 'pages/Admin/Empleados/listar.html'
            })
            .otherwise({
                redirectTo: '/'
            });
});
