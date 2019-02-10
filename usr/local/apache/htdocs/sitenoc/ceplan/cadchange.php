<?
// Don't use cache (required for Opera)
$GLOBALS['now'] = gmdate('D, d M Y H:i:s') . ' GMT';
header('Expires: ' . $GLOBALS['now']); // rfc2616 - Section 14.21
header('Last-Modified: ' . $GLOBALS['now']);
header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache'); // HTTP/1.0
// Define the charset to be used
header('Content-Type: text/html; charset=' . $GLOBALS['charset']);

if(empty($HTTP_POST_VARS[mesini]))
 {
  naoabre();
  exit;
 }

$admin="$HTTP_SERVER_VARS[PHP_AUTH_USER]";

$mesini=$HTTP_POST_VARS[mesini];
Global $mesini;

include 'config1.php';

echo "<html>
<head>
<style type=text/css>
<!--
a {text-decoration: none}
-->
</style>
<META HTTP-EQUIV='pragma' CONTENT='no-cache'>
</head>";
echo "<body leftmargin='5' topmargin='0' marginwidth='0' marginheight='0'>";
echo "<font face='Courier New' size='1'>$mostramsglogado &nbsp;&nbsp;<font face='Courier New' size='1'><a href='plantoes.php'>&nbsp;&nbsp;&nbsp;VOLTAR</a></font>";

// Testa se o periodo jah esta fechado.
include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabsal WHERE periodo='$mesini'";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq  =$linha["numseq"];
 $periodo =$linha["periodo"];
 $ctrl    =$linha["ctrl"];
 $num     =$linha["num"];

 $preenchimento="readonly"; $devsysop=""; $npermitido=0; $sal="";
 mostrapreenchimento($sysoplogado,$mesini,$admin);
}

Function mostrapreenchimento($sysoplogado,$mesini,$admin)
{
 $idinicial=false;
 $idtabpla="0";
 echo "<BR><font face='Courier' size='3' color='#0000FF'>Uso exclusivo para trocas.</font>";
 include 'config1.php';
 include 'mbcfg.php';
 //echo "MODERADOR: $moderador<BR>";
 //echo "devSYSOP: $devsysop<BR>";
 //echo "Logado: $sysoplogado<BR>";

 print " <table border='-1' cellspacing='-1' cellpadding='-1' bordercolor='#000000'  width='100%'>
          <tr valign='0'>
            <td width='30%' align='center'><font color='#000080' size='2' face='Arial'>[Madrugada]
              1h
              as 7hs</font></td>
            <td width='20%' align='center'><font color='#000080' size='2' face='Arial'>[Manha]
              7hs
              as 13hs</font></td>
            <td width='25%' align='center'><font color='#000080' size='2' face='Arial'>[ Tarde ]
              13hs
              as 19hs</font></td>
            <td width='25%' align='center'><font color='#000080' size='2' face='Arial'>[ Noite ]
              19hs
              a 1h</font></td>
          </tr>
        </table>
 <table border='0' width='100%'>
  <tr valign='0'>";

 if($admin == "mboth")
  echo "<form method='POST' action='cadchange2.php'>";

 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "SELECT * FROM tabpla WHERE periodo='$mesini';";
 $resultado = mysql_query($sql)
 or die ("Não foi possível realizar a consulta ao banco de dados");

 $i=0;
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
  $madrugaach= $linha["madrugaach"];
  $madrugabch= $linha["madrugabch"];
  $manhaach  = $linha["manhaach"];
  $manhabch  = $linha["manhabch"];
  $tardeach  = $linha["tardeach"];
  $tardebch  = $linha["tardebch"];
  $noiteach  = $linha["noiteach"];
  $noitebch  = $linha["noitebch"];

 $i++;
 echo "<table border='0' width='100%'>";
 echo "<input type='HIDDEN' name=mesini value='$mesini'>";
 echo "<input type='HIDDEN' name=sysop value='$sysoplogado'>";
 echo "<input type='HIDDEN' name=nperiodo value='$nperiodo'>";
 echo "<input type='HIDDEN' name=proximo value='$proximosysopdev'>";
 echo "<input type='HIDDEN' name=permitido value='$npermitido'>";
 echo "<input type='HIDDEN' name=saldo value='$sal'>";
 echo "  <tr>";
 //echo "<table border='0' width='100%'>";
 echo "  <tr>";
 $quebralinha=ereg('Sab',$dia);
 if($quebralinha)
  echo "<hr>";
 echo "    <td width='25%'>";
 echo "      <table border='0' width='100%'>";
 echo "        <tr>";

 if(($idinicial == false) or ($idtabpla_ini > $numseq))
  {
    $idtabpla_ini=$numseq;
    $idinicial=true;
  }
 echo "<input type=hidden name=idtabpla_ini value='$idtabpla_ini'>";

 if($flag == "f") 
  echo "<td width='56%' bgcolor='#00FFFF'>&nbsp;<font face='Arial' size='2'>Dia $dia <input type='hidden' name='idtabpla' value='$numseq'></td>";
 else
  echo "<td width='56%'>&nbsp;<font face='Arial' size='2'>Dia $dia <input type='hidden' name='idtabpla' value='$numseq'> </td>";
 echo "<td width='44%' align='center'><font face='Courier New' size='2'><font face='Courier New' size='2' font color='#0000FF'><b>$madrugaa&nbsp;<BR><input type='text' name='madrugaach$numseq' size='10' maxlength='10' value='$madrugaach'></td>";
 echo "        </tr>";
 echo "      </table>";
 echo "    </td>";

 // Manha
 echo "    <td width='25%'>";
 echo "      <table border='0' width='100%'>";

 echo "<td width='50%' align='center'><font color='#0000FF' face='Courier New' size='2'><b>$manhaa&nbsp;<BR><input type='text' name='manhaach$numseq' size='10' maxlength='10' value='$manhaach'></td>";     
 echo "        </tr>";
 echo "      </table>";
 echo "    </td>";

 // Tarde a
 echo "    <td width='25%'>";
 echo "      <table border='0' width='100%'>";
 echo "  <tr>";
 echo "<td width='50%' align='center'><font color='#0000FF' face='Courier New' size='2'><b>$tardea&nbsp;<BR><input type='text' name='tardeach$numseq' size='10' maxlength='10' value='$tardeach'></td>";

 echo "<td width='50%' align='center'><font color='#0000FF' face='Courier New' size='2'><font face='Courier New' size='2'><b>$tardeb&nbsp;<BR><input type='text' name='tardebch$numseq' maxlength='10' size='10' value='$tardebch'></td>"; 
 echo "        </tr>";
 echo "      </table>";
 echo "    </td>";

 // Noite a
 echo "    <td width='25%'>";
 echo "      <table border='0' width='100%'>";
 echo "  <tr>";
 echo "<td width='50%' align='center'><font color='#0000FF' face='Courier New' size='2'><b>$noitea&nbsp; <BR><input type='text' name='noiteach$numseq' maxlength='10' size='10' value='$noiteach'></td>"; 

 // Noite b
 echo "<td width='50%' align='center'><font color='#0000FF' face='Courier New' size='2'><b>$noiteb&nbsp; <BR><input type='text' name='noitebch$numseq' maxlength='10' size='10' value='$noitebch'></td>";
 echo "        </tr>";
 echo "      </table>";
 echo "    </td>";
 echo "  </tr>";
 echo "</table>";
}

 if($admin == "mboth")
 echo "<p><input type='submit' value='Cadastrar' name='B1'>&nbsp;&nbsp;<input type='reset' value='Limpar' name='B2'></p></form>";
  echo "<hr>";
 }

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

?>

