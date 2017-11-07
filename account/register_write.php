<?php
	require_once 'config.php';

	// Define variables and initialize with empty values
	$username = $password = $confirm_password = $cod_write_access = $pass_cod_write_access = "";
	$username_err = $password_err = $confirm_password_err = $cod_write_access_err = $pass_cod_write_access_err = "";

	// Processing form data when form is submitted	
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		// Validate username
		if(empty(trim($_POST["username"]))) {
			$username_err = 'Introduceti username-ul .';  //'Please enter username .';
		} else
			if(strlen(trim($_POST['username'])) < 4) {
				$username_err = 'Username-ul trebuie sa contina minim 4 caractere .';  //"Username-ul must have atleast 6 characters.";
			} else {	
			
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

						if($stmt->num_rows == 1) {
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
		if(empty(trim($_POST['password']))) {
			$password_err = 'Introduceti parola .';  //'Please enter your password .';"Please enter a password.";     
		} else
			if(strlen(trim($_POST['password'])) < 7) {
				$password_err = 'Parola trebuie sa contina minim 7 caractere .';  //"Password must have atleast 7 characters.";
			} else {		
			$password = trim($_POST['password']);
			}

		// Validate confirm password
		if(empty(trim($_POST["confirm_password"]))) {
			$confirm_password_err = 'Confirmati parola .';  //'Please confirm password.';     
		} else {
			$confirm_password = trim($_POST['confirm_password']);
			
			// Doar daca parola este suficient de lunga testam egalitatea cu $confirm_password
			if((strlen(trim($_POST['password'])) >= 7) && ($password != $confirm_password)) {
				$confirm_password_err = 'Parola confirmata nu se potriveste .';  //'Password did not match.';
			}
		}

		
		// Validate cod_write_access and pass_cod_write_access
		// Verificam codul
		if(empty(trim($_POST["cod_write_access"]))) {
			$cod_write_access_err = 'Introduceti codul .';
		} else	
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
							if(empty(trim($_POST["pass_cod_write_access"])))
								$pass_cod_write_access_err = 'Introduceti parola codului .';
							else
							{
								// Verificam parola codului
								$pass_cod_write_access = trim($_POST["pass_cod_write_access"]);

								$stmt->bind_result($cod_write_access, $hashed_pass_cod_write_access);
		
								if($stmt->fetch()) {
									
									if(!(password_verify($pass_cod_write_access, $hashed_pass_cod_write_access))) {

									// Daca parola codului nu e corecta setam pe $pass_cod_write_access_err
									$pass_cod_write_access_err = "Parola cod invalida .";
									
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
	
	// Close connection
	$conn->close();
	
?>

<!DOCTYPE html>
<html>

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
			<input type="submit" value="Sign up">
			<input type="reset" value="Reset">
		</p>
        <p> Aveti deja un account ? <a href="login.php"> Log in </a></p>
		<p> <a href="../Acasa.php"> Reveniti acasa </a></p>
	</form> 
</div>

</body>

<html>