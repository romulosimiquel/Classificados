<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div class="carousel slide" data-ride="carousel" id="meuCarousel">
				<div class="carousel-inner" role="listbox">
					<?php foreach($info['fotos'] as $chave => $foto): ?>
					<div class="item <?php echo ($chave=='0')?'active':''; ?>">
						<img src="<?php echo BASE_URL?>assets/images/anuncios/<?php echo $foto['url']; ?>" />					
					</div>
					<?php endforeach; ?>
				</div>
				<a class="left carousel-control" href="#meuCarousel" role="button" data-slide="prev"><span><</span></a>
				<a class="right carousel-control" href="#meuCarousel" role="button" data-slide="next"><span>></span></a>
			</div>
		</div>
		<div class="col-sm-8">
			<h1><?php echo $info['titulo']?></h1>
			<h4><?php echo utf8_encode($info['categoria'])?></h4>
			<p><?php echo $info['descricao']?></p>
			<br/>
			<h3><?php echo $info['estado']?></h3>
			<h3>R$ <?php echo number_format($info['valor'], 2, ',', '.')?></h3>
			<h4><?php echo $info['telefone']?></h4>
			<h3><?php echo $info['comentarios']?></h3>		
		</div>
		<form method="POST">
			<div class="col-sm-2">
				<label for="comentario">Comentários</label>
				<textarea class="form-control" name="comentario"></textarea>
				<input type="submit" value="Salvar comentario" class="btn btn-default" />
			</div>
		</form>
		<div class="col sm-2">

			

		</div>
	</div>
</div>	