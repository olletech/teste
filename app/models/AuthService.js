// models/authService.js
app.service('AuthService', function ($http, $q) {
  this.login = function (username, password) {
    return $http.post('/backend/auth/realizar_login', { email: username, senha: password });
  };

  this.logout = function () {
    return $http.post('/backend/auth/logout');
  };
});
