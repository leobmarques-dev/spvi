<?php
include ("funcoes_resultados.php");
?>
<html>
<head>
	<title>Sistema para apresentação de 2 condições de escolha - Léo Marques (V 2)</title>
	<link rel='stylesheet' href='../estilo_resultados.css' type='text/css'/>
</head>
<body>


<?php

// VARIAVEIS GLOBAIS
	// Devolve a pasta atual do script.
	$pastaAtual = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
	 // Variavel que recebera todos os dados dos CSVs da pasta de um participante
	$dadosParticipante = "";

	

	// Avalia se o nome de algum participante foi passado como parametro - GERA CAMINHO
		// UM participante foi passado via GET - Listando CSVs do mesmo
		if (isset($_GET["participante"])){
			$participante = $_GET["participante"];
			$pasta = $pastaAtual.$participante;
			$pastaBase = 0;
		}
		// Nenhum nome de participante passado via GET - diretorio base
		else{
			$pasta = $pastaAtual; 
			$pastaBase = 1;
		}
	
	//Lista os arquivos de resultado, em CSV
		// UM participante foi passado via GET - Listando CSVs do mesmo
		if (isset($_GET["participante"])){
			echo "<b>Resultados:</b><p><i>Participante:</i> ".$_GET["participante"]." <br /><p> <strong>&#8592;</strong> <a href='./'>Voltar para lista de participantes</a></p>";
		}
		// Nenhum nome de participante passado via GET - diretorio base
		else {
			echo "Escolha o participante (acesso arquivos CSV) [<a href='../'>voltar</a>]<br /><br />";
		}

	// Chama funcao ListaResult() que lista os arquivos CVS ou as pastas dos participantes
	ListaResult($pasta, $pastaBase);

	// Caso um participante tenha sido passado como parametro: exibe link "voltar" para pasta base
	if (isset($_GET["participante"])){
		echo "<p> <strong>&#8592;</strong> <a href='./'>Voltar para lista de participantes</a></p>";
		echo "<h3>[<a href='grava_bd.php?arquivoCSV=".$_GET["participante"]."_TUDO.csv_&TodosCSVs=true'>Grava dados no BD</a>]</h3>";
	}
?>

</body>