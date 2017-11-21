<?php
	// Initialize the session
	session_start(); 
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Produse </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php include 'external_css_javascript.php' ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>
.produs {
	float: left;
	width: 200px;
	height: 200px;
	border: 2px solid #0000cc;
	margin: 5px;
	text-align: center;
	}
	
.produs img	{
	width: 150px;
	height: 150px;
	}
	
</style>

<!-- Lightbox -->
<link href="lightbox/lightbox.css" rel="stylesheet">
<script src="lightbox/lightbox.js"></script>

</head>


<body>

<!-- Header ////////////////////////////////////// -->
<?php include 'header.php'; ?>

<div id="main">

<!-- Meniu stanga ////////////////////////////////////// -->
<?php include 'meniu_stanga_si_sus.php'; ?>


<!-- Continut ////////////////////////// -->
	
	<div id="content" class="clearfix">	
		<p> Pentru comenzi si detalii sunati la : 0744 710 310 </p> <br>
		
		<div class="produs">
		<a href="poze/produse/1. TP-Link SG108.jpg" data-lightbox="prod1" > <img src="poze/produse/1. TP-Link SG108.jpg" alt="1. Switch TP-Link SG108"> </a>
		<p> 1. Switch TP-Link SG108 </p>
		<p> Pret : 49 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/2. D-Link DGS108.jpg" data-lightbox="prod2" > <img src="poze/produse/2. D-Link DGS108.jpg" alt="2. D-Link DGS108"> </a>
		<p> 2. Switch D-Link DGS108 </p>
		<p> Pret : 50 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/3. TP-Link SF108d.jpg" data-lightbox="prod3" > <img src="poze/produse/3. TP-Link SF108d.jpg" alt="3. TP-Link SF108d"> </a>
		<p> 3. Switch TP-Link SF108d </p>
		<p> Pret : 120 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/4. Router Tenda 300.jpg" data-lightbox="prod4" > <img src="poze/produse/4. Router Tenda 300.jpg" alt="4. Router Tenda 300"> </a>
		<p> 4. Router Tenda 300 </p>
		<p> Pret : 180 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/5. Router TP-Link 480.jpg" data-lightbox="prod5" > <img src="poze/produse/5. Router TP-Link 480.jpg" alt="5. Router TP-Link 480"> </a>
		<p> 5. Router TP-Link 480 </p>
		<p> Pret : 190 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/6. Router TP-link T+.jpg" data-lightbox="prod6" > <img src="poze/produse/6. Router TP-link T+.jpg" alt="6. Router TP-link T+"> </a>
		<p> 6. Router TP-link T+ </p>
		<p> Pret : 70 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/7. Panasonic KX 500.jpg" data-lightbox="prod7" > <img src="poze/produse/7. Panasonic KX 500.jpg" alt="7. Panasonic KX 500"> </a>
		<p> 7. Panasonic KX 500 </p>
		<p> Pret : 90 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/8. Panasonic KX1611.jpg" data-lightbox="prod8" > <img src="poze/produse/8. Panasonic KX1611.jpg" alt="8. Panasonic KX1611"> </a>
		<p> 8. Panasonic KX1611 </p>
		<p> Pret : 40 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/9. Panasonic KX6811.jpg" data-lightbox="prod9" > <img src="poze/produse/9. Panasonic KX6811.jpg" alt="9. Panasonic KX6811"> </a>
		<p> 9. Panasonic KX6811 </p>
		<p> Pret : 120 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/10. Orion DLed 61cm.jpg" data-lightbox="prod10" > <img src="poze/produse/10. Orion DLed 61cm.jpg" alt="10. Orion DLed 61cm"> </a>
		<p> 10. Televizor Orion DLed</p>
		<p> Pret : 449 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/11. Blaupunkt 23.jpg" data-lightbox="prod11" > <img src="poze/produse/11. Blaupunkt 23.jpg" alt="11. Blaupunkt 23"> </a>
		<p> 10. Televizor Orion DLed </p>
		<p> Pret : 749 Lei </p>
		</div>
		
		<div class="produs">
		<a href="poze/produse/12. Smart Tech 1919.jpg" data-lightbox="prod12" > <img src="poze/produse/12. Smart Tech 1919.jpg" alt="12. Smart Tech 1919"> </a>
		<p> 12. Televizor Smart Tech 1919 </p>
		<p> Pret : 349 Lei </p>
		</div>
		
	</div>
	
<!-- End Continut ////////////////////////// -->

</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>
