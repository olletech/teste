<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_customer');
    $this->load->library('upload');
  }

  public function index()
  {
    $clientes = new M_customer();
    $clientes_ = $clientes->get();
    $cli = $clientes_->all_to_array();

    $data['clientes'] = $cli;
    echo json_encode($cli);
  }

  public function addClientWithImage()
  {
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
      $config['upload_path'] = './uploads/'; // Pasta onde a imagem será salva
      $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Tipos de arquivos permitidos
      $config['max_size'] = 2048; // Tamanho máximo do arquivo (em KB)
      $config['file_name'] = time() . '_' . $_FILES['logo']['name']; // Nome único para a imagem

      $this->upload->initialize($config);

      if ($this->upload->do_upload('logo')) {
        $data = $this->upload->data();
        $file_path = base_url('uploads/' . $data['file_name']); // Caminho completo da imagem

        // Dados do cliente
        $cliente_data = array(
          'nome' => $this->input->post('nome'),
          'cnpj' => $this->input->post('cnpj'),
          'logo' => $file_path, // Caminho da imagem
          'created_at' => date('Y-m-d H:i:s')
        );

        // Salva o cliente no banco de dados
        $this->M_customer->insert($cliente_data);

        echo json_encode(['status' => 'success', 'message' => 'Cliente adicionado com sucesso!']);
      } else {
        // Se houver erro no upload
        echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
      }
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Nenhum arquivo foi enviado ou ocorreu um erro no envio do arquivo.']);
    }
  }


  public function salvar()
  {
    $this->load->library('upload');

    $cnpj = $this->input->post('cnpj');
    $cliente_existente = new M_customer();
    $cliente_existente->where('cnpj', $cnpj)->get();

    if ($cliente_existente->exists()) {
      echo json_encode(['error' => 'CNPJ já cadastrado']);
      return;
    }

    $cliente = new M_customer();
    $cliente->nome = $this->input->post('nome');
    $cliente->cnpj = $cnpj;

    if (!empty($_FILES['logo']['name'])) {
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'jpg|png';
      $config['file_name'] = time() . '_' . $_FILES['logo']['name'];

      $this->upload->initialize($config);
      if ($this->upload->do_upload('logo')) {
        $upload_data = $this->upload->data();
        $cliente->logo = $upload_data['file_name'];
      }
    }

    $cliente->save();
    echo json_encode(['success' => true]);
  }

  // controllers/Customer.php
  public function export_to_excel()
  {
    //ob_clean();
    ob_start();
    require_once APPPATH . 'libraries/PhpSpreadsheet_lib.php';
    $this->phpspreadsheet_lib = new PhpSpreadsheet_lib();
    if (!isset($this->phpspreadsheet_lib)) {
      die("A biblioteca não foi carregada!");
    }
    //echo "Biblioteca carregada com sucesso!";

    $clientes = new M_customer();
    // Obter os clientes
    $clientes_ = $clientes->get();
    $cli = $clientes_->all_to_array();

    if (!empty($cli)) {
      // Define o nome do arquivo
      $fileName = 'clientes.xls';

      // Gera o Excel e captura a saída
      $excelData = $this->phpspreadsheet_lib->exportToExcel($cli, $fileName, false);

      // Define os cabeçalhos para o download
      header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header("Content-Disposition: attachment; filename=\"$fileName\"");
      header("Cache-Control: max-age=0");

      // Envia o arquivo para o navegador
      echo $excelData;
      exit;
    } else {
      show_error('Nenhum cliente encontrado para exportação.', 404);
    }
  }


  public function delete($id)
  {
    $cliente = new M_customer();
    $cliente->where('id', $id)->get();

    if ($cliente->exists()) {
      $cliente->delete();
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['error' => 'Cliente não encontrado']);
    }
  }

  public function testar_biblioteca()
  {
    require_once APPPATH . 'libraries/PhpSpreadsheet_lib.php';
    $this->phpspreadsheet_lib = new PhpSpreadsheet_lib();
    if (!isset($this->phpspreadsheet_lib)) {
      die("A biblioteca não foi carregada!");
    }
    echo "Biblioteca carregada com sucesso!";
  }

  public function imprimir_clientes()
  {
    // Carrega o modelo
    $cliente = new M_customer();

    // Obtém os clientes
    $clientes_ = $cliente->get();
    $cli = $clientes_->all_to_array();

    if (empty($cli)) {
      echo "<h3>Nenhum cliente encontrado.</h3>";
      return;
    }

    // Inicia a saída HTML para impressão
    echo "<html><head><title>Lista de Clientes</title>";
    echo "<style>
            body { font-family: Arial, sans-serif; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid black; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
          </style>";
    echo "</head><body>";

    echo "<h2>Lista de Clientes</h2>";
    echo "<table>";
    echo "<thead><tr><th>ID</th><th>Nome</th><th>Email</th></tr></thead><tbody>";

    foreach ($cli as $cliente) {

      echo "<tr>
                <td>{$cliente['id']}</td>
                <td>{$cliente['nome']}</td>
                <td>{$cliente['cnpj']}</td>
              </tr>";
    }

    echo "</tbody></table>";
    echo "<script>window.print();</script>"; // Dispara a impressão automática
    echo "</body></html>";
  }
}