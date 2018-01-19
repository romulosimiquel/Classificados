<?php
class anunciosController extends controller {

	public function index() {

	}

	public function meusAnuncios() {
		$dados = array();

		$a = new Anuncios();

		$anuncios = $a->getMeusAnuncios();

		$dados['anuncios'] = $anuncios;

		$this->loadTemplate('anuncios', $dados);
	}

	public function addAnuncio() {
		$dados = array();

		$a = new Anuncios();
		$c = new Categorias();

		$cats = $c->getLista();

		if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {
			$titulo = addslashes($_POST['titulo']);
			$categoria = addslashes($_POST['categoria']);
			$valor = addslashes($_POST['valor']);
			$descricao = addslashes($_POST['descricao']);
			$estado = addslashes($_POST['estado']);

			$anuncio = $a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);

			header("Location: ".BASE_URL."/anuncios/meusAnuncios");
		}

		$dados['cats'] = $cats;

		$this->loadTemplate('addAnuncio', $dados);
	}

	public function editarAnuncio($id) {
		$dados = array();

		$a = new Anuncios();
		$c = new Categorias();

		$cats = $c->getLista();

		if (isset($id) && !empty($id)) {
			$info = $a->getAnuncio($id);	
		}	

		if(isset($_POST['titulo']) && !empty($_POST['titulo'])) {
			$titulo = addslashes($_POST['titulo']);
			$categoria = addslashes($_POST['categoria']);
			$valor = addslashes($_POST['valor']);
			$descricao = addslashes($_POST['descricao']);
			$estado = addslashes($_POST['estado']);
			if(isset($_POST['restrito'])) {
				$restrito = $_POST['restrito'];
			} else {
				$restrito = '';
			}
			if(isset($_FILES['fotos'])) {
				$fotos = $_FILES['fotos'];
			} else {
				$fotos = array();
			}

			$anuncio = $a->editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $restrito, $id);
		}


		$dados['cats'] = $cats;
		$dados['info'] = $info;

		$this->loadTemplate('editarAnuncio', $dados);
	}

	public function excluirAnuncio($id) {

		$a = new Anuncios();

		if( isset($id) && !empty($id)) {
			$a->excluirAnuncio($id);
			header("Location: ".BASE_URL."/anuncios/meusAnuncios");
		}

	}

	public function excluirFoto($id) {
		$a = new Anuncios();

		if( isset($id) && !empty($id)) {
			$id_anuncio = $a->excluirFoto($id);
		}

		if(isset($id_anuncio)) {
			header("Location: ".BASE_URL."anuncios/editarAnuncio/".$id_anuncio);
		} else{
			header("Location: ".BASE_URL."anuncios/meusAnuncios");
		}
	}
}