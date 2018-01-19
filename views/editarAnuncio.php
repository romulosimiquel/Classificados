<div class="container">
	<h1>Meu Anuncios - Editar Anuncio</h1>

	<form method="POST" enctype="multipart/form-data">
		
		<div class="form-group">
			<label for="categoria">Categorias</label>
			<select name="categoria" id="categoria" class="form-control">
				<?php
				foreach ($cats as $cat): 
				?>
				<option value="<?php echo $cat['id']; ?>"<?php echo ($info['id_categoria']==$cat['id'])?
				'selected="selected"':'';?>> <?php echo utf8_encode($cat['nome']); ?></option>
				<?php
				endforeach;
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="titulo">Titulo</label>
			<input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo $info['titulo']?>" />
		</div>
		<div class="form-group">
			<label for="valor">Valor</label>
			<input type="text" name="valor" id="valor" class="form-control" value="<?php echo $info['valor']?>">
		</div>
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" name="descricao"><?php echo $info['descricao']?></textarea>
		</div>
		<div class="form-group">
			<label for="estado">Estado de Conservação</label>
			<select name="estado" id="estado" class="form-control" "<?php echo $info['estado']?>">
				<option></option>
				<option value="1" <?php echo $info['estado']=='1'?'selected="selected"':'';?> >Ruim</option>
				<option value="2" <?php echo $info['estado']=='2'?'selected="selected"':'';?> >Bom</option>
				<option value="3" <?php echo $info['estado']=='3'?'selected="selected"':'';?> >Ótimo</option>
			</select>
		</div>

		<div class="form-group">
			<label for="add_foto">Fotos do Anúncio</label>
			<input type="file" name="fotos[]" multiple /></br>

			<div class="panel panel-default">
				<div class="panel panel-heading">Fotos do Anúncio</div>
				<div class="panel-body">
					<?php foreach ($info['fotos'] as $foto):?>
					<div class="foto_item">
						<img src="<?php echo BASE_URL?>assets/images/anuncios/<?php echo $foto['url']; ?>" class="img-thumbnail" border="0" /><br/>
						<a href="<?php echo BASE_URL?>anuncios/excluirFoto/<?php echo $foto['id']; ?>" 
						class="btn btn-default">Excluir foto</a>
					</div>
				<?php endforeach ?>
				</div>
			<div class="form-group">
			<label for="restrito">Deixar restrito?</label>
			<select name="restrito" id="restrito" class="form-control">
				<option></option>
				<option value="0" <?php echo $info['restrito']=='0'?'selected="selected"':'';?> >Anúncio não Restrito</option>
				<option value="1" <?php echo $info['restrito']=='1'?'selected="selected"':'';?> >Anúncio Restrito</option>
			</select>
		</div>
			</div>
		</div>
		<input type="submit" value="Salvar" class="btn btn-default" />
	</form>

</div>