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
 
<title> CaTelNet Suport </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'external_css_javascript.php')) include_once $full_path_utilitar . 'external_css_javascript.php'; ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>

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
		
		<pre style="font-family: 'Times New Roman', Times, serif;"> 
Se configureaza conexiunea PPOE cu user name si parola primita de la provider.
	
Telefon: 0355 501 501
Email: catelnet@tvcatelnet.ro
		</pre>
		
	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'footer.php')) include_once $full_path_utilitar . 'footer.php'; ?>

</body>


</html>