<?php
	// Creare conturi cu read access 
	
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

	// Define variables and initialize with empty values
	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";

	// Processing form data when form is submitted	
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if(isset($_POST["submit_sign_up"]))  // daca submit-ul a venit in urma Sign up - ului
		{
			// Validate username
			// Doar daca nu avem deja eroare la username (!empty($username_err) mai facem verificarile urmatoare
			if(empty($username_err) && empty(trim($_POST["username"]))) {
				$username_err = 'Introduce-ti username-ul .';  //'Please enter username .';
			} 
				
			if(empty($username_err) && strlen(trim($_POST['username'])) < $min_length_username) {
					$username_err = 'Username-ul trebuie sa contina minim ' . $min_length_username . ' caractere .';  //"Username-ul must have atleast 6 characters.";
			}

			if(empty($username_err) && strlen(trim($_POST['username'])) > $max_length_username) {
					$username_err = 'Username-ul trebuie sa contina maxim ' . $max_length_username . ' caractere .';  //"Username-ul must have atleast 6 characters.";
			}

			if(empty($username_err))
			{	
					// Prepare a select statement
					$sql = "SELECT id FROM users WHERE username = ?";
					
					if($stmt = $conn->prepare($sql)) {

						// Bind variables to the prepared statement as parameters
						$stmt->bind_param("s", $param_username);

						// Set parameters
						$param_username = trim($_POST["username"]);

						// Attempt to execute the prepared statement
						if($stmt->execute()){

							// store result
							$stmt->store_result();

							if($stmt->num_rows >= 1) {
								$username_err = 'Username deja existent .';  //"This username is already taken.";
						} else {
							$username = trim($_POST["username"]);
						}

						} else {
							echo 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
						}
						
						// Close statement
						$stmt->close();
					}	
			}

			// Validate password
			if(empty($password_err) && empty(trim($_POST['password']))) {
				$password_err = 'Introduce-ti parola .';  //'Please enter your password .';"Please enter a password.";     
			}
				
			if(empty($password_err) && strlen(trim($_POST['password'])) < $min_length_password) {
				$password_err = 'Parola trebuie sa contina minim ' . $min_length_password . ' caractere .';  //"Password must have atleast 7 characters.";
			} 
			
			if(empty($password_err) && strlen(trim($_POST['password'])) > $max_length_password) {
				$password_err = 'Parola trebuie sa contina maxim ' . $max_length_password . ' caractere .';  //"Password must have atleast 7 characters.";
			} else {		
				$password = trim($_POST['password']);
			}

			if(empty($password_err))
			{
				// Validate confirm password
				if(empty($confirm_password_err) && empty(trim($_POST["confirm_password"]))) {
					$confirm_password_err = 'Confirmati parola .';  //'Please confirm password.';     
				} 
				
				if(empty($confirm_password_err) && strlen(trim($_POST['confirm_password'])) < $min_length_password) {
					$confirm_password_err = 'Parola confirmata nu se potriveste .';
				} 
				
				if(empty($confirm_password_err) && strlen(trim($_POST['confirm_password'])) > $max_length_password) {
					$confirm_password_err = 'Parola confirmata nu se potriveste .';
				} else {		
					$confirm_password = trim($_POST['confirm_password']);
				}
			
				if(empty($confirm_password_err))
				// Doar daca parola este suficient de lunga testam egalitatea cu $confirm_password
					if(strcmp($password , $confirm_password) != 0)
						$confirm_password_err = 'Parola confirmata nu se potriveste .';  //'Password did not match.';
				
			}

			// Check input errors before inserting in database
			if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
		
				// Prepare an insert statement
				$sql = "INSERT INTO users (username, password) VALUES (?, ?)";

				if($stmt = $conn->prepare($sql)) {
					
					// Bind variables to the prepared statement as parameters
					$stmt->bind_param("ss", $param_username, $param_password);

					// Set parameters
					$param_username = $username;
					$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

					// Attempt to execute the prepared statement
					if($stmt->execute()) {

						// Redirect to login page
						header("location: ../Acasa.php");
						
					} else {
					echo 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
					}
					
					// Close statement
					$stmt->close();
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
	<title> Register </title>
	
	<!-- CSS pentru register.php -->
	<style>
	body {
		background: #6699ff;
		}
		
	#h2_sing_up {
		text-align: center;
		clear: left;
	}

	#div_register {
		text-align: center;
		border: solid gray 1px;
		border-radius: 15px;
		background: white;
		width: 350px;
		margin: 150px auto;
	}
	
	#div_register a:link , a:visited {
		color: #0000cc;
		text-decoration: none;
	}
	
	#div_register a:hover {
		color: hotpink;
	}
	</style>
</head>

<body>

<div id="div_register">

	<!-- Formul pentru selectarea limbii ////////////////////////////////////// -->
	<?php if(is_file($full_path_utilitar . 'form_selectare_limba.php')) include_once $full_path_utilitar . 'form_selectare_limba.php'; ?>
	
	<h2 id="h2_sing_up">Sign Up</h2> 
	<a href="register_write.php"> Sign up with Write access </a></p>
	
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
			<label> Confirm Password : </label>
			<input type="password" name="confirm_password"> <br>
			<?php echo $confirm_password_err; ?>
		</p>
		<p>
			<input type="submit" name="submit_sign_up" value="Sign up">
			<input type="reset" value="Reset">
		</p>
        <p> <?php text_deja_account($_SESSION['lang']); ?> <a href="login.php"> Log in </a></p>
		<p> <a href="../Acasa.php"> <?php text_reveniti_acasa($_SESSION['lang']); ?> </a></p>
	</form> 
</div>

</body>

<html>



