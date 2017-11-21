<?php
	// Cautarea in BD cablu
	
	// Includem variabilele care ne dau full path-ul spre root si utilitar .
	if(is_file('variabile_full_path.php')) include_once 'variabile_full_path.php';

	// Initialize the session
	session_start(); 
	
	if(is_file($full_path_utilitar . 'account/config.php')) 
		require_once $full_path_utilitar . 'account/config.php'; 
	else
		die("Eroare");	
	
	if(is_file($full_path_utilitar . 'selectare_limba.php')) include_once $full_path_utilitar . 'selectare_limba.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Baza_date_cablu </title>

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

<?php	
	
	if(is_file($full_path_utilitar . 'cautare_BD_uri.php')) 
	{
		include_once $full_path_utilitar . 'cautare_BD_uri.php'; 
	
		cautare_BD("cablu");
	}
?>
	
<!-- End Continut ////////////////////////// -->
	
</div>

</div>

<!-- Footer ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'footer.php')) include_once $full_path_utilitar . 'footer.php'; ?>

</body>


</html>