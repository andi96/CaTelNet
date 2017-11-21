function SiglaonHover()
{
    $("#header").css("background","#0080ff");
	$("#header h1").css("color","#003366");
	$("#header h2").css("color","#003366");
}

function SiglaoffHover()
{
    $("#header").css("background","#3399ff");
	$("#header h1").css("color","black");
	$("#header h2").css("color","black");
}

function GrilaTVMaiMulte()
{
	$("#lista_canale").replaceWith("<ol class='lista_interioara' id='lista_canale'> \
										<li> tvr1 </li> \
										<li> tvr2 </li> \
										<li> pro tv </li> \
										<li> antena 1 </li> \
										<li> prima </li> \
										<li> canal d </li> \
										<li> catoon network </li> \
										<li> disney channel </li> \
										<li> pro x </li> \
										<li> eurosport </li> \
										<li> eurosport 2 </li> \
										<li> kiss tv </li> \
										<li> u tv </li> \
										<li> muzic channel </li> \
										<li> hit </li> \
										<li> mezzo </li> \
										<li> history tv </li> \
										<li> dicovery </li> \
										<li> animal planet </li> \
										<li> tv paprika </li> \
									</ol>");
}

function GrilaTVMaiPutine()
{
	$("#lista_canale").replaceWith("<ol class='lista_interioara' id='lista_canale'> \
										<li> tvr1 </li> \
										<li> tvr2 </li> \
										<li> pro tv </li> \
										<li> antena 1 </li> \
										<li> ... </li> \
									</ol>");
}									