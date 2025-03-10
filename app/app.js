var app = angular.module('clientApp', ['ngRoute']);

// Configuração das rotas
app.config(function ($routeProvider) {
  $routeProvider
    .when('/login', {
      templateUrl: 'app/views/login.html',
      controller: 'AuthController'
    })
    .when('/clientes', {
      templateUrl: 'app/views/clientes.html',
      controller: 'ClienteController'
    })
    .when('/layout', {
      templateUrl: 'app/views/layout.html',
      controller: 'MainController'
    })
    .otherwise({
      redirectTo: '/login'
    });
});
