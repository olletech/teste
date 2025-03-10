// controllers/authController.js
app.controller('AuthController', function ($scope, AuthService, $location) {
  $scope.login = function () {
    AuthService.login($scope.username, $scope.password).then(function (response) {
      if (response.data.success) {
        console.log(response.data.dados.email);

        $location.path('/layout');
      } else {
        $scope.errorMessage = 'Usuário ou senha inválidos!';
      }
    });
  };

  $scope.logout = function () {
    AuthService.logout().then(function (response) {
      $location.path('/login');
    });
  };
});
