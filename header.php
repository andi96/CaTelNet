<div id="header" class="clearfix">
	<img id="sigla" src="poze/Paladin_Logo.jpg" alt="Emblema" onmouseover="SiglaonHover();" onmouseout="SiglaoffHover();">
	
<?php	
	if(isset($_SESSION['username']) && (!empty($_SESSION['username']))) 
		echo "<p class='p_login'> Salut " . $_SESSION["username"] . "<a href = 'account/logout.php'>Sign Out</a> </p>";
	else
		echo "<p class='p_login'> <a href='account/login.php'> Log in </a> <a href='account/register.php'> Sign up </a> </p>";
?>
	
	<h1> CaTelNet </h1>
	<h2> Cablu , Telefon , Internet </h2>		
</div>