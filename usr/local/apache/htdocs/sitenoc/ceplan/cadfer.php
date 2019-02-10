<?

//Eh obrigatorio que este script seja chamado pelo "$obriga":
$obriga="fer";
$headers = getallheaders();
while (list ($header, $value) = each ($headers))
 {
  $temrefer=ereg($obriga,$value);
  if($temrefer)
    $passa="OK";
 }
if((!$passa=="OK") OR (empty($passa)))
{
 naoabre();
 exit;
}

$ultnumseq ="$HTTP_POST_VARS[ultnumseq]";
$periodo   ="$HTTP_POST_VARS[periodo]";
$dia       ="$HTTP_POST_VARS[dia]";
$diasem    ="$HTTP_POST_VARS[diasem]";
$descricao ="$HTTP_POST_VARS[descricao]";

if(empty($periodo))
 {
 naoabre();
 exit;
 }

$ultnumseq=$ultnumseq+1;
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "INSERT INTO tabfer (numseq, periodo, dia, diasem, descricao) VALUES ('$ultnumseq','$periodo','$dia','$diasem','$descricao');";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
   
include 'confer.php';

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
