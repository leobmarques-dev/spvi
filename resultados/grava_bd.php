<h4><a href="http://escolha.pesquisaspsi.com.br/resultados/">RESULTADOS</a></h4>

<?php

//Usando $abraArq para abrir arquivos com r você apenas vai lê-lo com w ou w+ você pode alterar e caso queira ler e depois alterar só usar as duas rw ou rw+.
	if (isset($_GET["arquivoCSV"]) AND !isset($_GET["TodosCSVs"])){
		$arquivoCSV = $_GET["arquivoCSV"];
		$abraArq = fopen($arquivoCSV, "r");
	}else{	
		$abraArq = fopen("teste.csv", "r");
		echo '<H2>EXIBINDO DADOS DE UM ARQUIVO CSV DE TESTE</H2>';
	}

//Apenas para ficar com mais controle melhor colocar um tratamento de erros
if (!$abraArq){
	// Caso o arquivo são seja aberto: imprima na tela um aviso de erro
	echo ('<h3 style="color:red;">Arquivo não encontrado</h3>');
} else {
	
	//Cria a array que recebera os nomes dos campos
	$camposCSV = array();	

	while (($data = fgetcsv($abraArq, 1000, ";")) !== FALSE) {
    $num = count ($data);    
	$row++; //Deve ser incrementado antes da liha abaixo para 1 = 1ª linha de dados
		if ($row != 1){
			$imprimeCSV .= "<p>".($row-1).") <u> ".$num." campos nessa linha </u></p><br />";
		} 
		/**
		else{
			$imprimeCSV .= '<hr> <h3><u>Linha: '.$row.'</u></h3>';
		}	**/
		
		for ($c=0; $c < $num; $c++) {
			// Caso seja 1ª linha (cabecalho) - Manda os titulos das colunas pra a Array $camposCSV[].
			if ($row == 1){
				array_push($camposCSV, $data[$c]);
			} else{
				$imprimeCSV .= '<i>'.($c+1).'.) </i><b>'.$camposCSV[$c].':</b> '.$data[$c]. '<br />';
				$CSV_Array[$row][$camposCSV[$c]] = $data[$c]; // Manda os valores para um nova array multidimensional.
			}
		}		

	} // FIM - while (($data = fgetcsv($abraArq, 1000, ";"))

	//$imprimeCSV .= '<hr />';
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
	// Avalia se o CSV tem os mesmo campos do Banco de Dados
	include("validaCSV_BD.php");
	$CSV_compativel = validaCSV_BD($camposCSV);
	//Caso o CSV seja compativel com o BD, grava os dados no mesmo
		if ($CSV_compativel == true){
			include("funcao_gravaBD.php");
			gravaCSVnoBD ($CSV_Array, $imprimeCSV, $CSV_compativel);
		} else { echo '<br /><h3 style="color:red;">CSV incompativel com o BD (provavelmente versao gerada antes de 2012.1)</h3>'; }
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 	

	
// Só fechar agora o arquivo
fclose($abraArq);
}
