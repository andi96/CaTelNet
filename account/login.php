<?php
	require_once "config.php";

	$username = $password = "";
	$username_err = $password_err = "";

	// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		// Check if username is empty
		if(empty(trim($_POST["username"]))) {
        $username_err = 'Introduceti username-ul .';  //'Please enter username .';
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST['password']))) {
        $password_err = 'Introduceti parola .';  //'Please enter your password .';
    } else {
        $password = trim($_POST['password']);
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

                            // Password is correct, so start a new session and save the username to the session 
                            session_start();							
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
    // Close connection
    $conn->close();
	
?>

<!DOCTYPE html>
<html>

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

	<h2 in="h2_log_in">Log in</h2>
	
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
			<input type="submit" value="Login">
		</p>
		<p> Nu aveti un account ? <a href="register.php"> Sign up </a> </p>
		<p> <a href="../Acasa.php"> Reveniti acasa </a></p>
	</form> 
</div>

</body>

</html>