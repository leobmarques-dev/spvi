<?php

// VARIAVEIS GLOBAIS
	// Devolve a pasta atual do script.
	$pastaAtual = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

	
function ListaResult($dir,$base){
  $diretorio  = $dir;
  $dirhandle = opendir($diretorio);
	while ($file = readdir($dirhandle)) {
		
		// Caso o parametro "$base" indique que eh o diretorio base - lista apenas pastas
		if($base == 1){
			if(is_dir($file) && $file != "." && $file != ".."){
				$files[] = $file;
			}
		
		// Caso o parametro "$base" indique que eh o diretorio de um participante especifico
		} if($base == 0 && $file != "." && $file != ".."){
			$files[] = $file;
		}
	}
 closedir($dirhandle);

 $i = 0; //Numera os valores da array $files
 
 echo "<ol>";
	 sort($files, SORT_STRING); //Organiza os valores da array alfabeticamente
	 foreach ($files as $v) {
		if ($files[$i] == "index.php"){
			// Oculta a exibicao de index.php - Nao faz nada
		}else{
			
				//Caso ESTEJA DENTRO da pasta de um participante
				if (isset($_GET["participante"])){
					echo '<li><a href='.$_GET["participante"].'/'.$files[$i].'>'.$files[$i].'</a>
					[<a href="grava_bd.php?arquivoCSV='.$_GET["participante"].'/'.$files[$i].'">Grava no BD</a>]
					</li>';
				}
				
				else{
					echo "<li><a href='index.php?participante=".$files[$i]."'>".$files[$i]."</a></li>";
				}
				
		}
		$i++;
		$num_lista++;
	 }
echo "</ol>";
}

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
			echo "<b>Resultados:</b><p><i>Participante:</i> ".$_GET["participante"]." [<a href='./'>voltar</a>]";
		}
		// Nenhum nome de participante passado via GET - diretorio base
		else {
			echo "Escolha o participante (acesso arquivos CSV) [<a href='../'>voltar</a>]<br /><br />";
		}

	// Chama funcao ListaResult() que lista os arquivos CVS ou as pastas dos participantes
	ListaResult($pasta, $pastaBase);

	// Caso um participante tenha sido passado como parametro: exibe link "voltar" para pasta base
	if (isset($_GET["participante"])){
		echo "<p> [<a href='./'>voltar</a>]";
		echo "<h3>[<a href='grava_bd.php?arquivoCSV='>Grava dados no BD</a>]</h3>";
	}
?>