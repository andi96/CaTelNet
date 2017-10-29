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
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "CaTelNet";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		
		
		$sql = "SELECT ID_cablu, ID_abonat, Pachet FROM Cablu WHERE ID_abonat=" . $_POST["ID_abonat"];
		
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo "ID_cablu : " . $row["ID_cablu"]. "       ID_abonat : " . $row["ID_abonat"]. "     Pachet : " . $row["Pachet"]. "<br>";
			}
		} else {
			echo "0 results";
		}
		$conn->close();
		?>
	
	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php include 'footer.php'; ?>

</body>


</html>