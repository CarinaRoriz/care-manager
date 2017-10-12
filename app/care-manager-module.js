var app = angular.module('CareManagerModule')

    .controller('LoginCtrl', ['$scope', '$rootScope', '$location', '$http', 'AuthenticationService', function ($scope, $rootScope, $location, $http, AuthenticationService){

        /*$("#loginForm").xLogin({
            onLogin: login
        });

        function login(xLogin) {
            AuthenticationService.ClearCredentials();
            AuthenticationService.Login($scope.username, $scope.password, function(response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {
                    AuthenticationService.SetCredentials($scope.username, $scope.password);
                }

                xLogin.loginCallback(result, 'home');
            });
        }*/
    }])

    .controller('HomeCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.page = "Home";
    }]);