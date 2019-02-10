<?

include 'mbcfg.php';
$mesi=$HTTP_POST_VARS[mesi];
$anoi=$HTTP_POST_VARS[anoi];
//echo "$mesi - $anoi<BR>";
if((empty($mesi)) OR (empty($anoi)))
 {
  naoabre();
  exit;
 }

$mesi="06";
//$mes=$mesi;
//$anoi="2003";

$mes_desc=date("M", mktime(0,0,0,$mesi,16,$anoi));
$ano=date("Y", mktime(0,0,0,$mesi,16,$anoi));
//echo "$mes\n";
//echo "$ano\n";

$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabpla ORDER by numseq ";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");

echo "<font face='Courier New' size='3'>Numero de plantoes por sysop no mes $mes ($mes_desc) $anoi. </font><BR>\n";
echo "<font face='Courier New' size='3'> ATENCAO TEMPORARIAMENTE DESABILITADO - tem bug - fazer a contagem manual. </font><BR>\n";
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq    = $linha["numseq"];
 $dia       = $linha["dia"];
 $flag      = $linha["flag"];
 $numplan   = $linha["numplan"];
 $madrugaa  = $linha["madrugaa"];
 $madrugab  = $linha["madrugab"];
 $manhaa    = $linha["manhaa"];
 $manhab    = $linha["manhab"];
 $tardea    = $linha["tardea"];
 $tardeb    = $linha["tardeb"];
 $noitea    = $linha["noitea"];
 $noiteb    = $linha["noiteb"];
 
 $tem=ereg("$mesi",$dia);
 if($tem)
  {
   if($numseq > 100)
    {
   echo "DIA: $numseq $dia  - $madrugaa - $manhaa - $tardea - $tardeb - $noitea - $noitebi<BR>\n";
   $turnos.="$madrugaa-$manhaa-$tardea-$tardeb-$noitea-$noiteb";
    }
  }
}

$acm=0;

$count = preg_match_all('/(Fios)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Fios : $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Both)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Both: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Luciano)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Luciano: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Eduardo)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Eduardo: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Castro)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Castro: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Lima)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Lima: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Mello)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Mello: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Umann)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Umann: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Igor)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Igor: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Raoni)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Raoni: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Rosito)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Rosito: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Thiago)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Thiago: $count <BR>\n";
$acm=$acm+$count;

$count = preg_match_all('/(Lucio)/', $turnos, $match);
echo "<font face='Courier New' size='3'>Lucio: $count <BR>\n";
$acm=$acm+$count;

echo "<font face='Courier New' size='3'>Total de Tickets : $acm </font><BR>\n";

echo "<hr>";
// - erro
Function naoabre()
{
 print "<html>";
 print "<head>";
 print "<meta http-equiv=\"Content-Language\" content=\"en-us\">";
 print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">";
 print "<title>error</title>";
 print "</head>";
 print "<body>";
 print "<p><font face=\"Courier New\">erro.</font></p>";
 print "</body>";
 print "</html>";
}

include 'plantoes.php';
?>
