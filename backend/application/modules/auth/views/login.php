<!DOCTYPE html>
<html lang="pt-br" ng-app="app">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
  <!-- ngRoute (Roteamento) -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>
  <script src="/static/app/app.js"></script>
</head>

<body ng-controller="LoginController">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3 mt-5">
        <h1>Autenticação</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-3 mt-5">
        <form ng-submit="login()">
          <label for="email" class="form-label">E-mail:</label>
          <input type="email" class="form-control" ng-model="user.email" required><br>

          <label for="senha" class="form-label">Senha:</label>
          <input type="password" class="form-control" ng-model="user.senha" required><br>

          <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

        <div ng-if="errorMessage" class="alert alert-danger mt-3">
          {{ errorMessage }}
        </div>
      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>
</body>

</html>