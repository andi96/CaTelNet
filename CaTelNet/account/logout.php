<?php	
    // Initialize the session
    session_start();
	
	
	/* ! Puteam sa sterg doar variabilele legate de sesiune si sa las sesiunea si variabilele legate de limba aleasa  sau  sa distrug sesiunea .
		 Am ales sa sterg doar variabilele legate de sesiune , pentru a pastra informatiile despre limba selectata .
	*/

	
/*  Varianta cu distrugerea sesiunii 

    // Unset all of the session variables
	session_unset();

    // Destroy the session.
    session_destroy();
*/
	
	unset($_SESSION['username']);
	unset($_SESSION['account_type']);
	
    // Redirect to login page
    header("location: ../Acasa.php");
	
	/* ! Sau putam sa nu mai fac logout.php , iar aceste 3 operatii de mai sus sa le pun sa se execute la apasarea unui buton , in header.php , in loc de :
		 <a href ='" . $full_path_href . "account/logout.php'>Sign Out</a> .
?>