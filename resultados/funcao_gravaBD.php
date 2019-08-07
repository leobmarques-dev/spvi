<?php

function gravaCSVnoBD ($CSV_Array, $imprimeCSV, $CSV_compativel){
	
	echo "<p><strong>Linhas de dados no CSV: </strong>".count($CSV_Array)."</p>";
	
	// LOOP QUE VERIFICA QUAIS SESSOES JA ESTAO SALVAS NO BD
	$linhaCSV = 0;
	foreach($CSV_Array as $chave => $sessao_do_CSV){
		
		// Limita a analise as sessoes compativeis (versao com nome do arquivo registrada no CSV)
		if (isset($sessao_do_CSV["NomeArqCSV"])){
			echo ($linhaCSV+1).") ".$sessao_do_CSV["NomeArqCSV"]." | ";
			$linhaCSV++;
			

		
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
				'".$CSV_Array[0]."',
				'".$CSV_Array[1]."',
				'".$CSV_Array[2]."',
				'".$CSV_Array[3]."',
				'".$CSV_Array[4]."',
				'".$CSV_Array[5]."',
				'".$CSV_Array[6]."',
				'".$CSV_Array[7]."',
				'".$CSV_Array[8]."',
				'".$CSV_Array[9]."',
				'".$CSV_Array[10]."',
				'".$CSV_Array[11]."',
				'".$CSV_Array[12]."',
				'".$CSV_Array[13]."',
				'".$CSV_Array[14]."',
				'".$CSV_Array[15]."',
				'".$CSV_Array[16]."',
				'".$CSV_Array[17]."',
				'".$CSV_Array[18]."')";
		
		// CONECTA COM O MySQL E SELECIONA O BD
		$BD_conecta = mysql_connect("localhost", "pesquisa_psi", "hVnUl3mx");
			if (!$BD_conecta) { die('Could not connect: ' . mysql_error()); }
		
		// SELECIONA O Banco de Dados
		mysql_select_db("pesquisa_escolha");
			if(!mysql_select_db("pesquisa_escolha")){ echo '<H4 style="color:red;">ERRO: Banco de Dados MySQL NÃO selecionado!</H4>'; }
		
		// Consulta o BD se ja consta essa sessao em CSV ja salva
		$sql_consulta_existente = "SELECT * FROM dados_sessao WHERE NomeArqCSV='".$CSV_Array["NomeArqCSV"]."'"; // Passa como parametro o nome do arquivo CSV (participante_data)
		$sessao_nova = mysql_query($sql_consulta_existente, $BD_conecta);
		$num_registros = mysql_num_rows($sessao_nova);			
		
			if(!$sessao_nova){
				echo '<H2 style="color:red;">ERRO AO CONSULTAR O BD - Impossivel verificar a sessao CSV.</H2>';			
				die('Error: ' . mysql_error());
			}

			
		// Se a sessao JA EXISTE NO BD: exibe mensagem de erro
		if ($num_registros >= 1){
			echo '<span style="font-family:verdana;color:red;font-size:10px;">
							Sessão já encontra-se cadastrada no BD.
					</span><br />';
		} 
		
		// Se a sessao ainda nao foi cadastrada: salva os dados no BD
		else{
			// SALVA OS DADOS NO BD
			$sql_salva_bd = mysql_query($sql_comando_salva, $BD_conecta);
			
				if($sql_salva_bd){
					echo '<span style="font-family:verdana;color:green;font-size:12px;">
							Gravado com SUCESSO!
						  </span><br />';
				} else {
					echo '<H2 style="color:red;">ERRO AO SALVAR NO BD!</H2>';			
					die('Error: ' . mysql_error());
				}
					
					if (count($CSV_Array) == 1){
						// Exibe na tela tudo que foi gerado nos loops que abriram o arquivo CSV	
						echo $imprimeCSV;
					}
			} // FIM else
	
		} // FIM - if (isset($sessao_do_CSV[18])

	} // FIM - foreach($CSV_Array as $chave => $sessao_do_CSV)
}
?>