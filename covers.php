<?php
//            COPYRIGHT BY
//                   MICHAŁ SOIDA, 2010
//     Creative Commons Uznanie autorstwa -
//     - Użycie niekomercyjne - Na tych samych warunkach 3.0 Polska
// http://creativecommons.org/licenses/by-nc-sa/3.0/pl/legalcode
//
ini_set( 'display_errors', 'Off' ); 
error_reporting(0);
//-----------------------ZMIENNE-----------------------
date_default_timezone_set('Europe/Warsaw');
$covers_not_found1 = "BŁĄD - Brak zastępstw na ";
$covers_not_found2 = " na stronie VLO! Misie Panda płaczą!";
$no_covers1 = "Brak zastępstw w ";
$no_covers2 = ", wszystkie lekcje normalnie ;)";
$daychange = 11; //Godzina zmiany domyślnych zastępstw na jutrzejsze
$cld = "2D";               //  Klasa domyślna
if(array_key_exists("class",$_REQUEST)) $cl = strtoupper($_REQUEST["class"]);
else $cl = ""; // Klasa (1A,2B,3D,...)
if(array_key_exists("jduzy",$_REQUEST)) $nd = $_REQUEST["jduzy"];
else $nd = ""; // Nauczyciel języka dużego
if(array_key_exists("jmaly",$_REQUEST)) $nm = $_REQUEST["jmaly"];
else $nm = ""; // Nauczyciel języka małego
if(array_key_exists("date",$_REQUEST)) $dt = $_REQUEST["date"];
else $dt = "";
if(array_key_exists("nodate",$_REQUEST)) $nodate = true;
else $nodate=false;
if(array_key_exists("me",$_REQUEST))
{
	$cl="2D";
	$nd="Barbara Skiendzielewska - Dec";
	$nm="Maria Skrzypek";
}
//-----------------------SKRYPT------------------------
if($cl == "") { $cl=$cld; } //wybieranie domyślnej klasy
$yr = substr($cl,0,1);
$cd = "d" . $yr; //na podstawie
$cm = "m" . $yr; //wprowadzonych danych
$adres_ogolny = "http://www.v-lo.krakow.pl/dla-uczniow/zastepstwa?subsDate=";
if($dt == "" or $dt == "YYYY-MM-DD") //ustalanie daty jutrzejszej jeżeli nie podana
{	
	if(date("N") > 5) $dt = date("Y-m-d", strtotime('next Monday'));
	else
	{
	if(date("G") >= $daychange)
	{
		if(date("N") >= 5) $dt = date("Y-m-d", strtotime('next Monday'));
		else $dt = date("Y-m-d", strtotime('tomorrow'));
	}
	else $dt = date("Y-m-d");
	}
	
	
}
$adres = $adres_ogolny . $dt; //ostateczny adres
switch (date("N",strtotime($dt))) {
    case 1:
        $dow = "Poniedziałek";
        $dow_w = "poniedziałek";
        break;
    case 2:
        $dow = "Wtorek";
        $dow_w = "wtorek";
        break;
    case 3:
        $dow = "Środa";
        $dow_w = "środę";
        break;
    case 4:
        $dow = "Czwartek";
        $dow_w = "czwartek";
        break;
    case 5:
        $dow = "Piątek";
        $dow_w = "piątek";
        break;
   	case 6:
        $dow = "Sobota";
        $dow_w = "sobotę";
        break;
    case 7:
        $dow = "Niedziela";
        $dow_w = "niedzielę";
        break;}
if ($nodate != true) include('date.php');
//-----------------------------------------------------
$strona = file_get_contents($adres);          //ściągamy zastępstwa
$strona = stristr($strona, 'Pokaż zastępstwa na jutro');         //i wstępnie obcinamy brzegi
$strona = stristr($strona, 'banners', true);
$strona = substr($strona, 54);
$strona = substr($strona, 0, -85); //przygotowania 1. XML'a (tego wprost z tabeli)



$strona = str_ireplace("<table>", "" , $strona);
$strona = str_ireplace("</table>", "" , $strona);
$strona = str_ireplace("				<h3 class = \"table_title\">", "	<tr>
		<th>" , $strona);
$strona = str_ireplace("</h3>", "</th>
	</tr>" , $strona);

$strona = "<?xml version=\"1.0\"?>
<table>
" . $strona . "
</table>";




//-----------------------------------------------------
$table = simplexml_load_string($strona); //ładujemy 1. XML'a
$mojxml = "";
foreach ($table->tr as $tr) {  //robimy stringa z 2. XML'em
if ($tr->th != "") {
$mojxml = $mojxml . <<<EOF
	</teacher>
	<teacher name="{$tr->th}">

EOF;
}
else {
$lesson = $tr->td[0];
$cover = $tr->td[1];
$class = substr($cover, 0, 2);
$cover = substr($cover, 5);
$mojxml = $mojxml . <<<EOF
		<cover lesson="{$lesson}" class="{$class}">{$cover}</cover>

EOF;
} }
$mojxml = substr($mojxml, 12);
$mojxml = "<?xml version=\"1.0\"?>
<covers>
" . $mojxml . <<<EOF
	</teacher>
</covers>

EOF;
//----------POPRAWA RÓŻNYCH BŁĘDÓW 2. XML'a------------
$covers = simplexml_load_string($mojxml);
if (!$covers) {echo $covers_not_found1 . strtolower($dow_w) . $covers_not_found2;}
else { //dalszy skrypt wykonywany gdy istnieją zastępstwa (global-else)
$t = 0;
foreach ($covers->teacher as $teacher) {
	$c = 0;
	foreach ($teacher->cover as $cover) {
		if(substr($cover,0,3)==" - ") { $covers->teacher[$t]->cover[$c] = substr($cover,3); }
		if($cover=="Złączenie grup złączenie grup") { $covers->teacher[$t]->cover[$c] = substr($cover,0, -17); }
		if($cover['class']=="I ") {
			$size = "d";
			$covers->teacher[$t]->cover[$c] = substr($covers->teacher[$t]->cover[$c],21);
			$class = substr($covers->teacher[$t]->cover[$c],0,1);
			$covers->teacher[$t]->cover[$c] = substr($covers->teacher[$t]->cover[$c],4);
			$covers->teacher[$t]->cover[$c]['class'] = $size.$class;
		}
		if($cover['class']=="II") {
			$size = "m";
			$covers->teacher[$t]->cover[$c] = substr($covers->teacher[$t]->cover[$c],22);
			$class = substr($covers->teacher[$t]->cover[$c],0,1);
			$covers->teacher[$t]->cover[$c] = substr($covers->teacher[$t]->cover[$c],4);
			$covers->teacher[$t]->cover[$c]['class'] = $size.$class;
		}
		if(stripos($cover,$cl)) { $covers->teacher[$t]->cover[$c]['class'] = $cl; }
		$c++;
		}
	$t++;
}
//-------------TWORZENIE TABELI ZASTĘPSTW--------------
for($i=0;$i<=8;$i++) {
	$tabela[$i]['teacher'] = "";
	$tabela[$i]['cover'] = ""; 
}
foreach ($covers->teacher as $teacher) {
	foreach ($teacher->cover as $cover) {
		if($cover['class'] == $cl or ($cover['class'] == $cd and $teacher['name'] == $nd) or ($cover['class'] == $cm and $teacher['name'] == $nm) )
		{
			if($cover['lesson'] == 1) { $numer = 1; }
			elseif($cover['lesson'] == 2) { $numer = 2; }
			elseif($cover['lesson'] == 3) { $numer = 3; }
			elseif($cover['lesson'] == 4) { $numer = 4; }
			elseif($cover['lesson'] == 5) { $numer = 5; }
			elseif($cover['lesson'] == 6) { $numer = 6; }
			elseif($cover['lesson'] == 7) { $numer = 7; }
			elseif($cover['lesson'] == 8) { $numer = 8; }
			elseif($cover['lesson'] == 0) { $numer = 0; }
			if($tabela[$numer]['cover'] == "")
			{
				$tabela[$numer]['teacher'] = $teacher['name'];
				$tabela[$numer]['cover'] = $cover;
			}
			else
			{
				$tabela[$numer]['teacher'] = $tabela[$numer]['cover'];
				$tabela[$numer]['cover'] =  $cover;
			}
		}
	}
}
//-----------------WYPISYWANIE TABELI------------------
$zastepstwa = $dow . ":<br>\n";
for($i=1;$i<=8;$i++) {
	if($tabela[$i]['cover'] != "")
	{
		$zastepstwa .= " {$i} - {$tabela[$i]['teacher']} - {$tabela[$i]['cover']}<br>\n";
	}
	else
	{
		$zastepstwa .= " {$i} - brak zastępstwa<br>\n";
	}
}
//-----------------UPRASZCZANIE TABELI-----------------
$wzortabeli = $dow . ":<br>\n";
for($i=1;$i<=8;$i++) {
	$wzortabeli .= " {$i} - brak zastępstwa<br>\n";
}
if ( $zastepstwa != $wzortabeli ) echo $zastepstwa;
else echo $no_covers1 . $dow_w . $no_covers2;
} //koniec global-else
?>