<!DOCTYPE html>
<html lang="pt-br" ng-app="app">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Teste | Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <!-- Navbar fixa -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="#">Teste</a>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" href="#!/dashboard">Dashboard</a>
          <a class="nav-link" href="#!/clientes">Clientes</a>
          <a class="nav-link" href="<?= base_url() ?>auth/logout">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Área dinâmica para carregar as páginas -->
  <div class="container mt-4">
    <div ng-view></div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-route.min.js"></script>
  <script src="<?= base_url() ?>static/app/app.js"></script>

</body>

</html>