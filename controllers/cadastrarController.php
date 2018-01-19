<?php
class cadastrarController extends controller {

	public function index() {

	}

	public function cadastro() {
		$dados = array();

		$u = new Usuarios();
		if(isset($_POST['nome']) && !empty($_POST['nome'])) {
			$nome = addslashes($_POST['nome']);
			$email = addslashes($_POST['email']);
			$senha = $_POST['senha'];
			$telefone = addslashes($_POST['telefone']);
			$premium = $_POST['premium'];

			if(!empty($nome) && !empty($email) && !empty($senha)) {

				$usuario = $u->cadastrar($nome, $email, $senha, $telefone, $premium);

				header("Location: ".BASE_URL."login/logar");

			}
		}

		$this->loadTemplate('cadastrar', $dados);
	}
}
