<?php

	////////////////////////////////////
	// Noul cod si noua parola , pentru a crea conturi cu read_write access
	$new_cod = "a3rt";
	$new_pass_cod = "qmm001";
	////////////////////////////////////
	
	// Rezultatul introduceri noului cod
	$rezultat="";

	// Connect to database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "catelnet";

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
		die("Connection failed .");
	
	$sql = "INSERT INTO cod_write_access ( cod , pass_cod ) VALUES ( ? , ?)";
	
	if($stmt = $conn->prepare($sql)) {
		
		$stmt->bind_param("ss", $param_cod , $param_pass_cod);
		
		$param_cod = $new_cod = "a3rt";
		$param_pass_cod = password_hash($new_pass_cod, PASSWORD_DEFAULT);
		
		if($stmt->execute()) 
			$rezultat = "succes";
		else
			$rezultat = "esec";
		
		$stmt->close();
	}
	else
		$rezultat = "esec";
	
	echo $rezultat;
	
?>
