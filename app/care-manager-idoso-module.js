var app = angular.module('CareManagerModule')
    .controller('IdosoCtrl', ['$scope', '$http', '$timeout', '$routeParams', '$location', function ($scope, $http, $timeout, $routeParams, $location) {

        $scope.idoso = {};

        $scope.page = "Idoso";

        $scope.idoso.ativo_idoso = true;

        $scope.usuarioSelecionado = {};

        if ($routeParams.codIdoso && $routeParams.codIdoso != 0) {
            getThisIdoso();
            getListCuidadorIdoso($routeParams.codIdoso);
            getListUsuarioCuidador();
            getListMedicacaoIdoso($routeParams.codIdoso);
        }
        else if(!$routeParams.codIdoso){
            getListIdoso();
        }

        if($scope.hasError)
            toastr.error($scope.msg);

        $scope.salvar = function () {
            if($routeParams.codIdoso == 0){
                insertIdoso();
            }
            else{
                updateIdoso();
            }
        };

        $scope.ativa = function(codIdoso) {
            ativaIdoso(codIdoso);
        };

        $scope.inativa = function(codIdoso) {
            inativaIdoso(codIdoso);
        };

        $scope.go = function(path) {
            $location.path(path);
        };

        $scope.vincularCuidador = function() {
            $scope.novoCuidador = {
                cod_idoso : $scope.idoso.cod_idoso,
                cod_usuario : $scope.usuarioSelecionado.codUsuario
            };

            $http.post('api/cuidadorIdoso/insert', $scope.novoCuidador).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    getListCuidadorIdoso($scope.idoso.cod_idoso);
                }
            });
        };

        $scope.removeCuidadorIdoso = function($codCuidadorIdoso) {

            $http.post('api/cuidadorIdoso/delete/' + $codCuidadorIdoso).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    getListCuidadorIdoso($scope.idoso.cod_idoso);
                }
            });
        };

        $scope.adicionarMedicacao = function() {
            $scope.novaMedicacao = {
                descricao_medicacaoIdoso : $scope.medicacaoIdoso.descricao_medicacaoIdoso,
                horario_medicacaoIdoso : $scope.medicacaoIdoso.horario_medicacaoIdoso,
                cod_idoso: $scope.idoso.cod_idoso
            };

            $http.post('api/medicacaoIdoso/insert', $scope.novaMedicacao).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    getListMedicacaoIdoso($scope.idoso.cod_idoso);
                }
            });
        };

        $scope.ativaMedicacaoIdoso = function($codMedicacaoIdoso) {

            $scope.ativaMedicacao = {
                cod_medicacaoIdoso : $codMedicacaoIdoso,
                cod_idoso : $scope.idoso.cod_idoso
            };

            $http.post('api/medicacaoIdoso/ativa', $scope.ativaMedicacao).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.medicacaoIdosoList = result.data;
                }
            });
        };

        $scope.inativaMedicacaoIdoso = function($codMedicacaoIdoso) {

            $scope.inativaMedicacao = {
                cod_medicacaoIdoso : $codMedicacaoIdoso,
                cod_idoso : $scope.idoso.cod_idoso
            };

            $http.post('api/medicacaoIdoso/inativa', $scope.inativaMedicacao).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.medicacaoIdosoList = result.data;
                }
            });
        };

        function insertIdoso(){
            $http.post('api/idoso/insert', $scope.idoso).then(function (response) {
                var result = response.data;

                $scope.message = result.msg;
                $scope.hasError = result.hasError;

                if(!$scope.hasError){

                    $scope.idoso = result.data;
                    alert($scope.message);

                    $location.path('idoso/' + $scope.idoso.cod_idoso);
                }
                else{
                    alert($scope.message);
                }

            });
        }

        function updateIdoso() {
            $http.post('api/idoso/update', $scope.idoso).then(function (response) {
                var result = response.data;
                $scope.idoso = result.data;
                $scope.message = result.msg;
                $scope.hasError = result.hasError;

                alert('Idoso atualizado com sucesso');

            });
        }

        function getThisIdoso(){
            $http.get('api/idoso/get/' + $routeParams.codIdoso).then(function (response) {
                var result = response.data;

                if(!result.hasError) {
                    $scope.idoso = result.data;
                }
            });
        }

        function getListIdoso(){
            $http.get('api/idoso/list/').then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.idosoList = result.data;
                }
            });
        }

        function inativaIdoso(codIdoso) {
            $http.get('api/idoso/inativa/' + codIdoso).then(function (response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {

                    $scope.idosoList = result.data;

                    alert('Idoso inativado com sucesso');
                } else  {
                    alert('Falha ao inativar idoso');
                }

            });
        }

        function ativaIdoso(codIdoso) {
            $http.get('api/idoso/ativa/' + codIdoso).then(function (response) {
                var result = response.data;
                $scope.hasError = result.hasError;
                $scope.msg = result.msg;

                if (!result.hasError) {

                    $scope.idosoList = result.data;

                    alert('Idoso ativado com sucesso');
                } else  {
                    alert('Falha ao ativar idoso');
                }

            });
        }

        function getListCuidadorIdoso(codIdoso){
            $http.get('api/cuidadorIdoso/list/' + codIdoso).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.cuidadorIdosoList = result.data;
                }
            });
        }

        function getListUsuarioCuidador(){
            $http.get('api/usuario/listCuidador/').then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.cuidadorList = result.data;
                }
            });
        }

        function getListMedicacaoIdoso(codIdoso){
            $http.get('api/medicacaoIdoso/list/' + codIdoso).then(function (response) {

                var result = response.data;

                if(!result.hasError) {
                    $scope.medicacaoIdosoList = result.data;
                }
            });
        }

    }]);
