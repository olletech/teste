<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    //$this->load->library('auth');
    //$this->load->model('M_usuario');
    $this->load->helper(array('form', 'url'));
    $this->module = 'auth';
  }
  public function index()
  {
    if ($this->session->userdata('usuario_id')) {
      redirect('/');
    } else {
      redirect('auth/login');
    }
  }

  public function login()
  {
    if ($this->session->userdata('usuario_id')) {
      redirect('/');
    } else {
      $this->load->view($this->module . '/login');
    }
  }

  public function realizar_login()
  {
    $input = json_decode(file_get_contents('php://input'), true);

    $email = $input['email'];
    $senha = $input['senha'];

    $usuario = new M_usuario();
    $usuario_autenticado = $usuario->autenticar($email, $senha);

    if ($usuario_autenticado) {
      $dados = array(
        'usuario_id' => $usuario_autenticado->id,
        'email' => $usuario_autenticado->email,
        'nome' => $usuario_autenticado->nome
      );
      $this->session->set_userdata($dados);
      echo json_encode(['success' => true, 'dados' => $dados]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
    }
  }

  public function logout()
  {
    $this->session->unset_userdata('usuario_id');
    redirect('auth/login');
  }
}