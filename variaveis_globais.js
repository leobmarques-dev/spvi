// Variaveis Globais
var totInt; //Total de Interacoes
var mediaVI;
var VI_sessao = 5; // VI definida para a sessao
var n_sessao = 1;
var tempoSessao = 0; // Tempo total da sessao
var TempoMaxSessao = 600; // Tempo maximo de sessao em segundos (Sessao encerra qdo alcanca essa valor)
var PausaSessao = false; //Pausa a sessao (Ex para receber/consumir um reforco)
var PausaPosReforco = 1000; // Duracao da Pausa pos reforco (em milisegundos)
var IniciaSessao = 0; //Var que indica se a sesao foi iniciada ou nao
var SessaoFimTempo = false; // Var que indica se o encerramento da sessao sera por tempo ou nao
var TempoFimSessao = 0; // Var que indica o tempo para encerramento da sessao
var ContagemAcumulada = false; // Indica se o criterio de encerramento sera com base na soma dos S+ nos 2 operandos ou nao
var ChangeOverDelay = false; // Variavel que indica se um COD esta ativo ou nao em um dado moento da sessao
var COD_Sessao = 0; // Contador de CODs durante a sessao
var COD_OP1 = 0; // Contador da Manutencao de cliques no Operando 1 durante o COD
var COD_OP2 = 0; // Contador da Manutencao de cliques no Operando 2 durante o COD
var TempoChangeOverDelay = 1000; // Periodo no qual o COD esta ativo
var UltimoCliqueOP = 0; // Indica qual o ultimo perando clicado
var AlternacoesOPs = [0, 0, 0, 0]; // Registra em uam array as ultimas alternacoes
		AlternacoesOPs.length=4;

var BarraReforco = true; // Oculta a Barra de Reforco (exibe ou nao as moedas)
var TotalReforcos = 0; // Soma dos reforcos recebidos para a condicao de criterio de encerramento acumulado
var TipoSessao = "Independente"; // String com o tipo da sessao (Acumulada ou Independente)

var VIs_OP1 = [];
var VIs_OP2 =  [];
var cliquesOP1 = 0;
var cliquesOP2 = 0;
var operando1 = 0;
var operando2 = 0;
var contaReforco1 = 0; // Conta o num de S+ e serve de indice da Array com os componentes da VI para o OP1
var contaReforco2 = 0; // Conta o num de S+ e serve de indice da Array com os componentes da VI para o OP1
var tempoOP1 = 0;
var tempoOP2 = 0;
var paraTudo = 0; // Para os loops, encerra a sessao

var Operando = "";

var NovamediaVI_1 = ""; // Var intermediaria para quando ocorre mudanca no componente da VI em uso para o OP1
var NovamediaVI_2 = ""; // Var intermediaria para quando ocorre mudanca no componente da VI em uso para o OP2
var aguardandoReforco_1 = 0;
var aguardandoReforco_2 = 0;

var mediaVI_max = mediaVI * 2;

var caixa1 = 0; // Reforços (S+) no operando 1
var caixa2 = 0; // Reforços (S+) no operando 1
var barraOP1_Tam = 0;
var barraOP2_Tam = 0;

var OP1travado = false; // Var booleana que indica se o OP 1 sera travado nO penultimo componente da VI
var OP2travado = false; // Var booleana que indica se o OP 2 sera travado nO penultimo componente da VI
var momentoTravaOP1;
var momentoTravaOP2;

var NomeOperando1 = "";
var NomeOperando2 = "";

var OperandoEscolhido; // Indica qual o perando escolhido 
var msgFim = ""; //Mensagem de fincalizacao da sessao