<div id="header" class="clearfix">
	<img id="sigla" src="<?php echo $full_path_utilitar_href;?>poze/Paladin_Logo.jpg" alt="Emblema" onmouseover="SiglaonHover();" onmouseout="SiglaoffHover();">
	
	
<!-- Formul pentru selectarea limbii ////////////////////////////////////// -->
<?php
	// Daca padding-ul div-ului cu formul pentru selectarea limbii e mai mare de 4px , atunci va intra in conflict cu <h1> CaTelNet </h1> , de mai jos si il va muta mai la dreapta .
	if(is_file($full_path_utilitar . 'form_selectare_limba.php')) include_once $full_path_utilitar . 'form_selectare_limba.php';
?>
	
<?php	
	if(isset($_SESSION['username']) && (!empty($_SESSION['username']))) 
		echo "<p class='p_login'>" . $lang_array['SALUT'] . " " . $_SESSION["username"] . "<a href ='" . $full_path_href . "account/logout.php'>Sign Out</a> </p>";
	else
		echo "<p class='p_login'> <a href='" . $full_path_href . "account/login.php'> Log in </a> <a href='" . $full_path_href . "account/register.php'> Sign up </a> </p>";
?>
	<h1> CaTelNet </h1>
	<h2> <?php echo $lang_array['CABLU']; ?> , <?php echo $lang_array['TELEFON']; ?> , <?php echo $lang_array['INTERNET']; ?></h2>
	
</div>