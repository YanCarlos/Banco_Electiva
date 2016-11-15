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
            .when('/Departamentos/Listar', {
                controller:'departamentoController',
                templateUrl: 'pages/Admin/Departamentos/listar.html'
            })
            .when('/Departamentos/Registrar', {
                controller:'departamentoController',
                templateUrl: 'pages/Admin/Departamentos/registrar.html'
            })
            .when('/Ciudades/Registrar', {
                controller:'ciudadController',
                templateUrl: 'pages/Admin/Ciudades/registrar.html'
            })
            .when('/Ciudades/Listar', {
                controller:'ciudadController',
                templateUrl: 'pages/Admin/Ciudades/listar.html'
            })
             .when('/Cuentas/Registrar', {
                controller:'tipoCuentaController',
                templateUrl: 'pages/Admin/Cuentas/registrar.html'
            })
            .when('/Cuentas/Listar', {
                controller:'tipoCuentaController',
                templateUrl: 'pages/Admin/Cuentas/listar.html'
            })
            .otherwise({
                redirectTo: '/'
            });
});
