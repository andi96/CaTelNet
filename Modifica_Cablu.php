<?php
	// Initialize the session
	session_start(); 
	
	require_once 'account/config.php';	
	include 'functii_modificare_BD.php';
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Modificare_Cablu </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php include 'external_css_javascript.php' ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>

</style>

</head>


<body>

<!-- Header ////////////////////////////////////// -->
<?php include 'header.php'; ?>

<div id="main">

<!-- Meniu stanga ////////////////////////////////////// -->
<?php include 'meniu_stanga_si_sus.php'; ?>

	
<!-- Continut ////////////////////////// -->
	
<div id="content">

<?php	
	if(isset($_SESSION['username']) && (!empty($_SESSION['username'])) && ($_SESSION['account_type'] == "read/write")) {
	
		$mesaj_ad_abonat = $mesaj_ad_abonament = $mesaj_st_abonat = $mesaj_st_abonament = "";
			
		if($_SERVER["REQUEST_METHOD"] == "POST") {
				
			// START PHP Div cu adaugare abonat nou (div 1)
			if(isset($_POST["submit_ad_abonat"]))
				if((empty(trim($_POST["nume_ad"]))) || (empty(trim($_POST["prenume_ad"]))) || (empty(trim($_POST["adresa_ad"]))))
					$mesaj_ad_abonat = "Introduceti toate datele .";
				else
					$mesaj_ad_abonat = adauga_abonat();

			// END PHP div 1
			////////////////////////////////////////
			
			
			// START PHP Div cu adaugare abonament la cablu nou (div 2)
			if(isset($_POST["submit_ad_abonament"]))
				if((empty(trim($_POST["id_abonat_ad"]))) || (!isset($_POST["pachet_ad"])))
					$mesaj_ad_abonament = "Introduceti toate datele .";
				else 
					$mesaj_ad_abonament = adauga_abonament();
				
			// END PHP div 2
			////////////////////////////////////////	
		
		
			// START PHP Div cu stergerea unui abonat dupa ID_abonat (div 3)
			if(isset($_POST["submit_st_abonat"]))
				if(empty(trim($_POST["id_abonat_st"])))
					$mesaj_st_abonat = "Introduceti toate datele .";
			else 	
				$mesaj_st_abonat = strege_abonat();

			// END PHP div 3
			////////////////////////////////////////
			
			// START PHP Div cu stergerea unui abonament dupa ID_abonanament (div 4)
			if(isset($_POST["submit_st_abonament"]))
				if(empty(trim($_POST["id_abonament_st"])))
					$mesaj_st_abonament = "Introduceti toate datele .";
			else 	
				$mesaj_st_abonament = strege_abonament();

			// END PHP div 4
			////////////////////////////////////////
			
		}
		$conn->close();
		
		
		////////////////////////////////////////////////////////////////////////
		// Form-urile
		echo '<p style="padding-left: 15px;"> <a href="Baza_date_Cablu.php"> Inapoi la Cauta </a> </p>';
	
		// START Div cu adaugare abonat nou (div 1)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p> Adauga un abonat nou </p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				Nume : <input type="text" name="nume_ad"><br>
				Prenume : <input type="text" name="prenume_ad"><br>
				Adresa : <input type="text" name="adresa_ad"><br><br> 
				<input type="submit" name="submit_ad_abonat" value="Adauga">
				</form> <br>';
				
		echo $mesaj_ad_abonat;
				
		echo '</div>';
		// END div 1
		//////////////////////////////////////////////////////
		
		
	///////////////////////////////////////////////////////////////////////////////////////////////////	
	// Put MySQL ENUM values into drop down select box , cu numele $column_name + $extensie_name_select
	function enumDropdown($table_name , $column_name , $extensie_name_select) 
	{
		$selectDropdown = '<select name="' . $column_name . $extensie_name_select . '" style="width: 150px;">';
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "catelnet";
	
		$conn2 = new mysqli($servername, $username, $password, $dbname);
		
		if (!($conn2->connect_error)) {
		
			$sql_enum = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '$table_name'  AND table_schema = '$dbname' AND COLUMN_NAME = '$column_name';";		
							
			if(($result = $conn2->query($sql_enum)) == TRUE)
				if ($result->num_rows > 0)
				{
					$row = $result->fetch_array();
			
					$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

					foreach($enumList as $value)
						$selectDropdown .= "<option value=\"$value\">$value</option>";
				}
				
			$conn2->close();
		}

		$selectDropdown .= "</select>";
		
		return $selectDropdown;
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	
		// START Div cu adaugare abonament la cablu nou (div 2)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p> Adauga un abonament de cablu nou </p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				ID_abonat : <input type="text" name="id_abonat_ad"><br>
				Pachet :';
						echo enumDropdown("cablu" , "pachet" , "_ad");
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_ad_abonament" value="Adauga">
				</form> <br>';
				
		echo $mesaj_ad_abonament;
				
		echo '</div>';
		
		// END div 2 
		//////////////////////////////////////////////////////
		
		
		// START Div cu stergerea unui abonat dupa ID_abonat (div 3)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p> Sterge un abanat dupa ID_abonat </p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				ID_abonat : <input type="text" name="id_abonat_st"><br>';
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_st_abonat" value="Sterge">
				</form> <br>';
				
		echo $mesaj_st_abonat;
				
		echo '</div>';
				
		// END div 3 
		//////////////////////////////////////////////////////
		
		
		// START Div cu stergerea unui abonament dupa ID_abonament (div 4)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p> Sterge un abanament de cablu dupa ID_abonament </p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				ID_cablu : <input type="text" name="id_abonament_st"><br>';
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_st_abonament" value="Sterge">
				</form> <br>';
				
		echo $mesaj_st_abonament;
				
		echo '</div>';
				
		// END div 4 
		//////////////////////////////////////////////////////
		
		
	}
	else
		echo '<p class="p_link_color"> Logativa cu drepturi de read/write pentru a modifica baza de date cu abonatii de Cablu .</p>';	
	
?>

	
<!-- End Continut ////////////////////////// -->
	
</div>

</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>