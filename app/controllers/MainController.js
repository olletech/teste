app.controller('MainController', ['$scope', function ($scope) {
  $scope.title = "Bem-vindo ao Sistema";

  $scope.menuItems = [
    { name: "Dashboard", path: "#!/dashboard" },
    { name: "Clientes", path: "#!/clientes" },
    { name: "Sair", path: "#!/logout" }
  ];

  $scope.currentYear = new Date().getFullYear();
}]);