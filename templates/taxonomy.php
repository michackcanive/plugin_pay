<div class="wrap">
	<h1>Minha Carteira</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>"><a href="#tab-1">Sua Carteira</a></li>
	
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_taxonomy"]) ? 'active' : '' ?>">

			<h3>Meus dados Da Carteira </h3>

				<table class="cpt-table">
				<tr><th>Meu Numero</th>
				<th>Nome Da Conta</th>
				<th class="text-center">Tipo de Conta</th>
				<th class="text-center">Saldo Da Conta</th>
				</tr>

			<tr>
					<td><?php echo $infor->dados->nome_nego ?></td>
					<td><?php echo $infor->dados->telefone ?></td>
					<td><?php echo $infor->dados->tipo_de_conta ?></td>
					<td class="text-center"><?php echo $infor->dados->saldo_da_conta ?> Kz</td>
			</tr>
					
			

			</table>
		
			
		</div>



	</div>
</div>