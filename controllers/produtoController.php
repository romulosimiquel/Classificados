<?php
class produtoController extends controller {

	public function index() {

	}


	public function abrir($id) {
		$dados = array();

		$a = new Anuncios();
		$u = new Usuarios();

		if(empty($id)){
			header("Location: ".BASE_URL);
			exit;
		}

		$info = $a->getAnuncio($id);

		if(isset($_POST['comentario']) && !empty($_POST['comentario'])) {
			$texto = $_POST['comentario'];

			if(!empty($texto)) {

				$comentario = $a->addComentario($id, $texto);


				header("Location: ".BASE_URL."produto/abrir/".$id);
			}
		}

		switch ($info['estado']) {
			case '1':
			$info['estado'] = 'Ruim';
			break;
			case '2':
			$info['estado'] = 'Bom';
			break;
			case '3':
			$info['estado'] = 'Ótimo';
			break;
		}

		$dados['info'] = $info;

		$this->loadTemplate('produto', $dados);

	}	
}

?>