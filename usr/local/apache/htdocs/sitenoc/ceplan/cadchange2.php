<?
//Eh obrigatorio que este script seja chamado pelo "$obriga":
$obriga="cadchange.php";
$headers = getallheaders();
while (list ($header, $value) = each ($headers))
 {
  $temrefer=ereg($obriga,$value);
  if($temrefer)
    $passa="OK";
 //echo "$header: $value<br/>\n";
}

if((!$passa=="OK") OR (empty($passa)))
{
 naoabre();
 exit;
}

$sysop=$HTTP_POST_VARS[sysop];
//echo "$sysop foi quem preencheu.<BR>";

$cont_a=$HTTP_POST_VARS[idtabpla_ini];
for($cont=$cont_a;$cont<$HTTP_POST_VARS[idtabpla]+1;$cont++)
 {
 // $cont=$HTTP_POST_VARS[idtabpla];
  $madrugaach[$cont]=$HTTP_POST_VARS["madrugaach$cont"];
  $madrugabch[$cont]=$HTTP_POST_VARS["madrugabch$cont"];
  $manhaach[$cont]=$HTTP_POST_VARS["manhaach$cont"];
  $manhabch[$cont]=$HTTP_POST_VARS["manhabch$cont"];
  $tardeach[$cont]=$HTTP_POST_VARS["tardeach$cont"];
  $tardebch[$cont]=$HTTP_POST_VARS["tardebch$cont"];
  $noiteach[$cont]=$HTTP_POST_VARS["noiteach$cont"];
  $noitebch[$cont]=$HTTP_POST_VARS["noitebch$cont"];
  //echo "CONT $cont<BR>";
  //echo "$madrugaach[$cont]<BR>";
  //echo "$madrugabch[$cont]<BR>";
  //echo "$manhaach[$cont]<BR>";
  //echo "$manhabch[$cont]<BR>";
  //echo "$tardeach[$cont]<BR>";
  //echo "$tardebch[$cont]<BR>";
  //echo "$noiteach[$cont]<BR>";
  //echo "$noitebch[$cont]<BR>";
 }

//echo "cont $cont<BR>";
//echo "aaa $HTTP_POST_VARS[idtabpla]<BR>";
include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
for($a=$cont_a;$a<$HTTP_POST_VARS[idtabpla]+1;$a++)
 {
  $sql = "UPDATE tabpla SET numseq='$a',madrugaach='$madrugaach[$a]',madrugabch='$madrugabch[$a]',manhaach='$manhaach[$a]', manhabch='$manhabch[$a]',tardeach='$tardeach[$a]',tardebch='$tardebch[$a]',noiteach='$noiteach[$a]',noitebch='$noitebch[$a]' WHERE numseq='$a';";
  //echo "SQL $sql<BR>";
  $resultado = mysql_query($sql)
  or die ("Não foi possível gravar no banco de dados");
  //echo "<h1>Registro alterado com sucesso!</h1>";
 }

echo "<p><font face='Courier New' size='2'><a href='/'>Capa</a> <a href='/'></font></p>";

Function naoabre()
{
 print "<html>";
 print "<head>";
 print "<meta http-equiv=\"Content-Language\" content=\"en-us\">";
 print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">";
 print "<title>error</title>";
 print "</head>";
 print "<body>";
 print "<p><font face='Courier New' size='2'><a href='/plantoes/'>Capa</a> <a href='/plantoes/'></font></p>";
 print "</body>";
 print "</html>";
}

?>
