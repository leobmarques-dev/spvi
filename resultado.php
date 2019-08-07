<?php
echo "<H3>Sistema de Escolha por Intervalo Variável</H3>";
echo "<br /><a href='index.php'>[Inicio]</a> | <a href='resultados/index.php'>[Resultados]</a><br />";

// Abre ou cria o arquivo bloco1.txt
// "a" representa que o arquivo é aberto para ser escrito

if (ISSET($_GET["clqOP1"]) || ISSET($_GET["clqOP2"])){
	$data = $_GET["dataHora"];
	// $data .= "-H";
	// $data .= date("H");
	// $data .= "m";
	// $data .= date("i");
	$arquivo = "resultados/".$_GET["Partc"]."/".$_GET["Partc"]."_".$data.".csv";

	$conteudo = "Data;Participante;VI;NumTentativas;CliquesOP1;CliquesOP2;S+OP1;S+OP2;VIsOP1;VIsOP2;CliquesRef_OP1;CliquesRef_OP2;momentoS+OP1;momentoS+OP2;COD_Sessao;COD_OP1;COD_OP2;TempoTotal;NomeOp1;NomeOp2;OperandoEscolhido;ContagemReforco;OPTravado;NomeArqCSV"."\n";
	$conteudo .= $data.";";
	$conteudo .= $_GET["Partc"].";";
	$conteudo .= $_GET["VI"].";";
	$conteudo .= $_GET["nInteracoes"].";";
	
	$conteudo .= $_GET["clqOP1"].";";
	$conteudo .= $_GET["clqOP2"].";";
	$conteudo .= $_GET["pontosOP1"].";";
	$conteudo .= $_GET["pontosOP2"].";";
	$conteudo .= $_GET["VIs_P1"].";";
	$conteudo .= $_GET["VIs_P2"].";";	
	$conteudo .= $_GET["CliquesRef_OP1"].";";
	$conteudo .= $_GET["CliquesRef_OP2"].";";
	$conteudo .= $_GET["OP1momentoS"].";";
	$conteudo .= $_GET["OP2momentoS"].";";
	
	$conteudo .= $_GET["COD_Sessao"].";";
	$conteudo .= $_GET["COD_OP1"].";";
	$conteudo .= $_GET["COD_OP2"].";";
	$conteudo .= $_GET["totalSessao"].";";
	$conteudo .= $_GET["NomeOp1"].";";
	$conteudo .= $_GET["NomeOp2"].";";
	$conteudo .= $_GET["OperandoEscolhido"].";";
	$conteudo .= $_GET["ContagemReforco"].";";
	$conteudo .= $_GET["OPTravado"].";";
	$conteudo .= $_GET["Partc"]."_".$data.".csv"."\n";

echo "<table width='100%'><tr><td>";
	
	echo "<br /><br /><div id='resultado'><b><u>RESULTADO</u></b> - Data: ".$data."<br />";	
	echo "<br /><b>Participante:</b><i>".$_GET["Partc"]."</i> | <a href='resultados/index.php?participante=".$_GET["Partc"]."'>[RESULTADOS]</a>";
	echo "<br /><br />VI da sesão: <i>".$_GET["VI"];	
	echo "</i><br />Nº de VIs (componentes): <i>".$_GET["nInteracoes"];
	echo "</i><br />Criterio encerramento (S+): <i>".$_GET["ContagemReforco"];
	echo "</i><br />Nome do Operando 1: <i>".$_GET["NomeOp1"];
	echo "</i><br />Nome do Operando 2: <i>".$_GET["NomeOp2"];
	echo "</i><br />Operando Travado (se houver): <i>".$_GET["OPTravado"];
	echo "</i><br />Dados salvos no arquivo: <i><a href='".$arquivo."' target='_blank'><br />".$arquivo."</a></i>";
	echo " | <a href='resultados/grava_bd.php?arquivoCSV=".$arquivo."'>[Salvar no BD]</a>";
	
	echo "<br /><br />Operando Escolhido: <i>".$_GET["OperandoEscolhido"];
	echo "</i><br />Cliques no operando 1: <i>".$_GET["clqOP1"];
	echo "</i><br />Cliques no operando 2: <i>".$_GET["clqOP2"];
	echo "</i><br />S+ OP 1: <i>".$_GET["pontosOP1"];
	echo "</i><br />S+ OP 2: <i>".$_GET["pontosOP2"];

	echo "</i><br />VIs em vigor no S+ do P1: <i>".$_GET["VIs_P1"];
	echo "</i><br />VIs em vigor no S+ do P2: <i>".$_GET["VIs_P2"];
	echo "</i><br />Cliques durante o S+ do P1: <i>".$_GET["CliquesRef_OP1"];
	echo "</i><br />Cliques durante o S+ do P2: <i>".$_GET["CliquesRef_OP2"];
	
	echo "</i><br />Momentos de S+ no P1: <i>".$_GET["OP1momentoS"];
	echo "</i><br />Momentos de S+ no P2: <i>".$_GET["OP2momentoS"];
	
	echo "</i><br />Total de CODs: <i>".$_GET["CODs"];
	echo "</i><br />Tempo total da sessão: <i>".$_GET["totalSessao"]." s";
	echo "</i></div>";

echo "</td><td>";	
	
	if ($_GET["OperandoEscolhido"] == $_GET["NomeOp1"]){
		echo "<div class='ImgEscolha'><img src='img/".$_GET["NomeOp1"].".png'></div>";
	} else {
		echo "<div class='ImgEscolha'><img src='img/".$_GET["NomeOp2"].".png'></div>";	
	}

echo "</td><tr></table>";
	
	$fp = fopen($arquivo, "a");

	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp, $conteudo);

	// Fecha o arquivo
	fclose($fp);
	
}
?>