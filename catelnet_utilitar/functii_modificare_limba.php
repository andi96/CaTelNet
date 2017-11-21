<?php

// Functii pentru modificarea limbii textelor mai lungi .

/* $tip_BD = cablu , telefon sau internet 
   Textul : Baza date cu abonatii de Cablu/Telefon/Internet
   Pentru cautarea din cautare BD_uri.php
*/ 
function text_cauta_ab_serviciu($lang , $tip_BD)
{
	global $lang_array;
	
	switch($lang) {
		case 'ro' : echo 'Baza date cu abonatii de ' . $lang_array[strtoupper($tip_BD)]; break;
		case 'en' : echo 'Data base with ' . $lang_array[strtoupper($tip_BD)] . ' consumers'; break;
	}
}

/* Textul : Logativa pentru a vedea baza de date cu abonatii de Cablu/Telefon/Internet .
   Pentru cautarea din cautare BD_uri.php
*/ 
function text_log_pt_cautare($lang , $tip_BD)
{
	global $lang_array;
	
	switch($lang) {
		case 'ro' : echo 'Logativa pentru a vedea baza de date cu abonatii de ' . $lang_array[strtoupper($tip_BD)] . ' .'; break;
		case 'en' : echo 'Log in to see DB with ' . $lang_array[strtoupper($tip_BD)] . ' consumers .'; break;
	}
}

/* Textul : Adauga un abonat nou
   Pentru div 1 din modificare BD_uri.php 
*/
function text_ad_abonat($lang)
{
	switch($lang) {
		case 'ro' : echo 'Adauga un abonat nou'; break;
		case 'en' : echo 'Add a new consumer'; break;
	}
}

/* Textul : Adauga un abonament de cablu/telefon/internet nou
   Pentru div 2 din modificare BD_uri.php 
*/
function text_ad_serviciu($lang , $tip_BD)
{
	global $lang_array;
	
	switch($lang) {
		case 'ro' : echo 'Adauga un abonament de ' . strtolower($lang_array[strtoupper($tip_BD)]) . ' nou'; break;
		case 'en' : echo 'Add a new ' . strtolower($lang_array[strtoupper($tip_BD)]) . ' subscription'; break;
	}
}

/* Textul : Sterge un abonat dupa ID_abonat
   Pentru div 3 din modificare BD_uri.php 
*/
function text_st_abonat($lang)
{
	switch($lang) {
		case 'ro' : echo 'Sterge un abonat dupa ID_abonat'; break;
		case 'en' : echo 'Delete a consumer by ID_consumer'; break;
	}
}

/* Textul : Sterge un abonament de cablu/telefon/internet dupa ID_cablu
   Pentru div 4 din modificare BD_uri.php 
*/ 
function text_st_serviciu($lang , $tip_BD)
{
	global $lang_array;
	
	switch($lang) {
		case 'ro' : echo 'Sterge un abonament de ' . strtolower($lang_array[strtoupper($tip_BD)]) . ' dupa ID_cablu'; break;
		case 'en' : echo 'Delete a ' . strtolower($lang_array[strtoupper($tip_BD)]) . ' subscription by ID_ subscription'; break;
	}
}

/* Textul : Inapoi la Cauta 
   Pentru stergerile din modificare BD_uri.php 
*/ 
function text_inapoi_la_cauta($lang)
{	
	switch($lang) {
		case 'ro' : echo 'Inapoi la Cauta'; break;
		case 'en' : echo 'Back to Search'; break;
	}
}

/* Textul : Logativa cu drepturi de read/write pentru a modifica baza de date cu abonatii de Cablu/Telefon/Internet .
   Pentru stergerile din modificare BD_uri.php 
*/ 
function text_log_rw_pt_modificare($lang , $tip_BD)
{
	global $lang_array;
	
	switch($lang) {
		case 'ro' : echo 'Logativa cu drepturi de read/write pentru a modifica baza de date cu abonatii de ' . $lang_array[strtoupper($tip_BD)] . ' .'; break;
		case 'en' : echo 'Log in with read/write rights to can modify ' . $lang_array[strtoupper($tip_BD)] . ' DB'; break;
	}
}

/* Textul : Reveniti acasa
   Pentru login.php , register.php si register_write.php
*/ 
function text_reveniti_acasa($lang)
{	
	switch($lang) {
		case 'ro' : echo 'Reveniti acasa'; break;
		case 'en' : echo 'Back to Home'; break;
	}
}

/* Textul : Nu aveti un account ?
   Pentru login.php 
*/ 
function text_no_account($lang)
{	
	switch($lang) {
		case 'ro' : echo 'Nu aveti un account ?'; break;
		case 'en' : echo "Don't have aleady an account ?"; break;
	}
}

/* Textul : Aveti deja un account ?
   Pentru login.php 
*/ 
function text_deja_account($lang)
{	
	switch($lang) {
		case 'ro' : echo 'Aveti deja un account ?'; break;
		case 'en' : echo 'Alredy have an account ?'; break;
	}
}


?>