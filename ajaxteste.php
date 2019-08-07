<?php
echo "Dados para salvar no CSV:<br />";

if (ISSET($_POST["recebePartc"]) || ISSET($_POST["recebeVI"])){

	$conteudo = "Participante;VI;NumTentativas;"."\n";
	$conteudo .= $data.";";
	$conteudo .= $_POST["recebePartc"].";";
	$conteudo .= $_POST["recebeVI"].";";
	$conteudo .= $_POST["recebenInteracoes"].";";
	
	echo $conteudo;
}
	
?>