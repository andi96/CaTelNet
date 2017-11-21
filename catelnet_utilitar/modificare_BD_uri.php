<?php
	// Modificarea (adaugarea si stergerea) in BD cablu , telefon sau internet .
					
	// Includem functiile adauga_abonat() , adauga_abonament() , strege_abonat() si strege_abonament()
	if(is_file($full_path_utilitar . 'functii_modificare_BD.php')) 
		include_once $full_path_utilitar . 'functii_modificare_BD.php';
	else
		die("Eroare");
	
	// Includem functiile pentru modificarea limbii textelor mai lungi .
	if(is_file($full_path_utilitar . 'functii_modificare_limba.php')) include_once $full_path_utilitar . 'functii_modificare_limba.php';
		
	
	/* 	Put MySQL ENUM values into drop down select box , cu numele $column_name + $extensie_name_select .
		Folosim la drop-down list pentru selectarea pachetului .
		START enumDropdown
	*/
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
	// END enumDropdown
	///////////////////////////////////////////////////////////////////////////////////////////////////
	
	
/* 	Functia modificare_BD($tip_BD) afiseaza form-urile de modificare si face modificarea in BD :
	$tip_BD = cablu => BD cablu
	$tip_BD = telefon => BD telefon
	$tip_BD = internet => BD internet
*/
function modificare_BD($tip_BD)
{
	global $lang_array , $full_path_href;
	
	if((strcmp($tip_BD ,"cablu") != 0) && (strcmp($tip_BD ,"telefon") != 0) && (strcmp($tip_BD ,"internet") != 0))
		return;
	
	global $conn;
	
	if(isset($_SESSION['username']) && (!empty($_SESSION['username'])) && ($_SESSION['account_type'] == "read/write")) 
	{
		$mesaj_ad_abonat = $mesaj_ad_abonament = $mesaj_st_abonat = $mesaj_st_abonament = "";
			
		if($_SERVER["REQUEST_METHOD"] == "POST") {
				
			// START PHP Div cu adaugare abonat nou (div 1)
			if(isset($_POST["submit_ad_abonat"]))  // daca submit-ul a venit in urma apasarii butonului de submit din div 1
				if((empty(trim($_POST["nume_ad"]))) || (empty(trim($_POST["prenume_ad"]))) || (empty(trim($_POST["adresa_ad"]))))
					$mesaj_ad_abonat = "Introduceti toate datele .";
				else
					$mesaj_ad_abonat = adauga_abonat();
			// END PHP div 1
			////////////////////////////////////////
			
			
			// START PHP Div cu adaugare abonament la cablu/telefon/internet nou (div 2)
			if(isset($_POST["submit_ad_abonament"]))  // daca submit-ul a venit in urma apasarii butonului de submit din div 2
				if((empty(trim($_POST["id_abonat_ad"]))) || (!isset($_POST["pachet_ad"])))
					$mesaj_ad_abonament = "Introduceti toate datele .";
				else 
					$mesaj_ad_abonament = adauga_abonament($tip_BD);	
			// END PHP div 2
			////////////////////////////////////////	
		
		
			// START PHP Div cu stergerea unui abonat dupa ID_abonat (div 3)
			if(isset($_POST["submit_st_abonat"]))  // daca submit-ul a venit in urma apasarii butonului de submit din div 3
				if(empty(trim($_POST["id_abonat_st"])))
					$mesaj_st_abonat = "Introduceti toate datele .";
			else 	
				$mesaj_st_abonat = strege_abonat();
			// END PHP div 3
			////////////////////////////////////////
			
			// START PHP Div cu stergerea unui abonament dupa ID_abonanament (div 4)
			if(isset($_POST["submit_st_abonament"]))  // daca submit-ul a venit in urma apasarii butonului de submit din div 4
				if(empty(trim($_POST["id_abonament_st"])))
					$mesaj_st_abonament = "Introduceti toate datele .";
			else 	
				$mesaj_st_abonament = strege_abonament($tip_BD);
			// END PHP div 4
			////////////////////////////////////////
			
		}
		$conn->close();
		
		
		////////////////////////////////////////////////////////////////////////
		// Form-urile
		echo '<p style="padding-left: 15px;"> <a href="' . $full_path_href . 'Baza_date_' . $tip_BD . '.php"> ';

		text_inapoi_la_cauta($_SESSION['lang']);

		echo '</a> </p>';
	
		// START Div cu adaugare abonat nou (div 1)
		echo '<div class="div_pt_modificat_bd">';
		
		echo '<p>';

		text_ad_abonat($_SESSION['lang']);
		
		echo '</p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">'
				. $lang_array["NUME"] . ' : <input type="text" name="nume_ad"><br>'
				. $lang_array["PRENUME"] . ' : <input type="text" name="prenume_ad"><br>'
				. $lang_array["ADRESA"] . ' : <input type="text" name="adresa_ad"><br><br> 
				<input type="submit" name="submit_ad_abonat" value="'. $lang_array["ADAUGA"] . '">
				</form> <br>';
				
		echo $mesaj_ad_abonat;
				
		echo '</div>';
		// END div 1
		//////////////////////////////////////////////////////
		
	
		// START Div cu adaugare abonament la cablu/telefon/internet nou (div 2)
		echo '<div class="div_pt_modificat_bd">';

		echo '<p>';
		
		text_ad_serviciu($_SESSION['lang'] , $tip_BD);
		
		echo '</p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">'
				. $lang_array["ID_ABONAT"] . ' : <input type="text" name="id_abonat_ad"><br>'
				. $lang_array["PACHET"] . ' : ';
						echo enumDropdown($tip_BD , "pachet" , "_ad");
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_ad_abonament" value="'. $lang_array["ADAUGA"] . '">
				</form> <br>';
				
		echo $mesaj_ad_abonament;
				
		echo '</div>';
		// END div 2 
		//////////////////////////////////////////////////////
		
		
		// START Div cu stergerea unui abonat dupa ID_abonat (div 3)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p>';

		text_st_abonat($_SESSION['lang']);
		
		echo '</p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">'
				. $lang_array["ID_ABONAT"] . ' : <input type="text" name="id_abonat_st"><br>';
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_st_abonat" value="'. $lang_array["STERGE"] . '">
				</form> <br>';
				
		echo $mesaj_st_abonat;
				
		echo '</div>';		
		// END div 3 
		//////////////////////////////////////////////////////
		
		
		// START Div cu stergerea unui abonament dupa ID_abonament (div 4)
		echo '<div class="div_pt_modificat_bd">';
		echo '<p>';
		
		text_st_serviciu($_SESSION['lang'] , $tip_BD);
		
		echo '</p> <br>';
		
		echo '<form action="';
				
		echo htmlspecialchars($_SERVER["PHP_SELF"]);
				
		echo	' " method="POST">
				ID_' . strtolower($lang_array[strtoupper($tip_BD)]) . ' : <input type="text" name="id_abonament_st"><br>';
				
		echo 	'<br> <br> <br>';		
		echo	'<input type="submit" name="submit_st_abonament" value="'. $lang_array["STERGE"] . '">
				</form> <br>';
				
		echo $mesaj_st_abonament;
				
		echo '</div>';		
		// END div 4 
		//////////////////////////////////////////////////////
			
	}
	else
	{
		echo '<p class="p_link_color"> ';
		text_log_rw_pt_modificare($_SESSION['lang'] , $tip_BD); 
		echo '</p>';
	}
	
}
?>