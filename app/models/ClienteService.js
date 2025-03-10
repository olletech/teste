// models/clientService.js
app.service('ClienteService', function ($http, $q) {
    this.getCustomer = function () {
        console.log('getCustomer');
        return $http.get('/backend/customer/index');
    };

    this.addCustomerWithImage = function (formData) {

        return $http.post('/backend/customer/salvar', formData, {
            headers: {
                'Content-Type': undefined // Deixe o AngularJS determinar o tipo de conteúdo
            },
            transformRequest: angular.identity
        });
    };

    this.addCustomer = function (client) {
        return $http.post('/backend/customer/add', client);
    };

    this.deleteCustomer = function (clientId) {
        return $http.delete('/backend/customer/delete/' + clientId);
    };

    this.exportToExcel = function () {
        return $http.get('/backend/customer/export_to_excel', { responseType: 'arraybuffer' })
            .then(function (response) {
                console.log('response', response.data);
                // Converter a resposta em Blob e retornar o URL para download
                var blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

                // Cria um link temporário para o download
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'clientes.xlsx';

                // Adiciona ao DOM e dispara o clique para baixar
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
    };

    this.printCustomer = function () {
        return $http.get('/backend/customer/imprimir_clientes');
    };
});
