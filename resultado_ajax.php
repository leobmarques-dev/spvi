<?php
echo "<H3>RESULTADO: Sistema de Escolha por Intervalo Variável</H3>";
echo "<br /><a href='index.php'>[Inicio]</a> | <a href='resultados/index.php'>[Resultados]</a><br />";

// Abre ou cria o arquivo bloco1.txt
// "a" representa que o arquivo é aberto para ser escrito

if (ISSET($_POST["AJAXclqOP1"]) || ISSET($_POST["AJAXclqOP2"])){
	$data = $_POST["AJAXdataHora"];
	// $data .= "-H";
	// $data .= date("H");
	// $data .= "m";
	// $data .= date("i");
	$arquivo = "resultados/".$_POST["AJAXPartc"]."/".$_POST["AJAXPartc"]."_".$data.".csv";

	$conteudo = "Data;Participante;VI;NumTentativas;CliquesOP1;CliquesOP2;S+OP1;S+OP2;VIsOP1;VIsOP2;CliquesRef_OP1;CliquesRef_OP2;momentoS+OP1;momentoS+OP2;TempoTotal;NomeOp1;NomeOp2;OperandoEscolhido;ContagemReforco;OPTravado;NomeArqCSV"."\n";
	$conteudo .= $data.";";
	$conteudo .= $_POST["AJAXPartc"].";";
	$conteudo .= $_POST["AJAXVI"].";";
	$conteudo .= $_POST["AJAXnInteracoes"].";";
	
	$conteudo .= $_POST["AJAXclqOP1"].";";
	$conteudo .= $_POST["AJAXclqOP2"].";";
	$conteudo .= $_POST["AJAXpontosOP1"].";";
	$conteudo .= $_POST["AJAXpontosOP2"].";";
	$conteudo .= $_POST["AJAXVIs_P1"].";";
	$conteudo .= $_POST["AJAXVIs_P2"].";";	
	$conteudo .= $_POST["AJAXCliquesRef_OP1"].";";
	$conteudo .= $_POST["AJAXCliquesRef_OP2"].";";
	$conteudo .= $_POST["AJAXOP1momentoS"].";";
	$conteudo .= $_POST["AJAXOP2momentoS"].";";
	
	$conteudo .= $_POST["AJAXtotalSessao"].";";
	$conteudo .= $_POST["AJAXNomeOp1"].";";
	$conteudo .= $_POST["AJAXNomeOp2"].";";
	$conteudo .= $_POST["AJAXOperandoEscolhido"].";";
	$conteudo .= $_POST["AJAXContagemReforco"].";";
	$conteudo .= $_POST["AJAXOPTravado"].";";
	$conteudo .= $_POST["AJAXPartc"]."_".$data.".csv"."\n";

echo "<table width='100%'><tr><td>";
	
	echo "<br /><br /><div id='resultado'><b><u>RESULTADO</u></b> - Data: ".$data."<br />";	
	echo "<br /><b>Participante:</b><i>".$_POST["AJAXPartc"]."</i> | <a href='resultados/index.php?participante=".$_POST["AJAXPartc"]."'>[RESULTADOS]</a>";
	echo "<br /><br />VI da sesão: <i>".$_POST["AJAXVI"];	
	echo "</i><br />Nº de VIs (componentes): <i>".$_POST["AJAXnInteracoes"];
	echo "</i><br />Criterio encerramento (S+): <i>".$_POST["AJAXContagemReforco"];
	echo "</i><br />Nome do Operando 1: <i>".$_POST["AJAXNomeOp1"];
	echo "</i><br />Nome do Operando 2: <i>".$_POST["AJAXNomeOp2"];
	echo "</i><br />Operando Travado (se houver): <i>".$_POST["AJAXOPTravado"];
	echo "</i><br />Dados salvos no arquivo: <i><a href='".$arquivo."' target='_blank'><br />".$arquivo."</a></i>";
	echo " | <a href='resultados/grava_bd.php?arquivoCSV=".$arquivo."'>[Salvar no BD]</a>";
	
	echo "<br /><br />Operando Escolhido: <i>".$_POST["AJAXOperandoEscolhido"];
	echo "</i><br />Cliques no operando 1: <i>".$_POST["AJAXclqOP1"];
	echo "</i><br />Cliques no operando 2: <i>".$_POST["AJAXclqOP2"];
	echo "</i><br />S+ OP 1: <i>".$_POST["AJAXpontosOP1"];
	echo "</i><br />S+ OP 2: <i>".$_POST["AJAXpontosOP2"];

	echo "</i><br />VIs em vigor no S+ do P1: <i>".$_POST["AJAXVIs_P1"];
	echo "</i><br />VIs em vigor no S+ do P2: <i>".$_POST["AJAXVIs_P2"];
	echo "</i><br />Cliques durante o S+ do P1: <i>".$_POST["AJAXCliquesRef_OP1"];
	echo "</i><br />Cliques durante o S+ do P2: <i>".$_POST["AJAXCliquesRef_OP2"];
	
	echo "</i><br />Momentos de S+ no P1: <i>".$_POST["AJAXOP1momentoS"];
	echo "</i><br />Momentos de S+ no P2: <i>".$_POST["AJAXOP2momentoS"];
	
	echo "</i><br />Tempo total da sessão: <i>".$_POST["AJAXtotalSessao"]." s";
	echo "</i></div>";

echo "</td><td>";	
	
	if ($_POST["AJAXpontosOP1"] > $_POST["AJAXpontosOP2"]){
		echo "<div class='ImgEscolha'><img src='img/".$_POST["AJAXNomeOp1"].".png'></div>";
	} else {
		echo "<div class='ImgEscolha'><img src='img/".$_POST["AJAXNomeOp2"].".png'></div>";	
	}

echo "</td><tr></table>";
	
	$fp = fopen($arquivo, "a");

	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp, $conteudo);

	// Fecha o arquivo
	fclose($fp);
	
}
?>