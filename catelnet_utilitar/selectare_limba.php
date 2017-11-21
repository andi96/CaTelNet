<?php

	if(!isset($_SESSION['lang']))
		$_SESSION['lang'] = 'ro';  // limba implicita la inceputul sesiunii

	if($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(isset($_POST["submit_lang"]))  // daca submit-ul a venit in urma schimbarii limbi
			if(isset($_POST["change_lang"]))
				$_SESSION['lang'] = $_POST["change_lang"];
	}
	
	$lang_file = $full_path_utilitar . 'languages/lang.' . $_SESSION['lang'] . '.php';
 
	if(is_file($lang_file)) include_once $lang_file;
	
?>