<?php	
		// START Functie pentru PHP Div cu adaugare abonat nou (div 1)
		function adauga_abonat()
		{
			global $conn;
			$msg_ad_abonat = "";
			
			$nume = trim($_POST["nume_ad"]);
			$prenume = trim($_POST["prenume_ad"]);
			$adresa = trim($_POST["adresa_ad"]);
							
			$sql1 = "INSERT INTO Abonati (nume , prenume , adresa) VALUES (? , ? , ? )";
							
			if(!($stmt = $conn->prepare($sql1)))
			{
				$msg_ad_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_ad_abonat;
			}				
					
			$stmt->bind_param("sss", $param_nume , $param_prenume , $param_adresa);

			$param_nume = $nume;
			$param_prenume = $prenume;
			$param_adresa = $adresa;
							
			if(!($stmt->execute()))
			{
				$msg_ad_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_ad_abonat;
			}				
				
			$msg_ad_abonat = "Abonat adaugat .";
			
			$stmt->close();
			
			return $msg_ad_abonat;			
		}
		// END Functie pentru PHP div 1
		////////////////////////////////////////
		
		// START Functie pentru PHP Div cu adaugare abonament la cablu nou (div 2)
		function adauga_abonament()
		{
			global $conn;
			$msg_ad_abonament = "";
			
			$id_abonat = trim($_POST["id_abonat_ad"]);
			$pachet = trim($_POST["pachet_ad"]);
					
			// Verificam daca exista abonatul .
			$sql21 = "SELECT id_abonat FROM Abonati WHERE id_abonat = ?";
					
			if(!($stmt = $conn->prepare($sql21)))
			{
				$msg_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_ad_abonament;
			}
						
			$stmt->bind_param("d", $param_id_abonat);
						
			$param_id_abonat = $id_abonat;
						
			if(!($stmt->execute()) )
			{
				$msg_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_ad_abonament;
			}	
							
			$stmt->store_result();
							
			if($stmt->num_rows == 0)
			{
				$msg_ad_abonament = "Nu exista abonat cu acest id .";
				return $msg_ad_abonament;
			}
							
			// Adaugam abonamentul .
			$sql22 = "INSERT INTO Cablu (id_abonat , pachet) VALUES (? , ? )";							
							
			if(!($stmt2 = $conn->prepare($sql22)))
			{
				$msg_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_ad_abonament;
			}	
										
			$stmt2->bind_param("ds", $param_id_abonat , $param_pachet);
							
			$param_id_abonat = $id_abonat;
			$param_pachet = $pachet;
									
			if(!($stmt2->execute()))
			{
				$msg_ad_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_ad_abonament;
			}	
				
			$msg_ad_abonament = "Abonament adaugat .";
			
			$stmt2->close(); 
			$stmt->close();
			
			return $msg_ad_abonament;
		}
		// END Functie pentru PHP div 2
		////////////////////////////////////////

		// START Functie pentru PHP Div cu stergerea unui abonat dupa ID_abonat (div 3)
		function strege_abonat()
		{
			global $conn;
			$msg_st_abonat="";
			
			$id_abonat = trim($_POST["id_abonat_st"]);
				
			// Verificam daca exista abonatul .
			$sql31 = "SELECT id_abonat FROM Abonati WHERE id_abonat = ?";
			
			if(!($stmt = $conn->prepare($sql31))) 
			{
				$msg_st_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonat;
			}
			
			$stmt->bind_param("d", $param_id_abonat);
						
			$param_id_abonat = $id_abonat;
						
			if(!($stmt->execute())) 
			{
				$msg_st_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonat;
			}
			
			$stmt->store_result();
							
			if($stmt->num_rows == 0)
			{
				$msg_st_abonat = "Nu exista abonat cu acest id .";
				return $msg_st_abonat;
			}
			
			// Stergem
			$sql32 = "DELETE FROM abonati WHERE id_abonat = " . $id_abonat;
								
			if(!($stmt2 = $conn->prepare($sql32))) 
			{
				$msg_st_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonat;
			}
			
			if(!($stmt2->execute())) 
			{							
				$msg_st_abonat = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonat;
			}	

			$msg_st_abonat = 'Abonat sters .';
			
			$stmt2->close(); 
			$stmt->close();
			
			return $msg_st_abonat;
		}
		// END Functie pentru PHP div 3
		////////////////////////////////////////
		
		// START Functie pentru PHP Div cu stergerea unui abonament dupa ID_abonament (div 4)
		function strege_abonament()
		{
			global $conn;
			$msg_st_abonament="";
			
			$id_abonament = trim($_POST["id_abonament_st"]);
				
			// Verificam daca exista abonamentul .
			$sql41 = "SELECT id_cablu FROM cablu WHERE id_cablu = ?";
			
			if(!($stmt = $conn->prepare($sql41))) 
			{
				$msg_st_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonament;
			}
			
			$stmt->bind_param("d", $param_id_abonament);
						
			$param_id_abonament = $id_abonament;
						
			if(!($stmt->execute())) 
			{
				$msg_st_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonament;
			}
			
			$stmt->store_result();
							
			if($stmt->num_rows == 0)
			{
				$msg_st_abonament = "Nu exista abonament cu acest id .";
				return $msg_st_abonament;
			}
			
			// Stergem
			$sql42 = "DELETE FROM cablu WHERE id_cablu = " . $id_abonament;
								
			if(!($stmt2 = $conn->prepare($sql42))) 
			{
				$msg_st_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonament;
			}
			
			if(!($stmt2->execute())) 
			{							
				$msg_st_abonament = 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
				return $msg_st_abonament;
			}	

			$msg_st_abonament = 'Abonament sters .';
			
			$stmt2->close(); 
			$stmt->close();
			
			return $msg_st_abonament;
		}
		// END Functie pentru PHP div 4
		////////////////////////////////////////
		
?>