<?php
	// Includem variabilele care ne dau full path-ul spre root si utilitar .
	if(is_file('variabile_full_path.php')) include_once 'variabile_full_path.php';
	
	// Initialize the session
	session_start();
	
	if(is_file($full_path_utilitar . 'selectare_limba.php')) include_once $full_path_utilitar . 'selectare_limba.php';
?>

<!--	
	Folosesc prepared statements pentru injection protection (de exemplu : user_name ; DROP TABLE ... ) si pentru ca e mai rapid .
	Nu folosesc mysqli_real_escape_string peste tot pentru ca daca un input nu e corect ,
nu vreau sa se continue cu el escape-uit , ci vreau sa nu fie acceptat deloc .
	De accea , la fiecare input se poate face o verificare contextuala ,
de exemplu , cand utilizatorul isi creaza un cont si introduce username-ul , acesta trebuie sa fie de forma : ^[a-zA-Z0-9_]*$ ,
adica contine doar litere nici , mari , cifre si '_' ;
sau sa nu depasesca o anumita lungime maxima ;
sau cum am si facut , ca ID-ul sa contina doar cifre .
	Nu am facut mai multe verificari contexuale , deoarece am lasat sa se poate alege orice valori , care respecta regulile stabilite .

	Setaera limbii am facut-o in 2 feluri : cu fisierele lang.ro.php , lang.en.php ... , pt cuvinte ,
iar pentru texte mai lungi cu functiile din functii_modificare_limba.php .
	Am tradus doar aceste texte in 2 limbi , pentru a arata metodele folosite .

	La cautarea in BD abonati , pentru nume si prenume nu tin cont de liere mari sau mici , deci la introducerea unui abonat nou , 
numele si prenumele sau poate fi scris cu litere mari sau mici .
	La partea de Log in  si  Sign up tin cont de litere mari sau mici .
	
	Fisierul : variabile_full_path.php din folderul root , contine full path-urile root-ului si a folderului utilitat .
	
	Fisierul : variabile_full_path.php din folderul root , trebuie inclus inaintea altor fisiere incluse , care folosesc variabile din el .
 -->

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>

<meta charset="UTF-8">
 
<title> CaTelNet Acasa </title>

<!-- CSS si Javascript extern comun tuturor paginilor ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'external_css_javascript.php')) include_once $full_path_utilitar . 'external_css_javascript.php'; ?>

<!-- CSS pentru continutul ( id="content" ) paginii -->
<style>

</style>

</head>


<body>

<!-- Header ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'header.php')) include_once $full_path_utilitar . 'header.php'; ?>

<!-- Slider ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'slider/slider.php')) include_once $full_path_utilitar . 'slider/slider.php'; ?>


<div id="main">

<!-- Meniu stanga ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'meniu_stanga_si_sus.php')) include_once $full_path_utilitar . 'meniu_stanga_si_sus.php'; ?>


<!-- Continut ////////////////////////// -->
	
	<div id="content">	
		<h3 style="margin-left:20px"> Acasa </h3>
		<pre style="font-family: 'Times New Roman', Times, serif;"> 
    SC CaTelNet SRL prin serviciile de televiziune prin cablu, telefonie fixa si internet, oferite, vine in intampinarea nevoilor clientilor astfel 
incat sa fim un partener de incredere in colaborarile viitoare.
    Echipa pe care ne bazam, seriozitatea si relatiile cu partenerii de afaceri, reprezinta garantia ca serviciile sunt de cea mai buna calitate.
    Colaborand cu noi veti avea satisfactie garantata.
    Afacerile care merita facute sunt cele bune, cele foarte bune si cele impreuna cu noi.
		
    Procedura functionala de solutionare a reclamatiilor.
	
    SC CaTelNet SRL pune la dispozitia clientilor urmatoarele modalitati de preluare si solutionare a sesizarilor :
    - telefonic 7/7 zile, 24/24 ore la nr. 0744 310 710
    - la sediul central din str.Revolutiei, nr.1
    - email : catelnet@tvcatelnet.ro
		</pre>
	</div>
	
<!-- End Continut ////////////////////////// -->
	
</div>


<!-- Footer ////////////////////////////////////// -->
<?php if(is_file($full_path_utilitar . 'footer.php')) include_once $full_path_utilitar . 'footer.php'; ?>

</body>


</html>