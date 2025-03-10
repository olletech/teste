<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth
{

  protected $CI;

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library('session');
    $this->CI->load->database();
  }

  public function login($email, $senha)
  {
    $query = $this->CI->db->get_where('usuarios', ['email' => $email]);
    $usuario = $query->row();

    if ($usuario && password_verify($senha, $usuario->senha)) {
      // Salva os dados do usuário na sessão
      $this->CI->session->set_userdata([
        'user_id' => $usuario->id,
        'user_nome' => $usuario->nome,
        'user_email' => $usuario->email,
        'logged_in' => TRUE
      ]);
      return TRUE;
    }

    return FALSE;
  }

  public function logout()
  {
    $this->CI->session->unset_userdata(['user_id', 'user_nome', 'user_email', 'logged_in']);
    $this->CI->session->sess_destroy();
  }

  public function is_logged_in()
  {
    return $this->CI->session->userdata('logged_in') ? TRUE : FALSE;
  }

  public function get_user()
  {
    if ($this->is_logged_in()) {
      return [
        'id' => $this->CI->session->userdata('user_id'),
        'nome' => $this->CI->session->userdata('user_nome'),
        'email' => $this->CI->session->userdata('user_email')
      ];
    }
    return NULL;
  }
}