<?php
//            COPYRIGHT BY
//                   MICHAŁ SOIDA, 2011
//     Creative Commons Uznanie autorstwa -
//     - Użycie niekomercyjne - Na tych samych warunkach 3.0 Polska
// http://creativecommons.org/licenses/by-nc-sa/3.0/pl/legalcode
//
//                 FRAGMENT covers.php
//-----------------------------------------------------
if(array_key_exists("nodate",$_REQUEST)) $nodate = true;
else $nodate=false;
if ($nodate != true) echo "<script language=\"JavaScript\" src=\"CalendarPopup.js\"></script>
<script language=\"JavaScript\">document.write(getCalendarStyles());</script>\n";
?>

