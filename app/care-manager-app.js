angular.module('CareManagerModule', ['ngRoute']);
angular.module('CareManagerService', []);

var app = angular.module('CareManager', [
    'ngRoute',
    'ngSanitize',
    'ngCookies',
    'CareManagerModule',
    'CareManagerService',
    'ui.mask'
]);

app.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider

        .when('/', {
            templateUrl: 'view/home.html',
            controller: 'HomeCtrl'
        })

        .when('/home', {
            templateUrl: 'view/home.html',
            controller: 'HomeCtrl'
        })

        .when('/idoso', {
            templateUrl: 'view/idoso-list.html',
            controller: 'IdosoCtrl'
        })

        .when('/idoso/:codIdoso', {
            templateUrl: 'view/idoso-edit.html',
            controller: 'IdosoCtrl'
        })

        .when('/usuario', {
            templateUrl: 'view/usuario-list.html',
            controller: 'UsuarioCtrl'
        })

        .when('/usuario/:codUsuario', {
            templateUrl: 'view/usuario-edit.html',
            controller: 'UsuarioCtrl'
        })

        /*
        .when('/login', {})*/
        .otherwise({ templateUrl: 'view/home.html' });

    $locationProvider.html5Mode(true);
}]);

app.run(['$rootScope', '$location', '$cookies', '$http', function ($rootScope, $location, $cookies, $http) {
    $rootScope.globals = $cookies.getObject('globals') || {};

    if ($rootScope.globals.currentUser) {
        $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
    }

    /*$rootScope.$on('$locationChangeStart', function () {
        if ($location.path() !== '/login' && !$rootScope.globals.currentUser) {
            window.location = 'login';
        }
    });*/
}]);

app.controller('MainCtrl', ['$scope', '$location', 'AuthenticationService', function($scope, $location, AuthenticationService) {
    /*$scope.logout = function() {
        AuthenticationService.ClearCredentials();
        window.location = 'login';
    };*/

    $scope.go = function(path) {
        $location.path(path);
    };
}]);