<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Zastępstwa</title>
</head>
<body>
<?php
//            COPYRIGHT BY
//                   MICHAŁ SOIDA, 2010
//     Creative Commons Uznanie autorstwa -
//     - Użycie niekomercyjne - Na tych samych warunkach 3.0 Polska
// http://creativecommons.org/licenses/by-nc-sa/3.0/pl/legalcode
//
ini_set( 'display_errors', 'Off' ); 
error_reporting(0);
//-----------------------SKRYPT------------------------
$dt = $_REQUEST["date"];   // Data zastępstw
$adres_ogolny = "http://www.v-lo.krakow.pl/dla-uczniow/zastepstwa?subsDate=";
if($dt == "" or $dt == "YYYY-MM-DD") //ustalanie daty jutrzejszej jeżeli nie podana
{
	date_default_timezone_set('Europe/Warsaw');
	$data = date("Y-m-");
	$dzien = date("d") + 1;
	$dt = $data . sprintf('%02u',$dzien);
}

$adres = $adres_ogolny . $dt; //ostateczny adres
$dtw = substr($dt,0,8) . sprintf('%02u',substr($dt,8,2) - 1);
$dtp = substr($dt,0,8) . sprintf('%02u',substr($dt,8,2) + 1);
echo "<center><a href=\"http://michal.soida.pl/covers/orig.php?date={$dtw}\">wcześniej</a> - {$dt} - <a href=\"http://michal.soida.pl/covers/orig.php?date={$dtp}\">później</a><br><br>\n\n";
//-----------------------------------------------------
$strona = file_get_contents($adres);          //ściągamy zastępstwa
$strona = stristr($strona, '/form');         //i wstępnie obcinamy brzegi
$strona = stristr($strona, 'banners', true);
$strona = substr($strona, 29); //przygotowania 1. XML'a (tego wprost z tabeli)
$strona = substr($strona, 0, -85); //przygotowania 1. XML'a (tego wprost z tabeli)
echo $strona . "\n</center>\n";
?>
</body>
</html>
