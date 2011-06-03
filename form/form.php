<?php
//            COPYRIGHT BY
//                   MICHAŁ SOIDA, 2010
//     Creative Commons Uznanie autorstwa -
//     - Użycie niekomercyjne - Na tych samych warunkach 3.0 Polska
// http://creativecommons.org/licenses/by-nc-sa/3.0/pl/legalcode
//
//ini_set( 'display_errors', 'On' ); 
//error_reporting( E_ALL );
//-----------------------------------------------------
$teachers = array("Katarzyna Bajer","Aleksandra Bałucka - Grimaldi","Ewa Dudek",
"Regina Gryboś","Iwona Jankowska - Rabiega","Krystyna Klimek","Dorota Kramarz",
"Marzena Kurzawińska","Elżbieta Napiórkowska","Agnieszka Olszewska - Rabiega",
"Anna Ostrowska-Paton","Magdalena Płaneta","Barbara Rudnicka",
"Barbara Skiendzielewska - Dec","Maria Skrzypek","Renata Sokólska - Pyzik",
"Agnieszka Sowińska","Monika Stanula","Agnieszka Wojtasiewicz",
"Grażyna Zagórny","Maria Zborczyńska - Płodzień");
//-----------------------------------------------------
echo "<form action=\"{$where}\" method=\"get\" name=\"covers\">\n";
//-----------------------------------------------------
//echo "Klasa: <input name=\"class\" type=\"text\" size=2 maxlength=2 /><br>\n";
echo "Klasa: <select name=\"class\">";
foreach (array("1","2","3") as $classn) {
foreach (array("A","B","C","D","E","F","G","H","I") as $classl) {
$class = $classn . $classl;
echo "<option value =\"{$class}\">{$class}</option>\n"; }}
echo "</select><br>\n";
//-----------------------------------------------------
echo "Nauczyciel języka dużego: <select name=\"jduzy\">
<option value =\"\">Nie ma na liście</option>\n";
foreach ($teachers as $teacher) {
echo "<option value =\"{$teacher}\">{$teacher}</option>\n"; }
echo "</select><br>
Nauczyciel języka małego: <select name=\"jmaly\">
<option value =\"\">Nie ma na liście</option>\n";
foreach ($teachers as $teacher) {
echo "<option value =\"{$teacher}\">{$teacher}</option>\n"; }
echo "</select><br>\n";
//-----------------------------------------------------
echo "<input value=\"Sprawdź zastępstwa\" type=\"submit\" />\n";
echo "<div id=\"helpdiv\" style=\"position:absolute;visibility:hidden;background-color:white;layer-background-color:white;\"></div>
</form>\n";
?>