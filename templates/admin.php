<div class="wrap">
	<h1> Ajec Indermediação</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Gerenciar configurações</a></li>
		<li><a href="#tab-2">Dados Da Conta</a></li>
		<li><a href="#tab-3">Suporte</a></li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">

			<form method="post" action="options.php">
				<?php 
					settings_fields( 'ajec_indermediacao_settings' );
					do_settings_sections( 'ajec_indermediacao' );
					submit_button();
				?>
			</form>
		</div>

		<div id="tab-2" class="tab-pane">
		<h3>Dados da contas</h3>
		</div>
		
		<div id="tab-3" class="tab-pane">
			<h3>Suporte</h3>
		</div>
	
	
</div>