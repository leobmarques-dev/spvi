<html>
<head>
	<title>Sistema para apresentação de 2 condições de escolha - Léo Marques (V 2)</title>

	<script type="text/javascript" src="classes/jquery-1.8.1.js"></script>
	<script type="text/javascript" src="classes/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
	<script type="text/javascript" src="classes/jquery-blink.js"></script>
	<script type="text/javascript" src="classes/confirm/js/jquery.simplemodal.js"></script>	
	<script type="text/javascript" src="classes/confirm/js/confirm.js"></script>

	<!-- /** <script type="text/javascript" src="prototype.js"></script> **/ -->
	<script type="text/javascript" src="classes/funcao_principal.js"></script>
	<script type="text/javascript" src="classes/funcoes_controleVI.js"></script>
	<script type="text/javascript" src="classes/trava_botao.js"></script>

	<script type="text/javascript" src="variaveis_globais.js"></script>
	
	<link rel='stylesheet' href='estilo.css' type='text/css'/>
	<link rel='stylesheet' href='classes/confirm/css/confirm.css' type='text/css'/>

</head>
 
						<!--o tempo é definido em milissegundos--->
<body onload="Carregado();setInterval('tempo();VI_OP1();VI_OP2();',500);" onselectstart="return false">

<div id='Carregando' style="width: 90%; height: 80%;opacity:0.6;filter:alpha(opacity=60);vertical-align:middle;z-index: 10;display: inline;position:absolute;top:10px;margin-left: 5%;background-color:#b0c4de;border-style:outset;text-align:center;">Carregando</div>

	<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" class="formsEscolha" name="formsEscolha" id="formsEscolha" style="display: none">
		<tr>
		<td align="left" valign="top">			
			<font align="left" style="text-align: left;font-size: 20px;font-weight: bold;">
				<a href='index.php'>SISTEMA DE ESCOLHA POR INTERVALO VARIÁVEL (V2)</a> || 
			</font>
			<a href='resultados/index.php'>[Resultados]</a><br />				
		
		<!-- INICIO - Form formDados -->
			<form name="formDados" id="formDados">
			<input type="HIDDEN" name="iniciaSessaoVI" id="iniciaSessaoVI" value="0">
			<div id="msgVIs"></div>	
				Participante: <?php include("lista_participante.php");?> 
				<input type="button" class="Gera_Valores" name="Gera_Valores" id="Gera_Valores" value="Iniciar Sess&atilde;o"  onCLick="iniciaTeste();defineOperando1();defineOperando2();avaliaNomeOps();">
				<?php $dataInicio = date("Y_m_d")."-H".date("H")."m".date("i");?>
				<input type="HIDDEN" name="dataInicio" id="dataInicio" value="<?php echo $dataInicio; ?>">
				<?php echo date("d/m/Y")." (".date("H").":".date("i")."h)"; ?><br />
				
				[<input type="checkbox" name="ExibeFormParametros" id="ExibeFormParametros" /> Exibe Form Parametros]
				[<input type="checkbox" name="OP1travado" id="OP1travado" /> TRAVA OP 1 |
				<input type="checkbox" name="OP2travado" id="OP2travado" /> TRAVA OP 2]
				<input type="text" name="TempoFimSessao" id="TempoFimSessao" value="180" size="3" />s <br />
				[ <input type="checkbox" name="ContagemAcumulada" id="ContagemAcumulada" /> Contagem S+ Acumulada
				(<input type="checkbox" name="ContagemAcumuladaDiscriminado" id="ContagemAcumuladaDiscriminado" /> Discriminado)] | 
				<input type="checkbox" name="OcultaBarraReforco" id="OcultaBarraReforco" checked="checked" /> Oculta Barra Reforco<br />

				Nome Operando 1: <select size="1" name="NomeOperando1" id="NomeOperando1" OnMouseOver="defineOperando1();avaliaNomeOps();">
										<option value="geic" selected>GEIC</option>
										<option value="nada">NADA</option>
										<option value="jogo">JOGO</option>
								 </select>
				| Nome Operando 2: <select size="1" name="NomeOperando2" id="NomeOperando2" OnMouseOver="defineOperando2();avaliaNomeOps();">
										<option value="jogo" selected>JOGO</option>
										<option value="nada">NADA</option>
										<option value="geic">GEIC</option>
								 </select>
				[COD <input type="text" name="TempoChangeOverDelay" id="TempoChangeOverDelay" value="1000" size="5">]
				<br />
				<b> Dados Sessão:</b>
							<i>VI (média):</i><select size="1" name="VISessao" id="VISessao">
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12" selected>12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="20">20</option>
												<option value="25">25</option>
												<option value="30">30</option>
											  </select>
							<i>Nº tentativas:</i><select size="1" name="TentativasSessao" id="TentativasSessao">
												<option value="3">3</option>
												<option value="5">5</option>
												<option value="7">7</option>
												<option value="9" selected>9</option>
												<option value="11">11</option>
												<option value="15">15</option>
												<option value="21">21</option>
												<option value="35">35</option>												
												
											  </select>	

					<!-- INICIO - Dados sessao em tempo real (Caso 'Exibe Form Parametros' = ativado) --><br />
					Operando 1 <input type="text" name="ativoOP1" id="ativoOP1" value="" readonly="readonly" size="20" style="background:#CCCCFF;">
					COD<input type="text" name="COD_OP1" id="COD_OP1" value="" readonly="readonly" size="3" style="background:#CCCCFF;">
					| Operando 2 <input type="text" name="ativoOP2" id="ativoOP2" value="" readonly="readonly" size="20" style="background:#CCCCFF;">
					COD <input type="text" name="COD_OP2" id="COD_OP2" value="" readonly="readonly" size="3" style="background:#CCCCFF;"><br />				
					Tempo sessão: <input type="text" size="1" name="tempo" id="tempo" value="" readonly="readonly" style="background:#CCCCFF;">segs |
					<input type="text" size="30" id="reforco" name="reforco" value="Aguardando Clique" readonly="readonly" style="background:#CCCCFF;">
					Ultimo OP ativo: <input type="text" size="6" id="msgsCODs" name="msgsCODs" value="" readonly="readonly" style="background:#CCCCFF;">
					<!-- FIM - Dados sessao em tempo real (Caso 'Exibe Form Parametros' = ativado) -->
					
					<div style="width:450px;padding:2px;position:relative;top:10px;margin-left: auto;margin-right: auto;background-color:#b0c4de;border-style:outset;text-align:center;text-decoration:overline;color:red;">
						Desenvolvido para navegadores Google Chrome e Mozzila Firefox
					</div>
			
			</form> 
		<!-- FIM - Form formDados -->
		
		</td>
		<td align="center" valign="top">
		
		<b>Dados de Desempenho na Sessão</b>
				<form name="formCaixa" id="formCaixa">
					<table border="1" align="center" width="100%" id="dadosSessao" name="dadosSessao" style="position: relative; z-index:-3;">
					<tr>
						<td valign="top">
							OP 1 <input type="text" size="2" name="ClicksOP1" id="ClicksOP1" value="" readonly="readonly" /> cliques acumulados<br />
							Pontos<input type="text" size="10" name="S+_OP1" id="S+_OP1" value="" readonly="readonly"> reforços<br />
							VIs<input type="textarea" size="30" name="OP1_VIs" id="OP1_VIs" value="" readonly="readonly"><br />
							Cliques<input type="textarea" size="30" name="OP1_CliquesRef" id="OP1_CliquesRef" value="" readonly="readonly">
							<input type="HIDDEN" name="OP1momentoS+" id="OP1momentoS+" value="">
						</td>
						<td valign="top">
							OP 2 <input type="text" size="2" name="ClicksOP2" id="ClicksOP2" value="" readonly="readonly"> cliques acumulados<br />
							Pontos<input type="text" size="10" name="S+_OP2" id="S+_OP2" value="" readonly="readonly">reforços<br />
							VIs<input type="text" size="30" name="OP2_VIs" id="OP2_VIs" value="" readonly="readonly"><br />
							Cliques<input type="text" size="30" name="OP2_CliquesRef" id="OP2_CliquesRef" value="" readonly="readonly">
							<input type="HIDDEN" name="OP2momentoS+" id="OP2momentoS+" value="">
						</td>
					</tr>
				</table>
				<table border="1" align="center" width="100%" id="SessaoComponentesVIs" name="SessaoComponentesVIs">	
					<tr>
						<td align='center'><b>VIs Op 1</b></td>
						<td align='center'><b>VIs Op 2</b></td>
					</tr>
					<tr>
						<td id='msg_OP1' name='msg_OP1'></td>
						<td id='msg_OP2' name='msg_OP2'></td>
					</tr>
				</table>	
				</form>
		</td>
		</tr>
	</table>	<!-- FIM Tabela formsEscolha -->		

	<div class="MargemSuperior" name="MargemSuperior" id="MargemSuperior" align="center"></div>
	<DIV name="mensagens" id="mensagens"></DIV>	
	
	<div name="TabelaOperandos" id="TabelaOperandos" style="position: fixed;left:200px;top:250px; z-index:5">
	<table border="0" align="center" id="operandos" name="operandos" style="display: none;margin-left: auto;margin-right: auto">
		<tr>
			<td><img src="img/geic.png" class="botaoOP1" name="botaoOP1" id="botaoOP1" onClick="reforca1();"></td>
			<td WIDTH=200><div class="banner" name="banner" id="banner"></div></td>
			<td><img src="img/jogo.png" class="botaoOP2" name="botaoOP2" id="botaoOP2" onClick="reforca2();"></td>
		</tr>	
		<tr>
			<td align="center" valign="top"><div class="barraOP1" name="barraOP1" id="barraOP1" align="left"></div></td>
			<td WIDTH=177 height=270  align="center" valign="bottom" class="barraOPBkgdIMG" id="barraOPBkgdIMG" name="barraOPBkgdIMG">
				<div class="barraOP" name="barraOP" id="barraOP" align="center"></div>
			</td>
			<td align="center" valign="top"><div class="barraOP2" name="barraOP2" id="barraOP2" align="left"></div></td>
		</tr>
	</table>
	</div>

	<div id="divFomrSalvaDados">  
		<form METHOD=GET ACTION="resultado.php" name="formSalvaDados">
		<input type="HIDDEN" name="dataHora" id="dataHora" value="">
			<input type="HIDDEN" name="VI" id="VI" value="">
			<input type="HIDDEN" name="nInteracoes" id="nInteracoes" value="">
			<input type="HIDDEN" name="Partc" id="Partc" value="">
			<input type="HIDDEN" name="OPTravado" id="OPTravado" value="">
			<input type="HIDDEN" name="clqOP1" id="clqOP1" value="">
			<input type="HIDDEN" name="clqOP2" id="clqOP2" value="">
			<input type="HIDDEN" name="pontosOP1" id="pontosOP1" value="">
			<input type="HIDDEN" name="pontosOP2" id="pontosOP2" value="">
			<input type="HIDDEN" name="VIs_P1" id="VIs_P1" value="">
			<input type="HIDDEN" name="VIs_P2" id="VIs_P2" value="">
			<input type="HIDDEN" name="CliquesRef_OP1" id="CliquesRef_OP1" value="">
			<input type="HIDDEN" name="CliquesRef_OP2" id="CliquesRef_OP2" value="">
			<input type="HIDDEN" name="OP1momentoS" id="OP1momentoS" value="">
			<input type="HIDDEN" name="OP2momentoS" id="OP2momentoS" value="">
			<input type="HIDDEN" name="totalSessao" id="totalSessao" value="">
			<input type="HIDDEN" name="NomeOp1" id="NomeOp1" value="">
			<input type="HIDDEN" name="NomeOp2" id="NomeOp2" value="">
			<input type="HIDDEN" name="OperandoEscolhido" id="OperandoEscolhido" value="">
			<input type="HIDDEN" name="ContagemReforco" id="ContagemReforco" value="">
			<input type="HIDDEN" name="COD_Sessao" id="COD_Sessao" value="">
			<input type="HIDDEN" name="COD_OP1" id="COD_OP1" value="">
			<input type="HIDDEN" name="COD_OP2" id="COD_OP2" value="">
		</form>
	</div>
	

	
</body>
</html>
