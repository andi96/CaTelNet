<?php
	// Creare conturi cu read/write access 
	
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
	$username = $password = $confirm_password = $cod_write_access = $pass_cod_write_access = "";
	$username_err = $password_err = $confirm_password_err = $cod_write_access_err = $pass_cod_write_access_err = "";

	// Processing form data when form is submitted	
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if(isset($_POST["submit_sign_up_write"]))  // daca submit-ul a venit in urma Sign up - ului
		{
			// Validate username
			// Doar daca nu avem deja eroare la username (!empty($username_err) mai facem verificarile urmatoare
			if(empty($username_err) && empty(trim($_POST["username"]))) {
				$username_err = 'Introduce-ti username-ul .';  //'Please enter username .';
			} 
				
			if(empty($username_err) && strlen(trim($_POST['username'])) < $min_length_username) {
					$username_err = 'Username-ul trebuie sa contina minim ' . $min_length_username . ' caractere .';  //"Username-ul must have atleast 4 characters.";
			}

			if(empty($username_err) && strlen(trim($_POST['username'])) > $max_length_username) {
					$username_err = 'Username-ul trebuie sa contina maxim ' . $max_length_username . ' caractere .';
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
				$password_err = 'Parola trebuie sa contina minim ' . $min_length_password . ' caractere .';  //"Password must have at least 7 characters.";
			} 
			
			if(empty($password_err) && strlen(trim($_POST['password'])) > $max_length_password) {
				$password_err = 'Parola trebuie sa contina maxim ' . $max_length_password . ' caractere .';
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

			
			// Validate cod_write_access and pass_cod_write_access
			// Verificam codul
			if(empty($cod_write_access_err) && empty(trim($_POST["cod_write_access"]))) {
				$cod_write_access_err = 'Introduce-ti codul .';
			} 
				
			if(empty($cod_write_access_err) && strlen(trim($_POST['cod_write_access'])) < $min_length_cod_write) {
					$cod_write_access_err = 'Cod inexistent .';
			}

			if(empty($cod_write_access_err) && strlen(trim($_POST['cod_write_access'])) > $max_length_cod_write) {
					$cod_write_access_err = 'Cod inexistent .';
			}

			if(empty($cod_write_access_err))
			{
					// Prepare a select statement
					$sql = "SELECT cod , pass_cod FROM cod_write_access WHERE cod = ?";
					
					if($stmt = $conn->prepare($sql)) {

						// Bind variables to the prepared statement as parameters
						$stmt->bind_param("s", $param_cod);

						// Set parameters
						$param_cod = trim($_POST["cod_write_access"]);

						// Attempt to execute the prepared statement
						if($stmt->execute())
						{

							// store result
							$stmt->store_result();

							if($stmt->num_rows < 1) {
								$cod_write_access_err = 'Cod inexistent .';
							} else 
							{
								// Verificam parola codului
								if(empty($pass_cod_write_access_err) && empty(trim($_POST["pass_cod_write_access"])))
									$pass_cod_write_access_err = 'Introduce-ti parola codului .';
								
								if(empty($pass_cod_write_access_err) && strlen(trim($_POST['pass_cod_write_access'])) < $min_length_pass_cod_write) {
									$pass_cod_write_access_err = 'Parola cod invalida .';
								}

								if(empty($pass_cod_write_access_err) && strlen(trim($_POST['pass_cod_write_access'])) > $max_length_pass_cod_write) {
										$pass_cod_write_access_err = 'Parola cod invalida .';
								}
								
								if(empty($pass_cod_write_access_err))
								{
									// Verificam parola codului in BD
									$pass_cod_write_access = trim($_POST["pass_cod_write_access"]);

									$stmt->bind_result($cod_write_access, $hashed_pass_cod_write_access);
			
									if($stmt->fetch()) {
										
										if(!(password_verify($pass_cod_write_access, $hashed_pass_cod_write_access))) {

										// Daca parola codului nu e corecta setam pe $pass_cod_write_access_err
										$pass_cod_write_access_err = 'Parola cod invalida .';
										
										}
									}
								}
							}

						} else {
							echo 'Ops! A aparut o problema . Incercati mai tarziu .';  //'Oops! Something went wrong. Please try again later .';
						}
						
						// Close statement
						$stmt->close();
					}	
			}
			

			// Check input errors before inserting in database
			if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($cod_write_access_err)&& empty($pass_cod_write_access_err)) {
		
				// Prepare an insert statement
				$sql = "INSERT INTO users (username, password , account_type) VALUES (? , ? ,'read/write')";

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
	<title> Register wtrite access </title>
	
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
	<a href="register.php"> Sign up with just Read access </a></p>
	
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
			<label> Cod write access : </label>
			<input type="text" name="cod_write_access"> <br>
			<?php echo $cod_write_access_err; ?>
		</p>
		<p>
			<label> Password cod write access : </label>
			<input type="password" name="pass_cod_write_access"> <br>
			<?php echo $pass_cod_write_access_err; ?>
		</p>		
		<p>
			<input type="submit" name="submit_sign_up_write" value="Sign up">
			<input type="reset" value="Reset">
		</p>
        <p> <?php text_deja_account($_SESSION['lang']); ?> <a href="login.php"> Log in </a></p>
		<p> <a href="../Acasa.php"> <?php text_reveniti_acasa($_SESSION['lang']); ?> </a></p>
	</form> 
</div>

</body>

<html>