	
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  -

function iniciaTeste(){

	// Apaga as mensagens anteriores - Reinicia para nova sessao
	msg = ""; // padrao para exibir msgs  
 
	//Recupera os valores de "VI" e "n_sessao" para uso no javascript (passados para geraVIs(), etc...)
	mediaVI = document.getElementById("VISessao").value; // Média em segundos dos valores de todas as interações (VI)
	n_sessao = document.getElementById("TentativasSessao").value; //Total de interações por operando

	// Passa para a variavel o valor do criterio de tempo para encerra a sessao
	TempoFimSessao = $("input#TempoFimSessao").val();
	
	// Verifica se a contagem de reforcos sera acumulada ou independe para cada operando
	avaliaTipoSessao();

	
	//Variavel que inicia a sessao
	IniciaSessao = true;
	 // Salva o momento de inicio do teste
		var d = new Date();
		var mesCorrigido = d.getMonth()+1;
			//Corrige o valor do mes, acescenta um 0 (zero) nos de janeito ate setembro (1 a 9).
			if (mesCorrigido < 10){
				mesCorrigido = "0"+mesCorrigido;
			}
		var DiaCorrigido = d.getDate();
			// Corrige o valor da data, acescentando um 0 (zero) na frente dos dias 1 a 9.
			if (DiaCorrigido < 10){
				DiaCorrigido = "0"+DiaCorrigido;
			}
		var dataInicioTeste = d.getFullYear()+"_"+mesCorrigido+"_"+DiaCorrigido+"-H"+d.getHours()+"m"+d.getMinutes();
		$("input#dataHora").val(dataInicioTeste); // Envia para o Campo na index.php que salvara o dado
	 
	 
	// GERA AS VIS A PARTIR DOS PARAMETROS VI E Nº DE TENTATIVAS
		
		// caso o tempo de sesssao NAO seja o criterio de encerramento
		if (SessaoFimTempo == false) {
			VIs_OP1 = geraVIs(mediaVI, n_sessao);
			VIs_OP2 = geraVIs(mediaVI, n_sessao);
			DadosSessao(VIs_OP1, VIs_OP2); // Escreve na DIV "mensagens" dos componentes da VI para ambos os operandos		
		}
		
		// caso o tempo de sesssao seja o criterio de encerramento
		else {
			
			var LoopVIs = TempoFimSessao/(mediaVI * n_sessao);
			var i = 1;
			var VIs_OP1_Temp = [];
			var VIs_OP2_Temp = [];
			var VIs_OP1_Orig = [];
			var VIs_OP2_Orig = [];
		
			VIs_OP1 = geraVIs(mediaVI, n_sessao);
			VIs_OP2 = geraVIs(mediaVI, n_sessao);				

			// Concatena novos valores de VI ao Array de VIs de cada operando
			while (i < LoopVIs){
				VIs_OP1_Temp = geraVIs(mediaVI, n_sessao);
				VIs_OP2_Temp = geraVIs(mediaVI, n_sessao);
				VIs_OP1_Orig = VIs_OP1;
				VIs_OP2_Orig = VIs_OP2;
				
				VIs_OP1 = VIs_OP1.concat(VIs_OP1_Orig, VIs_OP1_Temp);
				VIs_OP2 = VIs_OP2.concat(VIs_OP2_Orig, VIs_OP2_Temp);		
				i++;
				DadosSessao(VIs_OP1, VIs_OP2); // Escreve na DIV "mensagens" dos componentes da VI para ambos os operandos
			}
			
							
		}
		
	NovamediaVI_1 = VIs_OP1[0];
	NovamediaVI_2 = VIs_OP2[0];
	
	avaliaOpTravado(); // Avalia se ha e qual eh o operando travado
	
	TempoChangeOverDelay = document.getElementById("TempoChangeOverDelay").value;

	// Desabilita o botao de Geracao de VIs
	document.getElementById('Gera_Valores').disabled = true;
	document.getElementById('Gera_Valores').value = "Sessão Iniciada!";
	
	// Define o nome dos operandos
	NomeOperando1 = document.getElementById("NomeOperando1").value;
	NomeOperando2 = document.getElementById("NomeOperando2").value;

} //  - - - - - - - - - - - FIM FUNCAO: iniciaTeste() - - - - - - - - - - - - - - 

// - ---------------------------------------------------------------------------------------------------------

function geraVIs(VI, n){
	/*  DESCRICAO DA FUNCAO
			Parametros
			  - VIs: Valor em segundos do esquema de intervalo variavel (VI)
			  - n: numero de componentes da VI
			 			  
			 Logica de funcionamento
			  - Sao criados n/2 componentes da VI da metade ABAIXO de VI/2
			  - Sao criados mais n/2 componentes da VI da metade ACIMA de VI/2
			  - Caso a o "n" seja um valor IMPAR a propria VI e incluida como um componente
	*/

var VIs = []; // Array que receberá as VIs
var VIsMin = []; // Array que receberá as VIs ABAIXO do valor da VI
var VIsMax = []; // Array que receberá as VIs ACIMA do valor da VI
var VIatual = VI; //Variavel usada no loop para receber os valores da VI e salvar no Array "VIs".
var PosVIs = []; //Variavel que recebe as fracoes da VI e que serao posterimente somadas a VI para criar componentes simetricos da VI;
var CorteVIs; // Variavel que define o numero de loops para criar as VIs
var PosVIsAtual = VI; // Define a posicao atual como o proprio VI
var nVI = 1; // indice da Array VIs (COMECA DO ZERO, 0)
var nPosVI = 1; // indice da Array VIs (COMECA DO ZERO, 0) e controle do loop que gera os pontos de corte das VIs
var ControleLoop = 1; // Controle de execussoes do loop + valor da divisao do VI

var PosVIsInt;
var PosVIsFloat;

var msg = ""; // Exibe as mensagens quando a sessao acaba
var TipoN; // Recebe o Tipo do "n", se PAR ou IMPAR
var totalVIs = 0; //Calcula a soma dos componentes da VI para posteriormente ser dividido pelo "n" e calcular a media (VI)
var MediaVIs = 0; //Calcula a media dos componentes da VI para conferir se bate com o valor passado em "VI".

		//Avalia se o nº de tentativas eh IMPAR OU PAR (CORRIGE FALHA AO DIVIDIR O n AO MEIO) - OK
		// Gera o nº de vezes que o loop ira rodar para gerar os componetes da VI
 		if (n % 2 == 0){ //Caso o "n" seja PAR
			CorteVIs = Math.round(n/2)
		} else{ //Caso o "n" seja IMPAR
			 // Garante que os loops criarao n-1 intervalos para a VI
			 // Outra condicional ao fim acrescenta a propria VI como ultimo intervalo
			CorteVIs = (Math.round(n/2)) - 1
		}

		
	// Cria os "n" pontos de corte no intervalo da VI que serão somados e subtraidos a VI
    while (nPosVI <= CorteVIs) {

        // Garante que o valor "0" e VI * 2 sejam usados como componentes da VI
        if (ControleLoop == 1){ // Se primeira execussao do loop o proprio valor da VI sera usado
           PosVIsAtual = VI;
		} else{
           PosVIsAtual = PosVIsAtual/ControleLoop;
        }

        PosVIsFloat = PosVIsAtual%1; // Separa apenas o valor decimal de "PosVIsAtual".
		if(PosVIsFloat == 0 || PosVIsFloat == 0.5){
			PosVIs[nPosVI] = PosVIsAtual;
		} else{
			PosVIsInt = parseInt(PosVIsAtual);			
			
				// SUBSTITUI O "PosVIsFloat" pela versao arredondada com decimal 0 ou 5.
				if (PosVIsFloat > 0.5){
					PosVIsFloat = 1;
				} else {
					PosVIsFloat = 0.5;
				}
			
			// GERA NOVO "PosVIsAtual", COM VALOR DECIMAL ARREDONDADO PARA "0" OU "5".
			PosVIsAtual = PosVIsInt + PosVIsFloat;
            PosVIs[nPosVI] = PosVIsAtual;
		}
		
		nPosVI++;
		ControleLoop++;
	}
	
	//Cria o valor da VI abaixo
	while (nVI <= CorteVIs) {
		VIatual = PosVIs[nVI];
		VIs[nVI] = parseInt(VI) - parseFloat(VIatual);
		
		// Condicional que avalia se o valor da VI gerado eh zero
		if (VIs[nVI] == 0){
			totalVIs += 1; // Caso o valor da VI seja zero eh substituido por 1 (um)
		} else{
			totalVIs += VIs[nVI]; //Envia cada VI para a var totalVIs
		}
		
		nVI++;// Altera o indice do array para receber o proximo valor
	}
	
	// ZERA o indice da Array VIs 
	nPosVI = 1;
	
	//Cria o valor da VI acima (simetrico ao abaixo criado anterioremente)
	while (nPosVI <= CorteVIs) {
		VIatual = parseInt(VI) + parseFloat(PosVIs[nPosVI]); // Compensa o incremento enterior e cria um equivalente acima da VI
		VIs[nVI] = VIatual;
		// Condicional que avalia se o valor da VI gerado eh zero
		if (VIs[nVI] == 0){
			totalVIs += 1; // Caso o valor da VI seja zero eh substituido por hum (1)
		} else {
			totalVIs += VIs[nVI]; //Envia cada VI para a var totalVIs
		}
		nPosVI++;// Altera o indice do array para receber o proximo valor
		nVI++;
	}

	/* _______________________ATENCAO_________________________
		CRIA UM CONDICIONAL (SE PAR OU IMPAR) PARA
		ACRESCENTAR A VI COMO COMPONENTE DA ARRAY NO CASO DE 
		VALORES DE "n" IMPARES. */
		 if (n % 2 != 0){ //Caso o "n" seja IMPAR
			VIs[nVI] = parseInt(VI);
			totalVIs += parseInt(VI); //o parseInt() garante que o valor de VI seja reconhecido como numero (corrige erro da media)
		}
/*		_______________________________________________________ */
	


	//Elimina valores invalidos da Array com as VIs
	for (nVI = 0; nVI <= n_sessao; nVI++){
		if (VIs[nVI] == "" ||VIs[nVI] == null){
			VIs.splice(nVI, 1); // Apaga o valor na posicao "n"
		}
	}
		
				
		// Calcula a media dos VIs (conferir se e igual ao VI definido)
		mediaVIs = Math.round(parseInt(totalVIs)/n);
		document.getElementById("mensagens").value += " | Total componetes da VI: "+VIs.length;
		document.getElementById("mensagens").value += " => VI (média): "+mediaVIs;
	
	return VIs.shuffle();
	
} //  - - - - - - - - - - - FIM FUNCAO: geraVIs() - - - - - - - - - - - - - - 

		
// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --
	//Avalia de o tempo do componente da VI em vigor foi atingido
	function VI_OP1(){
	
		if (PausaSessao == true) { return false;}
		
		if (paraTudo == 1 || IniciaSessao == false || PausaSessao == true){
			return;
		}
		
		var ativo1 = "";
		if (operando1 == 1){ ativo1 = " | LIBERADO |";}
		document.getElementById("ativoOP1").value = "VI :"+NovamediaVI_1+" | ("+tempoOP1+")"+ativo1;

			// Incrementa o tempo do OP 1 quando ele eh inicia um novo componente da VI
			if (operando1 == 0 || aguardandoReforco_1 == 0){
				tempoOP1 += 0.5;
			}			

			// Ativa o Operando 1 se o valor da VI atual coincidir com o tempo
			if (tempoOP1 == NovamediaVI_1 && aguardandoReforco_1 == 0){ 
				operando1 = 1;
				aguardandoReforco_1 = 1;
				document.getElementById("reforco").value="Aguardando S+";
			}			

			// Ativa o Operando 1 se o valor da VI atual for 0 (zero)
			if (NovamediaVI_1 == 0 && aguardandoReforco_1 == 0 && tempoOP1 > 0){ 
				operando1 = 1;
				aguardandoReforco_1 = 1;
				document.getElementById("reforco").value="Aguardando S+";
			}

	}

// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --
	//Avalia Se o tempo do componente da VI em vigor foi atingido
	function VI_OP2(){
	
		if (PausaSessao == true) { return false;}
		
		if (paraTudo == 1 || IniciaSessao == false || PausaSessao == true){
			return
		}
		
		var ativo2 = "";
		if (operando2 == 1){ ativo2 = " | LIBERADO |"; }
		document.getElementById("ativoOP2").value = "VI :"+NovamediaVI_2+" | ("+tempoOP2+")"+ativo2;
			
				// Incrementa o tempo do OP 2 quando ele inicia um novo componente da VI
				if (operando2 == 0 || aguardandoReforco_2 == 0){
					tempoOP2 += 0.5
				}
				
				// Ativa o Operando 1 se o valor da VI atual coincidir com o tempo
				if (tempoOP2 == NovamediaVI_2 && aguardandoReforco_2 == 0){
					operando2 = 1;
					aguardandoReforco_2 = 1;					
					document.getElementById("reforco").value="Aguardando S+";
				}

				// Ativa o Operando 2 se o valor da VI atual for 0 (zero)
				if (NovamediaVI_2 == 0 && aguardandoReforco_2 == 0 && tempoOP2 > 0){ 
					operando2 = 1;
					aguardandoReforco_2 = 1;
					document.getElementById("reforco").value="Aguardando S+";
				}
		
}


// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	

  
	function reforca1() {
		
		if (PausaSessao == true) { return false;}
		
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		//Condicao que trava o operando faltando um S+ para concluir os componentes do mesmo
		if(OP1travado == true){
			
			// Condicao que anula a contagem de cliques e reforcos caso Operando 
			// travado e condicao de encerramento da sessao eh um limite de tempo
			if (SessaoFimTempo == true && cliquesOP1 >= (cliquesOP2 - 1)){
				return false; // Para a execucao da funcao
			}
			
			//Caso a contagem de S+ for acumulada (soma nos dois operandos)
			if(ContagemAcumulada == true) {
				// Aguardando momento travar
				if(contaReforco1 == momentoTravaOP){
					return false;
				}
				
			}	
			
			//Caso a contagem de S+ for individual
			if(ContagemAcumulada == false) {
				if(contaReforco1 == momentoTravaOP){
					return false;
				}
			}
			
		}
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

		cliquesOP1++ // conta clique no operando 1
		document.getElementById("COD_OP1").value = COD_OP1; //Registra o num de CODs no Operando 1
				
	
		//Reforco liberado: operando1 == 1 - Avaliado pela funcao VI_OP1().
		if (operando1 == 1 && (contaReforco1 <= n_sessao || SessaoFimTempo == true || PausaSessao == false)){
			
			// Avalia se um COD e necessario
			if (
				(AlternacoesOPs[0]==1 && AlternacoesOPs[1]==2 && AlternacoesOPs[2]==1)
				|| (AlternacoesOPs[0]==2 && AlternacoesOPs[1]==1 && AlternacoesOPs[2]==2)
				) {
				FnChangeOverDelay("Op1");
				ChangeOverDelay = true;
				return false;
			}			
						
			// Gera os dados referentes ao momento do reforco que serao gravados no CSV
			document.getElementById("reforco").value="Reforcou (aguarde liberar)";
			document.getElementById("OP1_VIs").value += tempoOP1+", ";
			document.getElementById("OP1_CliquesRef").value += cliquesOP1+", ";
			document.getElementById("OP1momentoS").value += tempoSessao+", "; //Registra o momenta na sessao que recebeu S+ no OP 1
			
			caixa1++; // Incrementa a caixa de reforco
			piscaElemento('botaoOP2');
			$(document).ready(function(){
				$('#botaoOP1').effect("pulsate", { times:3 }, 100);
			})
			PausarSessao(); // Pausa ou Reativa a sesssao para o consumo do reforco
			setTimeout('PausarSessao()', PausaPosReforco);
			
			
			// Atualiza os valores dos parametros de controle apos o reforco
			aguardandoReforco_1 = 0; // Zera a var de controle: aguardandoReforco_1
			formDados.ativoOP1.value = "VI :"+NovamediaVI_1+" | ("+tempoOP1+")";
			document.getElementById("S+_OP1").value = caixa1;
			operando1 = 0;
			tempoOP1 = 0;
			contaReforco1++;
			playSound(); 
			 
				// Aumenta o tamanho da barra abaixo do operando 1 ou a Jarra de contagem acumulada
				if(ContagemAcumulada == false && BarraReforco == true) {
					resizeOP("barraOP1");
				}
				else if (TipoSessao == "AcumuladaSimples" && BarraReforco == true){
					resizeOP("barraOP");
				}
				else if (TipoSessao == "AcumuladaDiscriminada" && BarraReforco == true){
					resizeOP("barraOP1");
				}			
			
			finalizaSessao();
			 
			//Pega outro valor de VI da Array
			NovamediaVI_1 = VIs_OP1[contaReforco1];
			//document.getElementById("mensagens").innerHTML += "<b>NovamediaVI_1:</b> "+NovamediaVI_1+" ("+contaReforco1+") | ";


		} //FIM - Reforco liberado
		
		else {
		document.getElementById("reforco").value="Aguarde liberar o operando!";
		document.getElementById('botaoOP1').style.opacity = 1;
		}
		
		//Registra o ultimo clique como sendo no OP 1
		UltimoCliqueOP = 1;
		AlternacoesOPs.unshift(UltimoCliqueOP); // Adiciona o Nome do Operando atual ao controle de alternacoes
		AlternacoesOPs.pop(); // Remove o ultimo elemento do controle de alternacoes
	}

// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	
	function reforca2() {
	
		if (PausaSessao == true) { return false;}

		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
		//Condicao que trava o operando faltando um S+ para concluir os componentes do mesmo
		if(OP2travado == true){
		
			// Condicao que anula a contagem de cliques e reforcos caso Operando 
			// travado e condicao de encerramento da sessao eh um limite de tempo
			if (SessaoFimTempo == true && cliquesOP2 >= (cliquesOP1 - 1)){
				return false; // Para a execucao da funcao
			}		
			
			//Caso a contagem de S+ for acumulada (soma nos dois operandos)
			if(ContagemAcumulada == true) {
				if(contaReforco2 == momentoTravaOP){
					return false;
				}
				
			}	
			
			//Caso a contagem de S+ for individual
			if(ContagemAcumulada == false) {
				if(contaReforco2 == momentoTravaOP){
					return false;
				}
			}
			
		}
		// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -

	
		cliquesOP2++ // conta clique no operando 2
		document.getElementById("COD_OP2").value = COD_OP2; //Registra o num de CODs no Operando 2

		
		// Reforco liberado: operando2 == 1 - Avaliado pela funcao VI_OP2().
		if (operando2 == 1 && (contaReforco2 <= n_sessao || SessaoFimTempo == true || PausaSessao == false)){
		
			// Avalia se um COD e necessario
			if (
				(AlternacoesOPs[0]==1 && AlternacoesOPs[1]==2 && AlternacoesOPs[2]==1)
				|| (AlternacoesOPs[0]==2 && AlternacoesOPs[1]==1 && AlternacoesOPs[2]==2)
				) {
				FnChangeOverDelay("Op2");
				ChangeOverDelay == true;
				return false;
			}			
			
			document.getElementById("reforco").value="Reforcou (aguarde liberar)";
			document.getElementById("OP2_VIs").value += tempoOP2+", ";
			document.getElementById("OP2_CliquesRef").value += cliquesOP2+", ";
			document.getElementById("OP2momentoS").value += tempoSessao+", "; //Registra o momenta na sessao que recebeu S+ no OP 2
						
			caixa2++;
			piscaElemento('botaoOP1');
			$(document).ready(function(){
				$('#botaoOP2').effect("pulsate", { times:3 }, 100);
			})
			PausarSessao(); // Pausa ou Reativa a sesssao para o consumo do reforco
			setTimeout('PausarSessao()', PausaPosReforco);	
			
			// Atualiza os valores dos parametros de controle apos o reforco			
			aguardandoReforco_2 = 0;
			formDados.ativoOP2.value = "VI :"+NovamediaVI_2+" | ("+tempoOP2+")";
			document.getElementById("S+_OP2").value= caixa2;
			operando2 = 0;
			tempoOP2 = 0;
			contaReforco2++;
			playSound();
			
				// Aumenta o tamanho da barra abaixo do operando 2 ou a Jarra de contagem acumulada
				if(ContagemAcumulada == false && BarraReforco == true) {
					resizeOP("barraOP2");
				}
				else if (TipoSessao == "AcumuladaSimples" && BarraReforco == true){
					resizeOP("barraOP");
				}
				else if (TipoSessao == "AcumuladaDiscriminada" && BarraReforco == true){
					resizeOP("barraOP2");
				}
			
			finalizaSessao();
			
			//Pega outro valor de VI da Array
			NovamediaVI_2 = VIs_OP2[contaReforco2];
			//document.getElementById("mensagens").innerHTML += "<b>NovamediaVI_2:</b> "+NovamediaVI_2+" ("+contaReforco2+") | ";

		} //FIM - Reforco liberado
		
		else {
		document.getElementById("reforco").value="Aguarde liberar o operando!";
		document.getElementById('botaoOP2').style.opacity = 1;
		}
		
		//Registra o ultimo clique como sendo no OP 1
		UltimoCliqueOP = 2;
		AlternacoesOPs.unshift(UltimoCliqueOP); // Adiciona o Nome do Operando atual ao controle de alternacoes
		AlternacoesOPs.pop(); // Remove o ultimo elemento do controle de alternacoes		
	}
	
