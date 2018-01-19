<?php
class Anuncios extends model {

	public function getTotalAnuncios($filtros) {

		$filtroString = array('1=1');

		if(!empty($filtros['categoria'])) {
			$filtroString[] = 'anuncios.id_categoria = :id_categoria';
		}
		if(!empty($filtros['valor'])) {
			$filtroString[] = 'anuncios.valor BETWEEN :valor1 AND :valor2';
		}
		if(!empty($filtros['estado'])) {
			$filtroString[] = 'anuncios.estado = :estado';
		}

		$sql = $this->db->prepare("SELECT count(*) AS c FROM anuncios WHERE ".implode(' AND ', $filtroString));

		if(!empty($filtros['categoria'])) {
			$sql->bindValue(':id_categoria',$filtros['categoria']);
		}
		if(!empty($filtros['valor'])) {
			$valor = explode('-', $filtros['valor']);
			$sql->bindValue(':valor1',$valor[0]);
			$sql->bindValue(':valor2',$valor[1]);
		}
		if(!empty($filtros['estado'])) {
			$sql->bindValue(':estado',$filtros['estado']);
		}

		$sql->execute();
		$row = $sql->fetch();

		return $row['c'];
	}

	public function getUltimosAnuncios($page, $perPage, $filtros) {

		$offset = ($page - 1) * $perPage;

		$array = array();

		$filtroString = array('1=1');

		if(!empty($filtros['categoria'])) {
			$filtroString[] = 'anuncios.id_categoria = :id_categoria';
		}
		if(!empty($filtros['valor'])) {
			$filtroString[] = 'anuncios.valor BETWEEN :valor1 AND :valor2';
		}
		if(!empty($filtros['estado'])) {
			$filtroString[] = 'anuncios.estado = :estado';
		}

		$sql = $this->db->prepare("SELECT *, (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1) as url, (select categorias.nome from categorias where categorias.id = anuncios.id_categoria) as categoria FROM anuncios WHERE ".implode(' AND ', $filtroString)." ORDER BY id DESC LIMIT $offset, 2");

		if(!empty($filtros['categoria'])) {
			$sql->bindValue(':id_categoria',$filtros['categoria']);
		}
		if(!empty($filtros['valor'])) {
			$valor = explode('-', $filtros['valor']);
			$sql->bindValue(':valor1',$valor[0]);
			$sql->bindValue(':valor2',$valor[1]);
		}
		if(!empty($filtros['estado'])) {
			$sql->bindValue(':estado',$filtros['estado']);
		}

		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;		
	}

	public function getMeusAnuncios() {

		$array = array();
		$sql = $this->db->prepare("SELECT *, (select anuncios_imagens.url from anuncios_imagens where anuncios_imagens.id_anuncio = anuncios.id limit 1) as url FROM anuncios WHERE id_usuario = :id_usuario");
		$sql->bindValue(":id_usuario", $_SESSION['cLogin']);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
			

		}

		return $array;
	}

	public function getAnuncio($id) {

		$array = array();
		$sql = $this->db->prepare("SELECT *, (select categorias.nome from categorias where categorias.id = anuncios.id_categoria) as categoria, (select usuarios.telefone from usuarios where usuarios.id = anuncios.id_usuario) as telefone, (select comentarios.texto from comentarios where comentarios.id = anuncios.id) as comentarios FROM anuncios WHERE id = :id");
		$sql->bindValue(":id",$id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch();
			$array['fotos'] = array();

			$sql = $this->db->prepare("SELECT id,url FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
			$sql->bindValue(":id_anuncio",$id);
			$sql->execute();

			if($sql->rowCount() > 0) {
				$array['fotos'] = $sql->fetchAll();
			}
		}



		return $array;
	}

	public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado) {

		$sql = $this->db->prepare("INSERT INTO anuncios SET titulo = :titulo, id_categoria = :id_categoria, valor = :valor, id_usuario = :id_usuario, descricao = :descricao, estado = :estado");
		$sql->bindValue(":titulo", $titulo);
		$sql->bindValue(":id_categoria", $categoria);
		$sql->bindValue(":id_usuario", $_SESSION['cLogin']);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":estado", $estado);
		$sql->execute();
		
	}

	public function editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $restrito, $id) {

		$sql = $this->db->prepare("UPDATE anuncios SET  titulo = :titulo, id_categoria = :id_categoria, valor = :valor, id_usuario = :id_usuario, descricao = :descricao, estado = :estado, restrito = :restrito WHERE id = :id");
		$sql->bindValue(":titulo", $titulo);
		$sql->bindValue(":id_categoria", $categoria);
		$sql->bindValue(":id_usuario", $_SESSION['cLogin']);
		$sql->bindValue(":valor", $valor);
		$sql->bindValue(":descricao", $descricao);
		$sql->bindValue(":estado", $estado);
		$sql->bindValue(":restrito", $restrito);
		$sql->bindValue(":id", $id);

		$sql->execute();

		if(count($fotos) > 0) {
			for($q=0;$q<count($fotos['tmp_name']);$q++) {
				$tipo = $fotos['type'][$q];
				if(in_array($tipo,array('image/jpeg','image/png'))) {
					$tmpname = md5(time().rand(0,9999)).'.jpg';
					move_uploaded_file($fotos['tmp_name'][$q], 'assets/images/anuncios/'.$tmpname);

					list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/'.$tmpname);

					$ratio = $width_orig/$height_orig;

					$width = 500;
					$height = 500;

					if($width/$height > $ratio) {
						$width = $height*$ratio; 
					} else {
						$height = $width/$ratio;
					}

					$img = imagecreatetruecolor($width, $height);
					if($tipo == 'image/jpeg') {
						$origi = imagecreatefromjpeg('assets/images/anuncios/'.$tmpname);
					} elseif($tipo == 'image/png') {
						$origi = imagecreatefrompng('assets/images/anuncios/'.$tmpname);
					}

					imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

					imagejpeg($img, 'assets/images/anuncios/'.$tmpname, 80);

					$sql = $this->db->prepare("INSERT INTO anuncios_imagens SET url = :url, id_anuncio = :id_anuncio");
					$sql->bindValue('url',$tmpname);
					$sql->bindValue('id_anuncio', $id);
					$sql->execute();
				}
			}
		}
}


	public function excluirAnuncio($id) {

		$sql = $this->db->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
		$sql->bindValue(":id_anuncio",$id);
		$sql->execute();

		$sql = $this->db->prepare("DELETE FROM anuncios WHERE id = :id");
		$sql->bindValue(":id",$id);
		$sql->execute();
	}

	public function excluirFoto($id) {

		$id_anuncio = 0;

		$sql = $this->db->prepare("SELECT id_anuncio FROM anuncios_imagens WHERE id = :id");
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$row = $sql->fetch();
			$id_anuncio = $row['id_anuncio'];
		}

		$sql = $this->db->prepare("DELETE FROM anuncios_imagens WHERE id = :id");
		$sql->bindValue(":id",$id);
		$sql->execute();

		return $id_anuncio;
	}

	public function addComentario($id, $texto) {

		$sql = $this->db->prepare("INSERT INTO comentarios SET texto = :texto, id_usuario = :id_usuario, id_anuncio = :id_anuncio");
		$sql->bindValue(":texto", $texto);
		$sql->bindValue(":id_usuario", $_SESSION['cLogin']);
		$sql->bindValue(":id_anuncio", $id);
		$sql->execute();
		
	}



}