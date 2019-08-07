// '===== Bloquear botão direito do mouse =====
var mensagem="";
function clickIE() {if (document.all) {(mensagem);return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(mensagem);return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")

//'===== Bloquear seleção de texto do site =====
//Para evitar que o usuário selecione o texto exposto na página,
//inclua na TAG BODY o código (onselectstart="return false").
//OBS: Também funciona em ASP e HTML
//EX:
//<Body onselectstart="return false">
// --> 