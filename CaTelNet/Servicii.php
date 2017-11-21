<?php
	// Includem variabilele care ne dau full path-ul spre root si utilitar .
	if(is_file('variabile_full_path.php')) include_once 'variabile_full_path.php';
	
	
	// Initialize the session
	session_start(); 
	
	if(is_file($full_path_utilitar . 'selectare_limba.php')) include_once $full_path_utilitar . 'selectare_limba.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Servicii </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'external_css_javascript.php')) include_once $full_path_utilitar . 'external_css_javascript.php'; ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>
.lista_pentru_fiecare_seviciu {
	list-style-type:none;
	}
	
.lista_pentru_fiecare_seviciu li {
	margin-top: 10px;
	margin-left: 30px;
	}
		
.lista_interioara li {
	margin-top: 0px;
	margin-left: 40px;
	}
	
.button_grila {
	padding: 8px 20px;
	margin-left: 20px;
	font-size: 16px;
	text-align: center;
	cursor: pointer;
	outline: none;
	color: #ffffff;
	background-color: #c61aff ;
	border: none;
	border-radius: 15px 30px;
	}
	
.button_grila:hover {
	background-color: #9900cc;
	}
	
</style>

</head>


<body>

<!-- Header ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'header.php')) include_once $full_path_utilitar . 'header.php'; ?>

<div id="main">

<!-- Meniu stanga ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'meniu_stanga_si_sus.php')) include_once $full_path_utilitar . 'meniu_stanga_si_sus.php'; ?>


<!-- Continut ////////////////////////// -->
	
	<div id="content">	
		<h3> Serviciile noastre : </h3> <br>
		<ul>
			<li> 
				<p style="font-size: 1.3em; font-weight:bold;"> Cablu </p>
				<ul class="lista_pentru_fiecare_seviciu">
					<li> <p style="font-weight:600;"> Grila TV : 					
							<button class="button_grila" onclick="GrilaTVMaiMulte();"> Mai multe </button>
							<button class="button_grila" onclick="GrilaTVMaiPutine();"> Mai putine </button>
						</p>
					
						
						 
						<ol class="lista_interioara" id="lista_canale">
							<li> tvr1 </li>
							<li> tvr2 </li>
							<li> pro tv </li>
							<li> antena 1 </li>
							<li> ... </li>
						</ol>
					</li>
					
					<li> <p style="font-weight:600;"> Pachete TV : </p>
						<ol class="lista_interioara">
							<li> TV play : pachetul standard cu 20 de programe </li>
							<li> TV max play : pachetul cu decodor </li>
						</ol>
					</li>

					<li> <a href="Baza_date_Cablu.php"> Abonati Cablu </a> </li>
				</ul>
				<br> <br>
			</li>
			
			<li> 
				<p style=" font-size: 1.3em; font-weight:bold;"> Telefon </p>
				<ul class="lista_pentru_fiecare_seviciu">
					<li> <p style="font-weight:600;"> Abonamente : </p>
						<ol class="lista_interioara">
							<li> tip 1 cu 100 min nationale </li>
							<li> tip 2 cu 500 min nationale</li>
						</ol>
					</li>
					
					<li> <p style="font-weight:600;"> Tarife : </p>
						<ol class="lista_interioara">
							<li> 1 euro </li>
							<li> 3 euro </li>
						</ol>
					</li>

					<li> <a href="Baza_date_Telefon.php"> Abonati Telefon </a> </li>
				</ul>
				<br> <br>
			</li>
			
			<li> 
				<p style=" font-size: 1.3em; font-weight:bold;"> Internet </p>
				<ul class="lista_pentru_fiecare_seviciu">
					<li> <p> <span style="font-weight:600;"> fiberNET 100 </span> : Abonament de 100 Mb/s la doar 5 euro . </p>
					</li>
					
					<li> <p> <span style="font-weight:600;"> fiberNET 300 </span> : Abonament de 300 Mb/s la doar 7 euro . </p>
					</li>

					<li> <a href="Baza_date_Internet.php"> Abonati Internet </a> </li>
				</ul>
				<br> <br>
			</li>
			
			<li> <a href="Produse.php"> De asemenea se pot achizitiona o gama larga de produse </a> </li>
		</ul>
	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'footer.php')) include_once $full_path_utilitar . 'footer.php'; ?>

</body>


</html>