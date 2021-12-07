<?php 
/**
 * @package  ajec-intermediacao
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminCpt()
	{
		$thoken_nego_sms= $_SESSION['ajec_pay_token_conta']??'';

    $url="http://api.negoof.ao/api/listas_de_compras_recebidados?token=$thoken_nego_sms";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   // curl_setopt($ch, CURLOPT_POST, true);
   	//curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturajson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    // Resposta da Api a ser requisitada
    $response = curl_exec($ch);
    curl_close($ch);// fechando
    $infor = json_decode($response);
	
	echo"<script>
	
	function aceitar(id){
		const dados={
			token:'$thoken_nego_sms',
			id:id
		}
		document.getElementById(\"validate_ajec\"+id).innerHTML='<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"visually-hidden\">aceitando...</span></div>';
		$.post('//api.negoof.ao/api/ngactajecmk21hg', dados , (retorna)=>{
			console.log(retorna)
			if(!retorna.erro){
			document.getElementById(\"validate_ajec\"+id).innerHTML='<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"visually-hidden\">aceitado</span></div>';
			return;
			}
			document.getElementById(\"validate_ajec\"+id).innerHTML='<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"visually-hidden\">Não aceitado</span></div>';
		})
	}
	
	function Rejeitar(id){
		const dados={
			token:'$thoken_nego_sms',
			id:id
		}
		document.getElementById(\"validate_ajec_rejeitar\"+id).innerHTML='<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"visually-hidden\">aceitando...</span></div>';
		$.post('//api.negoof.ao/api/ngactajecmk21hg', dados , (retorna)=>{
			console.log(retorna)
			if(!retorna.erro){
			document.getElementById(\"validate_ajec_rejeitar\"+id).innerHTML='<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"visually-hidden\">aceitado</span></div>';
			return;
			}
			document.getElementById(\"validate_ajec_rejeitar\"+id).innerHTML='<div class=\"spinner-grow spinner-grow-sm\" role=\"status\"><span class=\"visually-hidden\">Não aceitado</span></div>';
		})
	}
	</script>";

		return require_once( "$this->plugin_path/templates/cpt.php" );
	}


	public function adminTaxonomy()
	{
		$thoken_nego_sms= $_SESSION['ajec_pay_token_conta']??'';

    $url="http://api.negoof.ao/api/dados_da_carteira?token=$thoken_nego_sms";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   // curl_setopt($ch, CURLOPT_POST, true);
   	//curl_setopt($ch, CURLOPT_POSTFIELDS, $estruturajson);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    // Resposta da Api a ser requisitada
    $response = curl_exec($ch);
    curl_close($ch);// fechando
    $infor = json_decode($response);

		return require_once( "$this->plugin_path/templates/taxonomy.php" );
	}







	public function adminWidget()
	{
		return require_once( "$this->plugin_path/templates/widget.php" );
	}



	public function adminGallery()
	{
		echo "<h1>Gallery Manager</h1>";
	}

	public function adminTestimonial()
	{
		echo "<h1>Testimonial Manager</h1>";
	}

	public function adminTemplates()
	{
		echo "<h1>Templates Manager</h1>";
	}

	public function adminAuth()
	{
		echo "<h1>Templates Manager</h1>";
	}

	public function adminMembership()
	{
		echo "<h1>Membership Manager</h1>";
	}

	public function adminChat()
	{
		echo "<h1>Chat Manager</h1>";
	}
	
}