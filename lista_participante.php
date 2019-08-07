<?php
// pega o endereço do diretório
chdir('escolha/resultados');
$diretorio = getcwd(); 
// abre o diretório
$ponteiro  = opendir($diretorio);
// monta os vetores com os itens encontrados na pasta
while ($nome_itens = readdir($ponteiro)) {
    $itens[] = $nome_itens;
}

// ordena o vetor de itens
sort($itens);
// percorre o vetor para fazer a separacao entre arquivos e pastas 
foreach ($itens as $listar) {
// retira "./" e "../" para que retorne apenas pastas e arquivos
   if ($listar!="." && $listar!=".."){ 

// checa se o tipo de arquivo encontrado é uma pasta
   		if (is_dir($listar)) { 
// caso VERDADEIRO adiciona o item à variável de pastas
			$pastas[]=$listar; 
		} else{ 
// caso FALSO adiciona o item à variável de arquivos
			$arquivos[]=$listar;
		}
   }
}
?>
<img src='img/folder_icon.jpg' border='0' style="width: 20px;height: 20px;position: relative;top: 5px;">
<select name="participante" id="participante">
	<?php
	// lista as pastas se houverem
	if ($pastas != "" ) {
	$contador = 0; 
		foreach($pastas as $listar){
			print "<option value=".$listar.">".$listar."</option>";
			$contador++;
			//if($contador == 15){ echo "<br />"; }
	   }
	}
	?>
</select>