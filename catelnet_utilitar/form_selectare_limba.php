<!-- Form Selectare limba //////////////////////////// -->
<!-- Daca padding-ul div-ului cu formul pentru selectarea limbii e mai mare de 4px , atunci va intra in conflict cu <h1> CaTelNet </h1> , din header.php si il va muta mai la dreapta . -->
<div style="float: left;">
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="float: left; padding-top:4px; padding-left:4px; padding-right:6px;">
		<!-- La schimbarea limbii fac auto-click pe buttonul de submit_lang -->
		<select name="change_lang" style="width: 50px;" onchange="document.getElementById('submit_lang_button').click();">
			<option value="ro" <?php if(isset($_SESSION['lang']) && ($_SESSION['lang'] == "ro")) echo "selected"; ?> > RO </option>
			<option value="en" <?php if(isset($_SESSION['lang']) && ($_SESSION['lang'] == "en")) echo "selected"; ?> > EN </option>
		</select>
		<input hidden id="submit_lang_button" type="submit" name="submit_lang" value="">
	</form>
	<img src="<?php echo $full_path_utilitar_href;?>poze/steaguri/<?php echo $_SESSION['lang']; ?>.png" alt="<?php echo $_SESSION['lang']; ?>" style="width: 20px; height: 15px; clear: left; padding-top: 6px;">
</div>
<!-- END Form Selectare limba //////////////////////// -->