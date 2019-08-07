<?php
function ListaResult($dir,$base){
  $diretorio  = $dir;
  $dirhandle = opendir($diretorio);
  $pastas = "<img src='../img/folder_icon.jpg' border='0' style='width: 20px;height: 20px;position: relative;top: 5px;'>";
  
	while ($file = readdir($dirhandle)) {
		
		// Caso o parametro "$base" indique que eh o diretorio base - lista apenas pastas
		if($base == 1){
			if(is_dir($file) && $file != "." && $file != ".."){
				// Se houve alguma subpasta com mais participantes: lista separado
				if (stristr($file, "_BASE-") == true) {
				 $pastas .= "<a href='".$file."/'>".$file."</a><br />";
				} else {
					// Caso nao seja uma pasta base, inclui na lista de pasta de participantes
					$files[] = $file;
				}
				
			}
		
		// Caso o parametro "$base" indique que eh o diretorio de um participante especifico
		} if($base == 0 && $file != "." && $file != ".."){
			$files[] = $file;
		}
	}
 closedir($dirhandle);

 $i = 0; //Numera os valores da array $files
 $num = $i; // Numera as listagens (alunos ou resultados em CSV)
 
 echo $pastas; // Lista as subpastas encontradas (pastas que nao sao de participantes, pastas BASE)
 echo "<ol class='col3' style='list-style-type:decimal-leading-zero;'>";
	 sort($files, SORT_STRING); //Organiza os valores da array alfabeticamente
	 foreach ($files as $v) {
		if ($files[$i] == "index.php"){
			// Nao faz nada - Oculta a exibicao de index.php
		}else{
			
				//Caso ESTEJA DENTRO da pasta de um participante
				if ($i < 9){$num = "0".($i + 1);} else {$num = $i + 1;}
				
				// CASO TENHA SIDO SOLICITADO OS CSVs DE UM PARTICIPANTE
				if (isset($_GET["participante"]) && substr($files[$i], -3) == "csv"){
					echo '<li>'.$num.') <a href='.$_GET["participante"].'/'.$files[$i].'>'.$files[$i].'</a>
							<a href="grava_bd.php?arquivoCSV='.$_GET["participante"].'/'.$files[$i].'">
								<img src="../img/salvar_bd.png" border="0" height="18" width="18">
							</a>	
						  </li>';
					
					//___________________________________________________________
					//GERA CSV COM TODOS OS RESULTADOS DO ALUNO
						
						$CSVCaminho = $_GET["participante"].'/'.$files[$i];
						
						//Abre arquivo CSV
						$ponteiro = fopen ($CSVCaminho, "r");
						
						//Le arquivo ate chegar ao fim
						$ControleLinha = 0; //Controle para nao salvar no CSV a linha 1 (cabecalho)
						while (!feof ($ponteiro)) {
						  //Le uma linha do arquivo
						  $linha = fgets($ponteiro, 4096);
							
							//Caso nao seja a primeira linha (cabecalho)
							if ($ControleLinha > 0){
								//Salva linha na variavel
								$dadosParticipante .= $linha."\n";
							}
						  $ControleLinha++;
						}//Fecha o loop While

						//Fecha o ponteiro do arquivo
						fclose ($ponteiro);
					//___________________________________________________________					
					
					/**
					$CSVcomoVAR = fopen($files[$i], "a");
					$dadosParticipante .= fread($CSVcomoVAR, 10);
					fclose($CSVcomoVAR);
					**/
				} // FIM - CASO TENHA SIDO SOLICITADO OS CSVs DE UM PARTICIPANTE
				
				if (substr($files[$i], -3) == "csv" || substr($files[$i], -4) == "csv_"){
					// Oculta o arquivo CSV "participante_TUDO" da listagem de pastas
				} 
				
				// CASO ESTEJA NO DIRETORIO BASE
				else{
					
					// garante exibicao do 0 (zero) para numerais abaixo de 10
					if ($i < 9){$num = "0".($i + 1);} if ($i > 9) {$num = $i + 1;}
					
					// Lista as pastas dos participantes
					echo "<li>".$num.") <a href='index.php?participante=".$files[$i]."'>".$files[$i]."</a></li>";
				}
				
		}
		$i++;
		$num_lista++;
		$num_lista++;
	 }
echo "</ol>";
	
		//GERA CSV COM TODOS OS RESULTADOS DA PASTA DE UM PARTICIPANTE
		if (isset($_GET["participante"])){
			$CSVTodosDados = $_GET["participante"]."/".$_GET["participante"]."_TUDO.csv_";
			$fp = fopen($CSVTodosDados, "w");
			// Escreve no arquivo
			$CSVCabecalho = 	"Data;Participante;VI;NumTentativas;CliquesOP1;CliquesOP2;S+OP1;S+OP2;VIsOP1;VIsOP2;CliquesS+_OP1;CliquesS+_OP2;momentoS+OP1;momentoS+OP2;TempoTotal;NomeOp1;NomeOp2;OperandoEscolhido;NomeArqCSV\n";
			$escreve = fwrite($fp, $CSVCabecalho);
			$escreve = fwrite($fp, $dadosParticipante);
			// Fecha o arquivo
			fclose($fp);
			echo "<a href='".$_GET["participante"]."/".$_GET["participante"]."_TUDO.csv_"."'><strong>BAIXAR CSV COM TODOS RESULTADOS</strong></a>
			 <a href='grava_bd.php?arquivoCSV=".$_GET['participante']."/".$_GET['participante']."_TUDO.csv_'>
					<img src='../img/salvar_bd.png' border='0' height='18' width='18'>
				</a>
			<br />(Clique com o bot&atilde;o direito e use a fun&ccedil;$atilde;o 'Salvar Como' - renomeie o arquivo para a exten&ccedil;$atilde;o .csv)";
		}
}
?>