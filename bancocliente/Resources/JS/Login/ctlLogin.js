"use strict";
app.controller('loginController', function ($scope, $window, loginService) {
    
	$scope.login = function () {
        loginService.login($scope.cedula, $scope.password).then(function (response) {
        	if (response.data.respuesta) {
        		sessionStorage.setItem("usersession", response.data.resultado);
                sessionStorage.setItem("sesion", response.data.respuesta);
            	$window.location.href = "home.html";
        	}else{
        		alert(response.data.mensaje);
        	}
            
        });
    };

});