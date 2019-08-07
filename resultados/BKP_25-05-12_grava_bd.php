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
			$imprimeCSV .= "<p><u> ".$num." campos nessa linha </u></p><br />";
		} else{
			$imprimeCSV .= '<hr> <h3><u>Linha: '.$row.'</u></h3>';
		}	
		
		for ($c=0; $c < $num; $c++) {
			// Caso seja 1ª linha (cabecalho) - Manda os titulos das colunas pra a Array $camposCSV[].
			if ($row == 1){
				array_push($camposCSV, $data[$c]);
			} else{
				$imprimeCSV .= '<i>'.$c.'.) </i><b>'.$camposCSV[$c].':</b> '.$data[$c]. '<br />';
				$CSV_Array[$row][$c] = $data[$c]; // Manda os valores para um nova array multidimensional.
			}
		}		

	} // FIM - while (($data = fgetcsv($abraArq, 1000, ";"))

	$imprimeCSV .= '<hr />';
		
	include("validaCSV_BD.php");
	$CSV_compativel = validaCSV_BD($camposCSV);
	
		// Ai no caso do id se você criou como auto incremento use uma função do mySQL para isso que é inserir em outra tabela os últimos id inseridos. O que não entraria em ambigüidade.
		$sql_comando_salva = "INSERT INTO dados_sessao
			(
			ID,
			Data,
			Participante,
			VI,
			NumTentativas,
			CliquesOP1,
			CliquesOP2,
			ReforcosOP1,
			ReforcosOP2,
			VIsOP1,
			VIsOP2,
			CliquesReforcos_OP1,
			CliquesReforcos_OP2,
			momentoReforcosOP1,
			momentoReforcosOP2,
			TempoTotal,
			NomeOp1,
			NomeOp2,
			OperandoEscolhido,
			NomeArqCSV
			)
		
		VALUES ('',
			'".$CSV_Array[2][0]."',
			'".$CSV_Array[2][1]."',
			'".$CSV_Array[2][2]."',
			'".$CSV_Array[2][3]."',
			'".$CSV_Array[2][4]."',
			'".$CSV_Array[2][5]."',
			'".$CSV_Array[2][6]."',
			'".$CSV_Array[2][7]."',
			'".$CSV_Array[2][8]."',
			'".$CSV_Array[2][9]."',
			'".$CSV_Array[2][10]."',
			'".$CSV_Array[2][11]."',
			'".$CSV_Array[2][12]."',
			'".$CSV_Array[2][13]."',
			'".$CSV_Array[2][14]."',
			'".$CSV_Array[2][15]."',
			'".$CSV_Array[2][16]."',
			'".$CSV_Array[2][17]."',
			'".$CSV_Array[2][18]."')";
	
	// CONECTA COM O MySQL E SELECIONA O BD
	$BD_conecta = mysql_connect("localhost", "pesquisa_psi", "hVnUl3mx");
		if (!$BD_conecta) { die('Could not connect: ' . mysql_error()); }
	
	// SELECIONA O Banco de Dados
	mysql_select_db("pesquisa_escolha");
		if(!mysql_select_db("pesquisa_escolha")){ echo '<H4 style="color:red;">ERRO: Banco de Dados MySQL NÃO selecionado!</H4>'; }
	
	// Consulta o BD se ja consta essa sessao em CSV ja salva
	$sql_consulta_existente = "SELECT * FROM dados_sessao WHERE NomeArqCSV='".$CSV_Array[2][18]."'"; // Passa como parametro o nome do arquivo CSV (participante_data)
	$sessao_nova = mysql_query($sql_consulta_existente, $BD_conecta);
	$num_registros = mysql_num_rows($sessao_nova);
	
			if(!$sessao_nova){
				echo '<H2 style="color:red;">ERRO AO CONSULTAR O BD - Impossivel verificar a sessao CSV.</H2>';			
				die('Error: ' . mysql_error());
			}
	
	if ($num_registros >= 1){
		echo '<br /><h4>Sessão já encontra-se cadastrada no BD.</h4><h4 style="color:blue;">Sessão Duplicada no BD?</h4><h3 style="color:green;">NUNCA SERÁ!</h3>';
	} elseif ($CSV_compativel == FALSE) {
		echo '<br /><h3 style="color:red;">CSV incompativel com o BD (provavelmente versao gerada antes de 2012.1)</h3>';
	} else{
		// SALVA OS DADOS NO BD
		$sql_salva_bd = mysql_query($sql_comando_salva, $BD_conecta);
		
			if($sql_salva_bd){
				echo '<H3>Gravado com SUCESSO!</H3>';
			} else {
				echo '<H2 style="color:red;">ERRO AO SALVAR NO BD!</H2>';			
				die('Error: ' . mysql_error());
			}
	}
	
	// Exibe na tela tudo que foi gerado nos loops que abriram o arquivo CSV
	echo $imprimeCSV;
	
// Só fechar agora o arquivo
fclose($abraArq);
}
