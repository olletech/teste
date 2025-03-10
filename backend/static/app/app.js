var app = angular.module('app', ['ngRoute']);

app.config(function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            templateUrl: 'dashboard/index',
            controller: 'DashboardController'
        })
        .when('/login', {
            templateUrl: 'auth/login',
            controller: 'LoginController'
        })
        .when('/usuarios', {
            templateUrl: 'usuarios/listar',
            controller: 'UsuarioController'
        })
        .when('/usuarios/adicionar', {
            templateUrl: 'usuarios/adicionar',
            controller: 'UsuarioController'
        })
        .when('/usuarios/editar/:id', {
            templateUrl: function(params) {
                return 'usuarios/editar/' + params.id;
            },
            controller: 'UsuarioController'
        })
        .when('/clientes', {
            templateUrl: 'customer/index',
            controller: 'ClienteController'
        })
        .when('/clientes/adicionar', {
            templateUrl: 'clientes/adicionar',
            controller: 'ClienteController'
        })
        .when('/clientes/editar/:id', {
            templateUrl: function(params) {
                return 'clientes/editar/' + params.id;
            },
            controller: 'ClienteController'
        })
        .otherwise({
            redirectTo: '/'
        });

    $locationProvider.hashPrefix('');
});


// Controller para Login
app.controller('LoginController', function($scope, $http, $location) {
    $scope.user = { email: '', senha: '' };
    $scope.errorMessage = '';

    $scope.login = function() {
        $http.post('http://localhost/auth/realizar_login', $scope.user)
            .then(function(response) {
                if (response.data.success) {
                    $location.path('/'); // Redireciona para o dashboard
                } else {
                    $scope.errorMessage = response.data.message;
                }
            }, function(error) {
                $scope.errorMessage = 'Erro ao autenticar usuário';
            });
    };
});

// Controller para Usuários
app.controller('UsuarioController', function($scope, $http, $location) {
    $scope.usuarios = [];

    $scope.listarUsuarios = function() {
        $http.get('http://localhost/usuarios/listar')
            .then(function(response) {
                $scope.usuarios = response.data;
            });
    };

    $scope.adicionarUsuario = function() {
        $location.path('/usuarios/adicionar');
    };

    $scope.editarUsuario = function(id) {
        $location.path('/usuarios/editar/' + id);
    };

    $scope.deletarUsuario = function(id) {
        if (confirm('Tem certeza que deseja excluir?')) {
            $http.delete('http://localhost/usuarios/deletar/' + id)
                .then(function(response) {
                    $scope.listarUsuarios();
                });
        }
    };
});

// Controller para Clientes
app.controller('ClienteController', function($scope, $http, $location) {
    $scope.clientes = [];

    $scope.listarClientes = function() {
        $http.get('http://localhost/clientes/listar')
            .then(function(response) {
                $scope.clientes = response.data;
            });
    };

    $scope.adicionarCliente = function() {
        $location.path('/clientes/adicionar');
    };

    $scope.editarCliente = function(id) {
        $location.path('/clientes/editar/' + id);
    };

    $scope.deletarCliente = function(id) {
        if (confirm('Tem certeza que deseja excluir?')) {
            $http.delete('http://localhost/clientes/deletar/' + id)
                .then(function(response) {
                    $scope.listarClientes();
                });
        }
    };
});
