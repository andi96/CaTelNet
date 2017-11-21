<?php
	// Includem fisierul cu lungimile minime si maxime pentru username , password ... .
	if(is_file($full_path_utilitar . 'min_max_lengths.php')) include_once $full_path_utilitar . 'min_max_lengths.php';

	// Includem functiile pentru modificarea limbii textelor mai lungi .
	if(is_file($full_path_utilitar . 'functii_modificare_limba.php')) include_once $full_path_utilitar . 'functii_modificare_limba.php';

	// Cautarea in BD cablu , telefon sau internet .

		///////////////////////////////////////////////////////////////////////////////////////////////////	
		/*  STRAT function cauta($tip_cautare)
			In functie de tip_cautare cautam dupa nume , prenume sau ambele .
			tip_cautare = 'np' => nume si prenume
						  'n' => doar nume
						  'p' => doar prenume
			functia returneaza mesajul dorit , pe care il punem in $mesaj .
			
			$tip_BD precizeaza in care BD sa se faca cautarea :
				$tip_BD = cablu => cauta in BD cablu
				$tip_BD = telefon => cauta in BD telefon
				$tip_BD = internet => cauta in BD internet
		*/
		function cauta($tip_BD , $tip_cautare)
		{
				global $conn , $max_length_nume_abonat , $max_length_prenume_abonat;
				$nume = $prenume = "";
				$msg = "";
	
				if(strlen(trim($_POST["nume"])) > $max_length_nume_abonat)
				{
					$msg = 'Numele trebuie sa contina maxim '  . $max_length_nume_abonat .  ' de caractere .';
					return $msg;
				}
				
				if(strlen(trim($_POST["prenume"])) > $max_length_prenume_abonat)
				{
					$msg = 'Prenumele trebuie sa contina maxim ' . $max_length_prenume_abonat . ' de caractere .';
					return $msg;
				}
				
				$nume = trim($_POST["nume"]);
				$prenume = trim($_POST["prenume"]);
						
				// Alegem tipul cautarii
				switch ($tip_cautare) {
					case 'np' :
						$sql = "SELECT * FROM abonati WHERE LOWER(nume) = LOWER(?) AND LOWER(prenume) = LOWER(?)";  // Fac cautarea indiferent de litere mari sau mici
						break;
					case 'n' :
						$sql = "SELECT * FROM abonati WHERE LOWER(nume) = LOWER(?)";
						break;
					case 'p' :
						$sql = "SELECT * FROM abonati WHERE LOWER(prenume) = LOWER(?)";
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

													
									$sql2 = "SELECT * FROM " . $tip_BD . " WHERE id_abonat = " . $row_abonati["id_abonat"];
									$result2 = $conn->query($sql2);
									
									echo '<ul style="padding-left: 30px; list-style-type: square;">';
													
									if ($result2->num_rows > 0) 
									{
										// Fiecare abonament a abonatului
										while($row_abonament = $result2->fetch_assoc()) {
										
											/* In $id_abonament vom avea un string care este id BD dorit :
												pentru BD cablu : $id_abonament = "id_cablu"
											*/
											$id_abonament = "id_" . $tip_BD;
											
											echo "<li> <p> ID_abonament : " . $row_abonament[$id_abonament] . " &nbsp , &nbsp Pachet : " . 
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
		// END function cauta($tip_cautare)
		///////////////////////////////////////////////////////////////////////////////////////////////////	
		
		
/* 	Functia cautare_BD($tip_BD) afiseaza form-ul de cautare si face cautarea in BD :
		$tip_BD = cablu => cauta in BD cablu
		$tip_BD = telefon => cauta in BD telefon
		$tip_BD = internet => cauta in BD internet
*/
function cautare_BD($tip_BD)
{
	if((strcmp($tip_BD ,"cablu") != 0) && (strcmp($tip_BD ,"telefon") != 0) && (strcmp($tip_BD ,"internet") != 0))
		return;
	
	global $conn , $lang_array , $full_path_href;
	$mesaj = "";
	
	if(isset($_SESSION['username']) && (!empty($_SESSION['username']))) 
	{
		// START Form
		echo '<p>';
		
		text_cauta_ab_serviciu($_SESSION['lang'] , $tip_BD);
		
		if($_SESSION['account_type'] == "read/write")
			echo '<a style="border: 3px solid #0000cc; margin-left: 15px; padding: 2px 4px" href="' . $full_path_href . 'Modifica_'. ucfirst($tip_BD) . '.php">' . $lang_array["MODIFICARE"] . ' BD ' . $lang_array[strtoupper($tip_BD)] . ' </a>';
		
		
		echo '</p>		
				<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
			
		echo	' " method="POST">'
				. $lang_array["NUME"] . ' : <input type="text" name="nume"><br>'
				. $lang_array["PRENUME"]. ' : <input type="text" name="prenume"><br>
				<input type="submit" name="cauta" value="'. $lang_array["CAUTA"] . '">
				</form>';
				
		echo '<br>';
		// END Form
	
		$nume = $prenume = "";
			
		if($_SERVER["REQUEST_METHOD"] == "POST") 
		{
			// Cautarea
			if(isset($_POST["cauta"]))  // daca submit-ul a venit in urma cautarii
			{
				if(!empty(trim($_POST["nume"])))
					if(!empty(trim($_POST["prenume"])))
						$mesaj = cauta($tip_BD , "np");  // Nume si prenume
					else
						$mesaj = cauta($tip_BD , "n");  // Doar nume
				else
					if(!empty(trim($_POST["prenume"])))
						$mesaj = cauta($tip_BD , "p");  // Doar prenume
					else
						$mesaj = '<p class="p_link_color"> Introduceti numele si/sau prenumele .  </p>';	
			}
		}	
		$conn->close();
		
		echo $mesaj;
	}
	else
	{
		echo '<p class="p_link_color"> ';
		text_log_pt_cautare($_SESSION['lang'] , $tip_BD); 
		echo '<a href="' . $full_path_href . 'account/login.php"> Log in </a> <a href="' . $full_path_href . 'account/register.php"> Sign up </a></p>';	
	}
	
}
?>