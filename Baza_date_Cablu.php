<?php
	// Initialize the session
	session_start(); 
	
	require_once 'account/config.php';	
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
 
<title> CaTelNet </title>

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
	if(isset($_SESSION['username']) && (!empty($_SESSION['username']))) {
		echo 	'<p> Baza date cu abonatii de Cablu </p>
				
				<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				Nume: <input type="text" name="nume"><br>
				Prenume: <input type="text" name="prenume"><br>
				<input type="submit" value="Cauta">
				</form>';
	
		$nume = $prenume = "";
			
		if($_SERVER["REQUEST_METHOD"] == "POST") {
					
			if(empty(trim($_POST["nume"])) || empty(trim($_POST["prenume"]))) {
				echo '<p class="p_link_color"> Introduceti numele si prenumele .  </p>';
			} 
			else {
				$nume = trim($_POST["nume"]);
				$prenume = trim($_POST["prenume"]);
						
				$sql = "SELECT id_abonat , nume , prenume FROM abonati WHERE nume = ? AND prenume = ?";
						
				if($stmt = $conn->prepare($sql)) {
				
					$stmt->bind_param("ss", $param_nume , $param_prenume);

					$param_nume = $nume;
					$param_prenume = $prenume;
						
				
					if($stmt->execute()) {

						$stmt->store_result();
				 
						if($stmt->num_rows > 0){                    
						
							$stmt->bind_result($id_gasit , $nume_gasit , $prenume_gasit);	
							
							while($row = $stmt->fetch()) {
								echo "<p> id : " . $id_gasit . " nume :  " . $nume_gasit . " prenume : " . $prenume_gasit . "</p> <br>";
								
								/////////////////////   De facut frumossssssssssssssssssssssssssssssssssssssss .
								
								
								$sql2 = "SELECT id_cablu , pachet , abonati.nume , abonati.prenume FROM cablu JOIN abonati ON abonati.id_abonat=cablu.id_abonat  WHERE abonati.id_abonat=" . $id_gasit;
								$result = $conn->query($sql2);
											
											if ($result->num_rows > 0) {
												// output data of each row
											while($row = $result->fetch_assoc()) {
												echo "id_cablu: " . $row["id_cablu"]. " - pachet: " . $row["pachet"]. " nume " . $row["nume"]. " prenume " . $row["prenume"].     "<br>";
											}
										} else {
											echo "0 results";
										}
										
										
								/////////////////////////////////////	De facut frumossssssssssssssssssssssssssssssssssssssss .
							}
						} else {
							echo "Abonat inexistent .";
						}	
					}
					else {
						echo 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
					}
							
					$stmt->close();
				}
			}
				
		$conn->close();
		}	
	}
	else
		echo '<p class="p_link_color"> Logativa pentru a vedea baza de date cu abonatii de Cablu . <a href="account/login.php"> Log in </a> <a href="account/register.php"> Sign up </a></p>';	
	
?>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>