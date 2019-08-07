

// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --

// FUNCOES GERAIS

	// Funcao que exibe os controles de definicao de sessao quando esta tudo carregado na pagina
    // Apos a indicacao do parametro de velocidade ("slow"), e possivel indicar i que sera chamado em seguida.
	   // Optei por mostrar (.show()) a div #operandos chamando como uma funcao function(){}
	function Carregado() {
		$("#Carregando").hide("slow", function () {
			$("#operandos").show("800");
			$("#formsEscolha").show("800");
		});	
	}

	// Funcao que randomiza os valores de uma Array
	Array.prototype.shuffle = function() {
	var s = [];
		while (this.length) s.push(this.splice(Math.random() * this.length, 1)[0]);
		while (s.length) this.push(s.pop());
	return this;
	}

	function embaralhaArray(matriz){
		for(var j, x, i = matriz.length; i; j = parseInt(Math.random() * i), x = matriz[--i], matriz[i] = matriz[j], matriz[j] = x);
		return matriz;
	}
	
	// Funcao que altera a tela do operando 1
	function defineOperando1(){
			NomeOp1 = document.getElementById('NomeOperando1').value;
			document.getElementById("botaoOP1").src = "img/"+NomeOp1+".png";
	}
	// Funcao que altera a tela do operando 2
	function defineOperando2(){
			NomeOp2 = document.getElementById('NomeOperando2').value;
			document.getElementById("botaoOP2").src = "img/"+NomeOp2+".png";
	}

	function avaliaNomeOps(){
		if(document.getElementById('NomeOperando1').value == document.getElementById('NomeOperando2').value){
				alert("Elementos de escolha iguais nos dois operandos!");
				IniciaSessao = false;
			}
	}

	// Verifica se algum operando esta travado nessa sessao
	function avaliaOpTravado(){	
		if (document.getElementById('ContagemAcumuladaDiscriminado').checked == true || document.getElementById('ContagemAcumulada').checked == true) {
			momentoTravaOP = (Math.round(n_sessao/2) - 1);
		} else {
			momentoTravaOP = n_sessao -1;
		}
		if (document.getElementById('OP1travado').checked == true) {
			OP1travado = true;
		}
		if (document.getElementById('OP2travado').checked == true) {
			OP2travado = true;
		}
	}
	
	function avaliaTipoSessao(){
	
		// Avalia se o criterio de encerramento da sessao e o tempo
		if (TempoFimSessao != 0){
			SessaoFimTempo = true;
		}
	
		if(document.getElementById('ContagemAcumuladaDiscriminado').checked == true){
			// Marca a opcao de ContagemAcumulada
			document.getElementById('ContagemAcumulada').checked = true;
			document.getElementById('ContagemReforco').value = "AcumuladaDiscriminado";
			TipoSessao = "AcumuladaDiscriminado";
		}
		if (document.getElementById('ContagemAcumulada').checked == true) {
			ContagemAcumulada = true; // Torna a contagem acumulada na sesse (Soma S+ nos 2 operandos)
			TipoSessao = "AcumuladaSimples";
			
			// Indica de forma separada (discriminada) os reforcos por operando
				if (document.getElementById('ContagemAcumuladaDiscriminado').checked == true) {
						TipoSessao = "AcumuladaDiscriminada";
						document.getElementById('barraOPBkgdIMG').style.background = "url(img/white-jar-md_DESATIVADO.png)"
						// Oculta o jarro de moedas da condicao Acumulada
						document.getElementById('barraOP').style.display = "none";
				}
		
		} else {
			TipoSessao = "Independente";
			ContagemAcumulada = false; // Torna a contagem acumulada na sesse (Soma S+ nos 2 operandos)
			// Oculta o jarro de moedas da condicao Acumulada
			document.getElementById('barraOPBkgdIMG').style.background = "url(img/white-jar-md_DESATIVADO.png)"
			document.getElementById('barraOP').style.display = "none";

		}
			
		//Oculta o formulario com os parametros quando inicia a sessao
		if (document.getElementById("ExibeFormParametros").checked == false){ // Avalia se o Checkbox esta marcado
			document.getElementById('formsEscolha').style.display = "none" //Oculta form de definicao dos parametros da sessao
			document.getElementById('TabelaOperandos').style.position = "static";
			document.getElementById('MargemSuperior').style.display = "block" // Exibe uma DIV que gera uma margem superior nos perandos
		}
		
		// Janela que antecede o inicio da sessao
		if(TempoFimSessao != 0){ var TextoSobreTempo = "\n Sessao encerra com: "+TempoFimSessao+"s"; }
		else { var TextoSobreTempo = "\n Sessao sem Criterio por Tempo"; }
		alert("Participante: "+$("#participante option:selected").text()+"\n Iniciar sessao VI: "+mediaVI+", Componentes: "+n_sessao+"  \n - Tipo da Sessao: "+TipoSessao+TextoSobreTempo);	

		//Oculta a Barra de Reforcos
		if (document.getElementById("OcultaBarraReforco").checked == true){ // Avalia se o Checkbox esta marcado
			BarraReforco = false; // As Barras de Reforco Nao devem ser exibidas
			$("#barraOP1").hide();
			$("#barraOP2").hide();
			// document.getElementById('barraOP1').style.display = "none" //Oculta Barra de Reforco Operando 1
			// document.getElementById('barraOP2').style.display = "none" //Oculta Barra de Reforco Operando 2
			document.getElementById('barraOP').style.display = "none" //Oculta Jarra de Reforco nao discriminado
		}		


		
	}	//FIM - function avaliaTipoSessao()
	
	function DadosSessao(VIs_OP1, VIs_OP2){
	
	/*  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	INSTRUCOES
		- Passar como parametros as array com os componentes da VI dos dois operandos
		- Precisa de elemento (div, td, etc..) "id=msg_OP1" e "id=msg_OP2"
	*/
		//Escreve os dados de VIs dos operandos OP 1 e OP 2 
		for(var i=0;i<VIs_OP2.length;i++){
			document.getElementById("msg_OP1").innerHTML += "<b>VIs_OP1["+i+"] </b>=>"+VIs_OP1[i]+"<br />";
		}	

		for(var i=0;i<VIs_OP1.length;i++){
			document.getElementById("msg_OP2").innerHTML += "<b>VIs_OP2["+i+"] </b>=>"+VIs_OP2[i]+"<br />";
		}
	// -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -
	}

function tempo(){
	/* 	AVALIA SE A SESSAO DEVE SER FINALIZADA AGORA OU NAO 
		  - Incrementa o tempo do contador geral da sessao
		  - Para o andamento do tempo se a sessao atingiu o criterio de encerramento
	*/
	
	if (PausaSessao == true) { return false;}

	if (IniciaSessao == true && PausaSessao == false){
		tempoSessao += 0.5 // incrementa o tempo em meio segundo
		document.getElementById("tempo").value = tempoSessao;
		document.getElementById("ClicksOP1").value = cliquesOP1;
		document.getElementById("ClicksOP2").value = cliquesOP2;
	
		document.getElementById("msgsCODs").value = UltimoCliqueOP;
		document.getElementById("msgsCODs").value += " ("+AlternacoesOPs.join()+")";
	
		if( document.getElementById("banner").style.visibility == "visible" ) {
			setInterval('document.getElementById("banner").style.visibility = "hidden";',1000)
		}
	
		if (paraTudo == 1){
			return; // Finaliza a sessão
		}
						
		finalizaSessao(); // Analisa se o total de reforço em um dos operandos atingiu o nº de tentativas estipulado pra sessao
	}	
}

// Pausa ou Reativa a sesssao: age sobre as funcoes tempo(); VI_OP1(); VI_OP2().
function PausarSessao(){
	if (PausaSessao == true){
		PausaSessao = false;
		document.getElementById("botaoOP1").style.opacity = 1;
		document.getElementById("botaoOP2").style.opacity = 1;
	} else {
		PausaSessao = true;
		document.getElementById("botaoOP1").style.opacity = 0.1;
		document.getElementById("botaoOP2").style.opacity = 0.1;
	}
	
}
// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	

// Ativa ou Desativa o COD: age sobre as funcoes tempo(); VI_OP1(); VI_OP2(); reforca1 2 reforca2.
function FnChangeOverDelay(passaOperando){
			//alert("COD "+passaOperando+" ATIVO. Duracao: "+TempoChangeOverDelay);
			PausaSessao = true;
			COD_Sessao++;
			setTimeout('PausarSessao()', TempoChangeOverDelay); // Desativa o COD apos um tempo
			if (passaOperando == "Op1"){
				//setTimeout('reforca1()', TempoChangeOverDelay); // Desativa o COD apos um tempo
				COD_OP1++;		
			} else if (passaOperando == "Op2"){
				//setTimeout('reforca2()', TempoChangeOverDelay); // Desativa o COD apos um tempo
				COD_OP2++;		
			}
			AlternacoesOPs.unshift(0,0,0,0); // Zera o contador de alternacoes, controle de ativacao do COD
			AlternacoesOPs.splice(4,4); // Remove os 4 elementos anteriores do controle de alternacoes
	}
// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	

	function resizeOP1(){
		document.getElementById("barraOP1").innerHTML += "<img src='img/coin.png'>";
	};

// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	
	function resizeOP2(){
		document.getElementById("barraOP2").innerHTML += "<img src='img/coin.png'>";
	};

// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --	
	function resizeOP(barra){
		
		document.getElementById(barra).innerHTML += "<img src='img/coin.png'>";
	};	

  function playSound() {
	if (BarraReforco == true){
		// Usa som de moeda quando exibe as moedas
		sound = new Audio("./som/coin2.wav");
	} else {
		// Usa som neutro de acerto quando NAO exibe as moedas
		sound = new Audio("./som/chime_up.wav");
	}	
		sound.setAttribute("autoplay", "autoplay");
		document.getElementsByTagName("body")[0].appendChild(sound);
		return true;
  }

//	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -

	function piscaElemento(elemento_id) {
		
		document.getElementById(elemento_id).style.opacity = 0.2;
	}
  
//	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -	- - - - - - - - -	- - - 
	
	// Funcao que analisa os criterios de encerramento da sessao (Envia os dados da sessao para salvar)
	function finalizaSessao(){
	
		if (PausaSessao == true) { return false;}
			
			// Avalia se a sessao ja iniciou (senao aborta a funcao)
			if(IniciaSessao == false){
				return;
			}

			// Avalia se a extrapolou o tempo maximo (senao aborta a funcao)
			if(tempoSessao >= TempoMaxSessao){
				alert('Tempo maximo de sessao alcancado!');
				FinalizadorSessao();
			}

		// AVALIA O TIPO DE SESSAO PARA DEFINIR O CRITERIO DE ENCERRAMENTO DA SESSAO
		switch (SessaoFimTempo) {	
			// -----------------------------------------------------------------------------------------------
			case true:
				// Avalia se o criterio de tempo para enecerrar a sessao foi atingida
				if (tempoSessao >= TempoFimSessao){
					// Verifica se o numero de cliques nos operandos eh diferente
					if (cliquesOP1 != cliquesOP2){
						FinalizadorSessao();
					}
				}
			break;
			// -----------------------------------------------------------------------------------------------
			
			
			// -----------------------------------------------------------------------------------------------
			case false:			
			// AVALIA SE A SESSAO TERA CONTAGEM ACUMULADA(SOMA S+ NOS 2 OPERANDOS) OU INDIVIDUAL POR OPERANDO
				// Caso a contagem SEJA ACUMULADA: avalia se atingiu o criterio (n exec da sessao)
				if (ContagemAcumulada == true) {
					totalReforcos = contaReforco1 + contaReforco2;
					if (totalReforcos == n_sessao){
						FinalizadorSessao();
					}
				// Caso a contagem SEJA INDIVIDUAL: avalia se atingiu o criterio (n exec da sessao)	
				} else{
					if (contaReforco1 == n_sessao || contaReforco2 == n_sessao){
						FinalizadorSessao()
					}
				}
			break;	
			// -----------------------------------------------------------------------------------------------
			
		}
	} // FIM Sessao finalizaSessao()
		
		
	function FinalizadorSessao(){
	
				
							
				// - - Indica Fim Sessao ao Participante - - - - - - - - - - - - - - - - - 
				switch (SessaoFimTempo) {								
				
				case true:
				
					if (cliquesOP1 > cliquesOP2){
						msgFim = "Você escolheu "+NomeOperando1+" | Cliques OP1: "+cliquesOP1+"/"+cliquesOP2;
						OperandoEscolhido = NomeOperando1;
					}
					else if (cliquesOP1 < cliquesOP2){
						msgFim = "Você escolheu "+NomeOperando2+" | Cliques OP2: "+cliquesOP2+"/"+cliquesOP1;
						OperandoEscolhido = NomeOperando2;
					}
					// Caso o num de cliques tenha sido o mesmo, desempata com num de reforcos
					else {
						if (caixa1 > caixa2){
							OperandoEscolhido = NomeOperando1;
							msgFim = "Você escolheu "+NomeOperando1+" | Cliques OP1: "+cliquesOP1+"/"+cliquesOP2;
						} else if (caixa2 > caixa1){
							OperandoEscolhido = NomeOperando2;
							msgFim = "Você escolheu "+NomeOperando2+" | Cliques OP2: "+cliquesOP2+"/"+cliquesOP1;
						} 
					}					
					
					// Acrescenta ao tipo de sessao o criterio de encerramento por tempo
					TipoSessao += " - Criterio de Tempo "+TempoFimSessao+"seg";
					
					msgFim += "\n Tempo CODs: "+((COD_Sessao * TempoChangeOverDelay)/1000)+" + Tempo Total: "+$("input#tempo").val();
					alert (msgFim);
				
				break;
				
				// -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   - \\
				
				case false:
				
					if (caixa1 > caixa2){
						msgFim = "Você escolheu "+NomeOperando1+" | Moedas OP1: "+caixa1+"/"+n_sessao;
						OperandoEscolhido = NomeOperando1;
					}
					else if (caixa1 < caixa2){
						msgFim = "Você escolheu "+NomeOperando2+" | Moedas OP2: "+caixa2+"/"+n_sessao;
						OperandoEscolhido = NomeOperando2;
					}
					// Caso o num de reforcos tenha sido o mesmo, desempata com num de cliques
					else {
						if (cliquesOP1 > cliquesOP2){
							OperandoEscolhido = NomeOperando1;
							msgFim = "Você escolheu "+NomeOperando1+" | Cliques OP1: "+cliquesOP1+"/"+cliquesOP2;
						} else if (cliquesOP2 > cliquesOP1){
							OperandoEscolhido = NomeOperando2;
							msgFim = "Você escolheu "+NomeOperando2+" | Cliques OP2: "+cliquesOP2+"/"+cliquesOP1;
						} 
					}
					
					msgFim += "\n Tempo CODs: "+((COD_Sessao * TempoChangeOverDelay)/1000)+" + Tempo Total: "+$("input#tempo").val();
					
					alert (msgFim);
					
				break;	
				}	
				// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
				
				paraTudo = 1; // muda var que parará todas as demais funcoes de tempo
				IniciaSessao = false;				
						
				// Envia os valores coletados para os input do form que salva os dados
					//document.getElementById("Partc").value = document.getElementById("participante").value;
				$("input#Partc").val($("#participante option:selected").text());//jQuery: Atribui o valor do input #participante no input #Partc
				// $("input#dataHora").val($("#dataInicio").val()); // Ativo na funcao iniciaTeste() (funcoes_controleVI.js)
				$("input#VI").val(mediaVI);
				$("input#nInteracoes").val(n_sessao);
				$("input#clqOP1").val(cliquesOP1);
				$("input#clqOP2").val(cliquesOP2);
				$("input#pontosOP1").val(caixa1);
				$("input#pontosOP2").val(caixa2);
				$("input#VIs_P1").val($("input#OP1_VIs").val());
				$("input#VIs_P2").val($("input#OP2_VIs").val());
				$("input#CliquesRef_OP1").val(document.getElementById("OP1_CliquesRef").value);
				$("input#CliquesRef_OP2").val($("input#OP2_CliquesRef").val());
				$("input#totalSessao").val($("input#tempo").val());
				$("input#NomeOp1").val(NomeOperando1);
				$("input#NomeOp2").val(NomeOperando2);
				$("input#OperandoEscolhido").val(OperandoEscolhido);
				$("input#ContagemReforco").val(TipoSessao);
				$("input#COD_Sessao").val(TempoChangeOverDelay);
				$("input#COD_OP1").val(COD_OP1);
				$("input#COD_OP2").val(COD_OP2);
				if (OP1travado == true){
					$("input#OPTravado").val(NomeOperando1);
				} else if (OP2travado == true){
					$("input#OPTravado").val(NomeOperando2);
				} else {
					$("input#OPTravado").val(" - ");
				}
				
				//Ativa ou desativa o envio dos dados via AJAX
				// - O Ajaxa nao esta enviando alguns dados, mas funciona bem para muitos
				var AJAXativo = false; 
				
				if (AJAXativo == true) {
					var EnviardataHora = $("input#dataHora").val();
					var EnviarPartc = $("input#Partc").val();
					var EnviarVI = $("input#VI").val();
					var EnviarnInteracoes = $("input#nInteracoes").val();
					var EnviarnVIs_P1 = $("input#OP1_VIs").val();
					var EnviarnVIs_P2 = $("input#OP2_VIs").val();
					var EnviarnCliquesRef_OP1 = $("input#OP1_CliquesRef").val()
					var EnviarnCliquesRef_OP2 = $("input#OP2_CliquesRef").val();
					var EnviarntotalSessao = (COD_Sessao + TempoChangeOverDelay) + $("input#tempo").val();
					var EnviarnNomeOp1 = NomeOperando1;
					var EnviarnNomeOp2 = NomeOperando2;
					var EnviarnOperandoEscolhido = OperandoEscolhido;
					var EnviarnContagemReforco = TipoSessao;				
					if (OP1travado == true){
						var EnviarOPTravado = NomeOperando1;
					} else if (OP2travado == true){
						var EnviarOPTravado = NomeOperando2;
					} else {
						var EnviarOPTravado = " - ";
					}
					
					
					// Funcao jQuery que envia dados via POST em AJAX
					$.post('resultado.php',
						
						//Variaveis e valores passados ao arquivo 'resultado.php'
						{
						AJAXdataHora: EnviardataHora,
						AJAXPartc: EnviarPartc, 
						AJAXVI: EnviarVI, 
						AJAXnInteracoes: EnviarnInteracoes,								
						AJAXclqOP1: cliquesOP1, // Nao esta salvando!
						AJAXnclqOP2: cliquesOP2, // Nao esta salvando!
						AJAXnpontosOP1: caixa1, // Nao esta salvando!
						AJAXnpontosOP2: caixa2, // Nao esta salvando!
						AJAXnVIs_P1: EnviarnVIs_P1, // Nao esta salvando!
						AJAXnVIs_P2: EnviarnVIs_P2, // Nao esta salvando!
						AJAXnCliquesRef_OP1: EnviarnCliquesRef_OP1, // Nao esta salvando!
						AJAXnCliquesRef_OP2: EnviarnCliquesRef_OP2, // Nao esta salvando!
						AJAXntotalSessao: EnviarntotalSessao, // Nao esta salvando!
						AJAXnNomeOp1: NomeOperando1, // Nao esta salvando!
						AJAXnNomeOp2: NomeOperando2, // Nao esta salvando!
						AJAXnOperandoEscolhido: OperandoEscolhido, // Nao esta salvando!
						AJAXnContagemReforco: TipoSessao, // Nao esta salvando!
						AJAXOPTravado: EnviarOPTravado,
						}, 
						
						// Chama algumas funcoes apos enviar os dados ao arquivo
						function(data) {
							$('#formDados').hide();
							$('#formCaixa').hide();
							$('#TabelaOperandos').hide();
							$('#mensagens').html(data); // Exibe o resultado gerado pelo arquivo na DIV de ID mensagens
							
						}
									
					);
				}
				
				// Caso salvar via AJAX esteja desativado
				else{
				//envia o formulario formSalvaDados automaticamente
				document.formSalvaDados.submit();				
				}
				
	
	} // FIM Sessao FinalizadorSessao()

	
// --   --   --   --   --   --   --   --   --   --   --   --   --   --   --   --
	// exibe ou oculta o OK de reforco
	function controlaCamada() {
		if( document.getElementById("banner").style.visibility == "hidden" ) {
		document.getElementById("banner").style.visibility = "visible";
		} else {
		document.getElementById("banner").style.visibility = "hidden";
		}
	}