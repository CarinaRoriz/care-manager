var app = angular.module('CareManagerModule')
    .controller('UsuarioCtrl', ['$scope', '$http', '$timeout', '$routeParams', '$location', function ($scope, $http, $timeout, $routeParams, $location) {

        $scope.usuario = {};

        $scope.page = "Usuário";

        $scope.usuario.ativo_usuario = true;

        $scope.usuario.cod_perfil = "1";

        if ($routeParams.codUsuario && $routeParams.codUsuario != 0) {
            getThisUsuario();
        }
        else if(!$routeParams.codUsuario){
            getListUsuario();
        }

        if($scope.hasError)
            toastr.error($scope.msg);

        $scope.salvar = function () {
            if($routeParams.codUsuario == 0){
                insertUsuario();
            }
            else{
                updateUsuario();
            }
        };

        $scope.ativa = function(codUsuario) {
            ativaUsuario(codUsuario);
        };

        $scope.inativa = function(codUsuario) {
            inativaUsuario(codUsuario);
        };

        $scope.go = function(path) {
            $location.path(path);
        };


        function insertUsuario(){
            $http.post('api/usuario/insert', $scope.usuario).then(function (response) {
                var result = response.data;

                $scope.message = result.msg;
                $scope.hasError = result.hasError;

                if(!$scope.hasError){

                    $scope.usuario = result.data;
                    alert($scope.message);

                    $location.path('usuario/' + $scope.usuario.cod_usuario);
                }
                else{
                    alert($scope.message);
                }

            });
        }

        function updateUsuario() {
            $http.post('api/usuario/update', $scope.usuario).then(function (response) {
                var result = response.data;
                $scope.usuario = result.data;
                $scope.message = result.msg;
                $scope.hasError = result.hasError;

                alert('Usuário atualizado com sucesso');

            });
        }

        function getThisUsuario(){
            $http.get('api/usuario/get/' + $routeParams.codUsuario).then(function (response) {
                var result = response.data;

                if(!result.hasError) {
                    $scope.usuario = result.data;
                }
            });
        }

        function getListUsuario(){
            $http.get('api/usuario/list/').then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.usuarioList = result.data;
                }
            });
        }

        function inativaUsuario(codUsuario) {
            $http.get('api/usuario/inativa/' + codUsuario).then(function (response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {

                    $scope.usuarioList = result.data;

                    alert('Usuário inativado com sucesso');
                } else  {
                    alert('Falha ao inativar usuário');
                }

            });
        }

        function ativaUsuario(codUsuario) {
            $http.get('api/usuario/ativa/' + codUsuario).then(function (response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {

                    $scope.usuarioList = result.data;

                    alert('Usuário ativado com sucesso');
                } else  {
                    alert('Falha ao ativar usuário');
                }

            });
        }

    }]);
