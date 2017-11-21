<?php
	// Initialize the session
	session_start(); 
	
	require_once 'account/config.php';	
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Baza_date_Cablu </title>

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

	$mesaj = "";
	
	if(isset($_SESSION['username']) && (!empty($_SESSION['username']))) {
		echo 	'<p> Baza date cu abonatii de Cablu';
		
		if($_SESSION['account_type'] == "read/write")
			echo '<a style="border: 3px solid #0000cc; margin-left: 15px; padding: 2px 4px" href="Modifica_Cablu.php"> Modifica BD Cablu </a>';
		
		
		echo '</p>		
				<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				Nume : <input type="text" name="nume"><br>
				Prenume : <input type="text" name="prenume"><br>
				<input type="submit" value="Cauta">
				</form>';
				
		echo '<br>';
			

		///////////////////////////////////////////////////////////////////////////////////////////////////	
		/*  In functie de tip_cautare cautam dupa nume , prenume sau ambele .
			tip_cautare = 'np' => nume si prenume
						  'n' => doar nume
						  'p' => doar prenume
			functia returneaza mesajul dirit , oe care il punem in $mesaj .
		*/
		function cauta($tip_cautare)
		{
				global $conn;
				$nume = $prenume = "";
				$msg = "";
	
				$nume = trim($_POST["nume"]);
				$prenume = trim($_POST["prenume"]);
						
				// Alegem tipul cautarii
				switch ($tip_cautare) {
					case 'np' :
						$sql = "SELECT * FROM abonati WHERE nume = ? AND prenume = ?";
						break;
					case 'n' :
						$sql = "SELECT * FROM abonati WHERE nume = ?";
						break;
					case 'p' :
						$sql = "SELECT * FROM abonati WHERE prenume = ?";
						break;	
					default : 
						return $msg;  // return "";
				}
						
				if($stmt = $conn->prepare($sql))
				{
					// Alegem tipul cautarii
					switch ($tip_cautare) {
					case 'np' :
						$stmt->bind_param("ss", $param_nume , $param_prenume);
						break;
					case 'n' :
						$stmt->bind_param("s", $param_nume);
						break;
					case 'p' :
						$stmt->bind_param("s", $param_prenume);
						break;
					}
					
					// Dintre $param_nume si $param_prenume folosim doar pe cei care ne intereseaza
					$param_nume = $nume;
					$param_prenume = $prenume;
						
				
					if($stmt->execute()) 
					{
						/* Am folosit SELECT * si get_result() , pentru ca sa avem o intreaga linie in $row_abonati , din care alegem ce vrem ,
						de exemplu created_at il putem afisa sau nu .
							La fel pentru selectarea abonamentelor .
						*/
						$result = $stmt->get_result();
						
						if($result->num_rows > 0)
						{
							echo '<ol>';							
							
							// Fiecare abonat
							while($row_abonati = $result->fetch_assoc()) 
							{
								echo "<li> <p> ID_abonat : " . $row_abonati["id_abonat"] . " &nbsp , &nbsp Nume : " . $row_abonati["nume"] . 
								" &nbsp , &nbsp  Prenume :  " . $row_abonati["prenume"] .  " &nbsp , &nbsp Adresa :  " . $row_abonati["adresa"] ."</p>";

													
									$sql2 = "SELECT * FROM cablu WHERE id_abonat = " . $row_abonati["id_abonat"];
									$result2 = $conn->query($sql2);
									
									echo '<ul style="padding-left: 30px; list-style-type: square;">';
													
									if ($result2->num_rows > 0) 
									{
										// Fiecare abonament a abonatului
										while($row_abonament = $result2->fetch_assoc()) {
											
											echo "<li> <p> ID_abonament : " . $row_abonament["id_cablu"] . " &nbsp , &nbsp Pachet : " . 
											$row_abonament["pachet"] . " &nbsp , &nbsp Data : " . $row_abonament["created_at"] . " </p> </li>";
										}
									}
									else 
										echo "<li> 0 abonamente </li>";
									
									echo '</ul>';	
								echo '<br> </li>';	
								
							}
								
							echo '</ol>';
	
						} else {
							$msg = "Abonat inexistent .";
						}	
							
					}
					else
						$msg =  'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				
							
					$stmt->close();	
				}	
				
		return $msg;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////	
	
	
		$nume = $prenume = "";
			
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			// Cautarea
			if(!empty(trim($_POST["nume"])))
				if(!empty(trim($_POST["prenume"])))
					$mesaj = cauta("np");  // Nume si prenume
				else
					$mesaj = cauta("n");  // Doar nume
			else
				if(!empty(trim($_POST["prenume"])))
					$mesaj = cauta("p");  // Doar prenume
				else
					$mesaj = '<p class="p_link_color"> Introduceti numele si/sau prenumele .  </p>';	
		}	
		$conn->close();
		
		echo $mesaj;
	}
	else
		echo '<p class="p_link_color"> Logativa pentru a vedea baza de date cu abonatii de Cablu . <a href="account/login.php"> Log in </a> <a href="account/register.php"> Sign up </a></p>';	
	
?>
	
<!-- End Continut ////////////////////////// -->
	
</div>

</div>

<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>
