<?php
//            COPYRIGHT BY
//                   MICHAŁ SOIDA, 2010
//     Creative Commons Uznanie autorstwa -
//     - Użycie niekomercyjne - Na tych samych warunkach 3.0 Polska
// http://creativecommons.org/licenses/by-nc-sa/3.0/pl/legalcode
//
ini_set( 'display_errors', 'Off' ); 
error_reporting(0);
//-----------------------------------------------------
echo "<form action=\"\" method=\"get\" name=\"covers\">\n
<input name=\"class\" type=\"hidden\" value=\"{$cl}\" />
<input name=\"jduzy\" type=\"hidden\" value=\"{$nd}\" />
<input name=\"jmaly\" type=\"hidden\" value=\"{$nm}\" />
Data:
<script language=\"JavaScript\">
	var cal = new CalendarPopup(\"helpdiv\");
	cal.setMonthNames('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień');
	cal.setDayHeaders('N','P','W','Ś','C','P','S');
	cal.setWeekStartDay(1);
	cal.setTodayText(\"Dzisiaj\");
	cal.setDisabledWeekDays(5,6);
</script>
<input name=\"date\" type=\"text\" size=25 value=\"{$dt}\" />
<a href=\"#\"
   onClick=\"cal.select(document.forms['covers'].date,'anchor','yyyy-MM-dd'); return false;\"
   name=\"anchor\" id=\"anchor\"><img alt=\"Kalendarz\" width=\"18\" height=\"18\" 
  src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABh0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjEwcrIlkgAAAKhJREFUOE/NU9EOgyAQ2/5mvzrcm5uIX+cn+AV29pI7SUBw0yxrcskBTUN7cMWCyxmg0C2Mh0ou859CQ3jgSJk1ihAzJhFUlHpyCeVIRlzMIrQexKRcT25W6FRr+MAaudkb7cmlxLGMataW588vYBXzk6mVAhYRRdQnU6tZ2y30M2u1h2ph16ylQhvjV2veN3i2d3QvB9859N4h9I2UcnRP1za1dRzfd29GbN2XtNvZxgAAAABJRU5ErkJggg%3D%3D\" /></a>
  <br>\n";
//-----------------------------------------------------
echo "<input value=\"Pokaż\" type=\"submit\" /><br><br>\n";
echo "<div id=\"helpdiv\" style=\"position:absolute;visibility:hidden;background-color:white;layer-background-color:white;\"></div>
</form>\n";
?>