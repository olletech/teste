<?php
class M_usuario extends DataMapper
{
  var $table = 'usuarios'; // Nome da tabela no banco de dados

  // Definindo regras de validação para o login
  var $validation = array(
    'email' => array(
      'label' => 'E-mail',
      'rules' => array('required', 'valid_email')
    ),
    'senha' => array(
      'label' => 'Senha',
      'rules' => array('required', 'min_length[6]')
    )
  );

  // Método para autenticar o usuário
  public function autenticar($email, $senha)
  {
    $usuario = new M_usuario();
    $usuario->where('email', $email)->get();

    if ($usuario->exists() && password_verify($senha, $usuario->senha)) {
      return $usuario; // Retorna o usuário autenticado
    } else {
      return null; // Retorna null se não encontrar o usuário ou senha inválida
    }
  }

  // Método para criptografar a senha antes de salvar
  public function set_senha($senha)
  {
    $this->senha = password_hash($senha, PASSWORD_BCRYPT);
  }
}