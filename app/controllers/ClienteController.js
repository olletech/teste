// controllers/clientController.js
app.controller('ClienteController', function ($scope, ClienteService) {
  $scope.clientes = [];
  $scope.newClient = {};

  // Função para buscar clientes
  $scope.getClients = function () {
    ClienteService.getCustomer().then(function (response) {
      console.log('resultado', response.data);
      $scope.clientes = response.data;
    });
  };

  // Função para adicionar um cliente
  $scope.addClient = function (client) {
    // Cria um FormData para o upload
    console.log('client', document.getElementById('file').files[0]);
    var formData = new FormData();
    formData.append("nome", client.nome);
    formData.append("cnpj", client.cnpj);
    formData.append("logo", document.getElementById('file').files[0]); // A imagem é um arquivo, então é necessário adicioná-la com FormData

    // Envia os dados do cliente e a imagem para o backend
    ClienteService.addCustomerWithImage(formData).then(function (response) {
      $scope.getClients();
      $scope.newClient = {}; // Limpa o formulário

      $scope.errorMessage = '';
      if (response.data.error) {
        $scope.errorMessage = response.data.error;
      }
    }, function (error) {
      $scope.errorMessage = 'Erro ao adicionar cliente: ' + error.message;
    });
  };

  // Função para excluir um cliente
  $scope.deleteClient = function (clientId) {
    ClienteService.deleteCustomer(clientId).then(function (response) {
      $scope.getClients();
    });
  };

  // Função para exportar clientes para Excel
  $scope.exportToExcel = function () {
    ClienteService.exportToExcel().then(function (response) {
      // Criar um link de download
      console.log('response data', response.data.file_url);
      var blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = 'clientes.xls'; // Nome do arquivo
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }).catch(function (error) {
      console.error('Erro ao exportar para Excel:', error);
    });
  };

  // Função para imprimir clientes
  $scope.printClients = function () {
    ClienteService.printCustomer().then(function (response) {
      // Lógica de impressão
      window.open('/backend/customer/imprimir_clientes', '_blank');
    });
  };

  // Inicializa a listagem de clientes
  $scope.getClients();
});
