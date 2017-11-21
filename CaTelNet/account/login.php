<?php		
	// Includem variabilele care ne dau full path-ul spre root si utilitar .
	if(is_file('../variabile_full_path.php')) include_once '../variabile_full_path.php';
	
	// Includem fisierul cu lungimile minime si maxime pentru username , password ... .
	if(is_file($full_path_utilitar . 'min_max_lengths.php')) include_once $full_path_utilitar . 'min_max_lengths.php';

	// Initialize the session , pentru a ramane salvata limba selectata
	session_start();
	
	if(is_file($full_path_utilitar . 'account/config.php')) 
		require_once $full_path_utilitar . 'account/config.php'; 
	else
		die("Eroare");
	
	if(is_file($full_path_utilitar . 'selectare_limba.php')) include_once $full_path_utilitar . 'selectare_limba.php';
	
	// Includem functiile pentru modificarea limbii textelor mai lungi .
	if(is_file($full_path_utilitar . 'functii_modificare_limba.php')) include_once $full_path_utilitar . 'functii_modificare_limba.php';

	$username = $password = "";
	$username_err = $password_err = "";

	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if(isset($_POST["submit_log_in"]))  // daca submit-ul a venit in urma Log in - ului
		{
			// Doar daca nu avem deja eroare la username (!empty($username_err) mai facem verificarile urmatoare
			// Check if username is empty
			if(empty($username_err) && empty(trim($_POST["username"]))) {
				$username_err = 'Introduce-ti username-ul .';  //'Please enter username .';
			}
			
			// Check daca username nu are prea putine caractere , daca da atunci nu este corect , si nu dam informatii despre lungimea corecta
			if(empty($username_err) && strlen(trim($_POST["username"])) < $min_length_username) {
				$username_err = 'User inexistent .';
			}
			
			// Check daca username nu depaseste lungimea maxima , daca da atunci nu este corect , si nu dam informatii despre lungimea corecta
			if(empty($username_err) && strlen(trim($_POST["username"])) > $max_length_username) {
				$username_err = 'User inexistent .';
			} else {
				$username = trim($_POST["username"]);
			}
			
			// Check if password is empty
			if(empty($password_err) && empty(trim($_POST['password']))) {
				$password_err = 'Introduce-ti parola .';  //'Please enter your password .';
			}
			
			// Check daca parola nu are prea putine caractere , daca da atunci nu este corecta , si nu dam informatii despre lungimea corecta
			if(empty($password_err) && strlen(trim($_POST["password"])) < $min_length_password) {
				$password_err = 'Parola invalida .';
			}
			
			// Check daca parola nu depaseste lungimea maxima , daca da atunci nu este corecta , si nu dam informatii despre lungimea corecta
			if(empty($password_err) && strlen(trim($_POST["password"])) > $max_length_password) {
				$password_err = 'Parola invalida .';
			} else {
				$password = trim($_POST["password"]);
			}

			// Validate credentials
			if(empty($username_err) && empty($password_err)){
				
				// Prepare a select statement
				$sql = "SELECT username , password , account_type FROM users WHERE Username = ?";
				
				if($stmt = $conn->prepare($sql)) {
					
					// Bind variables to the prepared statement as parameters
					$stmt->bind_param("s", $param_username);

					// Set parameters
					$param_username = $username;

					// Attempt to execute the prepared statement
					if($stmt->execute()) {

						// Store result
						// Store result
						$stmt->store_result();

						// Check if username exists, if yes then verify password
						if($stmt->num_rows == 1){                    
 
							// Punem din stmt Username-ul (prima coloana din stmt) in $username , Password-ul (a doua coloana din stmt) in $hashed_password si la fel pt account_type
							$stmt->bind_result($username, $hashed_password , $account_type);

							if($stmt->fetch()) {
								if(password_verify($password, $hashed_password)) {

									// Password is correct, just save the username to the session , nu incepem o noua sesiune fiindca continuam sesiunea curenta , pentru a pasta limba setata
									//session_start();							
									$_SESSION['username'] = $username; 
									$_SESSION['account_type'] = $account_type;							
									header("location: ../Acasa.php");
								} else {

									// Display an error message if password is not valid
									$password_err = 'Parola invalida .';  //'Invalid password .';
								}

							}

						} else {

							// Display an error message if username doesn't exist
							$username_err = 'User inexistent .';  //'Invalid username .';
						}	
						
						// Close statement
						$stmt->close();
						
					} else {
						echo 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
					}
					
				}
			}

		}
	}
    // Close connection
    $conn->close();
	
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

    <meta charset="UTF-8">
	<title> Log in </title>
	
	<!-- CSS pentru login.php -->
	<style>
		body {
		background: #6699ff;
		}

		#h2_log_in {
			text-align: center;
			clear: left;
		}
		
		#div_login {
			text-align: center;
			border: solid gray 1px;
			border-radius: 5px;
			background: white;
			width: 300px;
			margin: 150px auto;
		}
		
				
		#div_login a:link , a:visited {
			color: #0000cc;
			text-decoration: none;
		}
		
		#div_login a:hover {
			color: hotpink;
		}
	</style>
</head>

<body>

<div id="div_login">


	<!-- Formul pentru selectarea limbii ////////////////////////////////////// -->
	<?php if(is_file($full_path_utilitar . 'form_selectare_limba.php')) include_once $full_path_utilitar . 'form_selectare_limba.php'; ?>

	<h2 id="h2_log_in">Log in</h2>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
		<p>
			<label> Usename : </label>
			<input type="text" name="username"> <br>
			<?php echo $username_err; ?>
		</p>
		<p>
			<label> Password : </label>
			<input type="password" name="password"> <br>
			<?php echo $password_err; ?>
		</p>
		<p>
			<input type="submit" name="submit_log_in" value="Login">
		</p>
		<p> <?php text_no_account($_SESSION['lang']); ?> <a href="register.php"> Sign up </a> </p>
		<p> <a href="../Acasa.php">  <?php text_reveniti_acasa($_SESSION['lang']); ?> </a></p>
	</form> 
</div>

</body>

</html>