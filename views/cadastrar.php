<div class="container">
	<form method="POST">
		<div class="form-group">
			<label for="nome">Nome:</label>
			<input type="text" name="nome" id="nome" class="form-control" />
		</div>
		<div class="form-group">
			<label for="email">E-mail</label>
			<input type="email" name="email" id="email" class="form-control" />
		</div>
		<div class="form-group">
			<label for="senha">Senha</label>
			<input type="password" name="senha" id="senha" class="form-control" />
		</div>
		<div class="form-group">
			<label for="telefone">Telefone</label>
			<input type="text" name="telefone" id="telefone" class="form-control" />
		</div>
		<div class="form-group">
			<label for="premium">Seja Premium</label>
			<select name="premium" id="premium" class="form-control">
				<option value="0"></option>
				<option value="0">Não Obrigado</option>
				<option value="1">Ser Premium</option>
			</select>	
		</div>
		<input type="submit" value="Cadastrar" class="btn btn-default" />
	</form>
</div>