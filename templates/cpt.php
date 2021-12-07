<div class="wrap">
	<h1>Gestão de Intermediação Nego</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>"><a href="#tab-1">Intermediação Feitas</a></li>
		<li class="<?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
			<a href="#tab-2">
				 Minhas Sms Nego 
			</a>
		</li>

		
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>">

			<h3>Intermediação</h3>

			<?php 
				$options = get_option( 'ajec_indermediacao_cpt' ) ?: array();

				echo '<table class="cpt-table">
			
				<th>Nª Encomenda</th>
				<th>Cliente</th>
				<th>Nª Cliente</th>
				<th>Custo</th>
				<th class="text-center">Taxa da Encomenda</th>
				<th class="text-center">Tipo de encomenda</th>
				<th class="text-center">Tempo para receber</th>
				<th class="text-center">Data de Acção</th>
				<th class="text-center">Acção</th>
				';
				
					$public = isset($option['public']) ? "TRUE" : "FALSE";
					$archive = isset($option['has_archive']) ? "TRUE" : "FALSE";
					foreach($infor->dados as $dado){ 

					echo "<tr>
					<td>#".$dado->id_produto_encomenda."</td>
					<td>".$dado->nome_para."</td>
					<td>".$dado->telefone_proprietario."</td>
					<td>".$dado->valor_intermediacao_nego."".$infor->tip_de_valor."</td>
					<td class=\"text-center\">".$dado->taxa_de_intermediacao."".$infor->tip_de_valor."</td>
					<td class=\"text-center\">".$dado->tipo_para."</td>
					<td class=\"text-center\">".$dado->tempo_de_termino."dias</td>
					<td class=\"text-center\">".$dado->data_de_inicio."</td>
					<td class=\"text-center\">
					<button
					type='button' 
					id=\"validate_ajec$dado->id\"
					class='btn btn-primary my-1'
					onclick='aceitar(\"$dado->id\")'
					title='Vizualise o conversor de saldo.'>
							Aceitar
					</button>

					<button
					type='button' 
					id=\"validate_ajec_rejeitar$dado->id\"
					class='btn btn-primary my-1'
					onclick='Rejeitar(\"$dado->id\")'
					title='Vizualise o conversor de saldo.'>
							Rejeitar
					</button>
					</td>";
				}
				echo '</table>';
				
			?>
			
		</div>

		<div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'ajec_indermediacao_cpt_settings' );
					do_settings_sections( 'ajec_cpt' );
					submit_button();
				?>
			</form>
		</div>

	</div>
</div>