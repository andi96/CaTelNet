<?php
	require_once 'config.php';

	// Define variables and initialize with empty values
	$username = $password = $confirm_password = "";
	$username_err = $password_err = $confirm_password_err = "";

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
	
	// Close connection
	$conn->close();
	
?>

<!DOCTYPE html>
<html>

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
			<input type="submit" value="Sign up">
			<input type="reset" value="Reset">
		</p>
        <p> Aveti deja un account ? <a href="login.php"> Log in </a></p>
		<p> <a href="../Acasa.php"> Reveniti acasa </a></p>
	</form> 
</div>

</body>

<html>



