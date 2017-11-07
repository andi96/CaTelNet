<?php
	// Initialize the session
	session_start(); 
	
	require_once 'account/config.php';	
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
	
		$mesaj_ad_abonat = $mesaj_ad_abonament = "";
		$nume = $prenume = $adresa = $id_abonat = $pachet = "";
			
		if($_SERVER["REQUEST_METHOD"] == "POST") {
				
			// Div cu adaugare abonat nou (div 1)
			if(isset($_POST["submit_ad_abonat"]))
				if((empty(trim($_POST["nume_ad"]))) || (empty(trim($_POST["prenume_ad"]))) || (empty(trim($_POST["adresa_ad"])))) {
					$mesaj_ad_abonat = "Introduceti toate datele .";
				}
				else {
			
					$nume = trim($_POST["nume_ad"]);
					$prenume = trim($_POST["prenume_ad"]);
					$adresa = trim($_POST["adresa_ad"]);
							
					$sql1 = "INSERT INTO Abonati (nume , prenume , adresa) VALUES (? , ? , ? )";
							
					if($stmt = $conn->prepare($sql1)) {
					
						$stmt->bind_param("sss", $param_nume , $param_prenume , $param_adresa);

						$param_nume = $nume;
						$param_prenume = $prenume;
						$param_adresa = $adresa;
							
						if($stmt->execute())
							$mesaj_ad_abonat = "Abonat adaugat .";
						else
							$mesaj_ad_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
						
						$stmt->close();
						}
						else {
							$mesaj_ad_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
						}
				}
				
			// Div cu adaugare abonament la cablu nou (div 2)
			if(isset($_POST["submit_ad_abonament"]))
				if((empty(trim($_POST["id_abonat_ad"]))) || (!isset($_POST["pachet_ad"]))) {
					$mesaj_ad_abonament = "Introduceti toate datele .";
				}
				else {
					
					$id_abonat = trim($_POST["id_abonat_ad"]);
					$pachet = trim($_POST["pachet_ad"]);
					
					// Verificam daca exista abonatul .
					$sql21 = "SELECT id_abonat FROM Abonati WHERE id_abonat = ?";
					
					if($stmt = $conn->prepare($sql21)) {
						
						$stmt->bind_param("d", $param_id_abonat);
						
						$param_id_abonat = $id_abonat;
						
						if($stmt->execute()) {
							
							$stmt->store_result();
							
							if($stmt->num_rows == 0)
								$mesaj_ad_abonament = "Nu exista abonat cu acest id .";
							else {
								
								// Adaugam abonamentul .
								$sql22 = "INSERT INTO Cablu (id_abonat , pachet) VALUES (? , ? )";							
							
								if($stmt2 = $conn->prepare($sql22)) {
									
									$stmt2->bind_param("ds", $param_id_abonat , $param_pachet);
							
									$param_id_abonat = $id_abonat;
									$param_pachet = $pachet;
									
									if($stmt2->execute())
										$mesaj_ad_abonament = "Abonament adaugat .";
									else
										$mesaj_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
					
									$stmt2->close(); 
								}
								else 
									$mesaj_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
					
							}
							
						} 
						else
							$mesaj_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';

						$stmt->close();
					}
					else 
						$mesaj_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				}
				
		
			// Div cu ... (div 3)
			
			/////////////////////
			
		}
		$conn->close();
		
		
		// Form-urile
		echo '<p style="padding-left: 15px;"> <a href="Baza_date_Cablu.php"> Inapoi la Cauta </a> </p>';
	
		// Div cu adaugare abonat nou (div 1)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p> Adauga un abonat nou </p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				Nume: <input type="text" name="nume_ad"><br>
				Prenume: <input type="text" name="prenume_ad"><br>
				Adresa: <input type="text" name="adresa_ad"><br><br> 
				<input type="submit" name="submit_ad_abonat" value="Adauga">
				</form> <br>';
				
		echo $mesaj_ad_abonat;
				
		echo '</div>';
		
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
	
	
		// Div cu adaugare abonament la cablu nou (div 2)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p> Adauga un abonament de cablu nou </p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				ID_abonat: <input type="text" name="id_abonat_ad"><br>
				Pachet:';
						echo enumDropdown("cablu" , "pachet" , "_ad");
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_ad_abonament" value="Adauga">
				</form> <br>';
				
		echo $mesaj_ad_abonament;
				
		echo '</div>';
		
		
		// Div cu ... (div 3)
		
		/////////////////////
		
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