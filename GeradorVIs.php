<?php
// FUncoes que recebem os valores da VI e interacoes e gera os componentes da VI

if (ISSET($_GET["VI_sessao"], $_GET["n_sessao"])){
	$VI_sessao = $_GET["VI_sessao"];
	$n_sessao = $_GET["n_sessao"];
} else{
	$VI_sessao = 7;
	$n_sessao = 5;
}

// Gera os "n" componentes da VI indicada
	geraVIs($VI_sessao, $n_sessao);

function geraVIs($VI, $n){
$VIs = array(); // Array que receberá as VIs
$VIsMin = array(); // Array que receberá as VIs ABAIXO do valor da VI
$VIsMax = array(); // Array que receberá as VIs ACIMA do valor da VI
$VIatual = $VI; //Variavel usada no loop para receber os valores da VI e sal$no Array "VIs".
$PosVIs = array(); //Variavel que recebe as fracoes da VI e que serao posterimente somadas a VI para criar componentes simetricos da VI;
$CorteVIs; // Variavel que define o numero de loops para criar as VIs
$PosVIsAtual = $VI; // Define a posicao atual como o proprio VI
$nVI = 1; // indice da Array VIs (COMECA DO ZERO, 0)
$nPosVI = 1; // indice da Array VIs (COMECA DO ZERO, 0) e controle do loop que gera os pontos de corte das VIs
$ControleLoop = 1; // Controle de execussoes do loop + valor da divisao do VI

$PosVIsInt;
$PosVIsFloat;

$msg = "";
$TipoN; // Recebe o Tipo do "n", se PAR ou IMPAR
$totalVIs = 0; //Calcula a soma dos componentes da VI para posteriormente ser dividido pelo "n" e calcular a media (VI)
$MediaVIs = 0; //Calcula a media dos componentes da VI para conferir se bate com o valor passado em "VI".

	// Limpa o campo de "dadosSessao" do formulario (para receber novos VIs)

		//Avalia se o nº de tentativas eh IMPAR OU PAR (CORRIGE FALHA AO DIVIDIR O n AO MEIO) - OK
		// Gera o nº de vezes que o loop ira rodar para gerar os componetes da VI
 		if ($n % 2 == 0){ //Caso o "n" seja PAR
			$CorteVIs = round($n/2);
		}
		//Caso o "n" seja IMPAR
		else { 
			 // Garante que os loops criarao n-1 intervalos para a VI
			 // Outra condicional ao fim acrescenta a propria VI como ultimo intervalo
			$CorteVIs = (round($n/2)) - 1;
		}

		
	// Cria os "n" pontos de corte no intervalo da VI que serão somados e subtraidos a VI
    while ($nPosVI <= $CorteVIs) {

        // Garante que o valor "0" e VI * 2 sejam usados como componentes da VI
        if ($ControleLoop == 1){ // Se primeira execussao do loop o proprio valor da VI sera usado
           $PosVIsAtual = $VI;
		} else{
           $PosVIsAtual = $PosVIsAtual / $ControleLoop;
        }


        $PosVIsFloat = $PosVIsAtual % 1; // Separa apenas o valor decimal de "PosVIsAtual".
		if($PosVIsFloat == 0 || $PosVIsFloat == 0.5){
			$PosVIs[$nPosVI] = $PosVIsAtual;
		} else{
			$PosVIsInt = intval($PosVIsAtual);			
			
				// SUBSTITUI O "PosVIsFloat" pela versao arredondada com decimal 0 ou 5.
				if ($PosVIsFloat > 0.5){
					$PosVIsFloat = 1;
				} else {
					$PosVIsFloat = 0.5;
				}
			
			// GERA NOVO "PosVIsAtual", COM VALOR DECIMAL ARREDONDADO PARA "0" OU "5".
			$PosVIsAtual = $PosVIsInt + $PosVIsFloat;
            $PosVIs[$nPosVI] = $PosVIsAtual;
		}
		
		$nPosVI++;
		$ControleLoop++;
	}
	
	//Cria o valor da VI abaixo
	while ($nVI <= $CorteVIs) {
		$VIatual = $PosVIs[$nVI];
		$VIs[$nVI] = intval($VI) - floatval($VIatual);
		
		// Condicional que avalia se o valor da VI gerado eh zero
		if ($VIs[$nVI] == 0){
			$totalVIs += 1; // Caso o valor da VI seja zero eh substituido por 1 (um)
		} else{
			$totalVIs += $VIs[$nVI]; //Envia cada VI para a $totalVIs
		}
		
		$nVI++;// Altera o indice do array para receber o proximo valor
	}
	
	// ZERA o indice da Array VIs 
	$nPosVI = 1;
	
	//Cria o valor da VI acima (simetrico ao abaixo criado anterioremente)
	while ($nPosVI <= $CorteVIs) {
		$VIatual = intval($VI) + floatval($PosVIs[$nPosVI]); // Compensa o incremento enterior e cria um equivalente acima da VI
		$VIs[$nVI] = $VIatual;
		// Condicional que avalia se o valor da VI gerado eh zero
		if ($VIs[$nVI] == 0){
			$totalVIs += 1; // Caso o valor da VI seja zero eh substituido por hum (1)
		} else {
			$totalVIs += $VIs[$nVI]; //Envia cada VI para a $totalVIs
		}
		$nPosVI++;// Altera o indice do array para receber o proximo valor
		$nVI++;
	}

	/* _______________________ATENCAO_________________________
		CRIA UM CONDICIONAL (SE PAR OU IMPAR) PARA
		ACRESCENTAR A VI COMO COMPONENTE DA ARRAY NO CASO DE 
		VALORES DE "n" IMPARES. */
		 if ($n % 2 != 0){ //Caso o "n" seja IMPAR
			$VIs[$nVI] = intval($VI);
			$totalVIs += intval($VI); //o parseInt() garante que o valor de VI seja reconhecido como numero (corrige erro da media)
		}
/*		_______________________________________________________ */
	

				
		// Calcula a media dos VIs (conferir se e igual ao VI definido)
		$mediaVIs = round(intval($totalVIs)/$n);
	
	return shuffle($VIs);
}

// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	


?>