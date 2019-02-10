<?
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabsal ORDER BY numseq DESC limit 1"; 
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq    =$linha["numseq"];
 $periodo   =$linha["periodo"];
 $ctrl      =$linha["ctrl"];
 $num       =$linha["num"];
 $descricao =$linha["descricao"];
}
?>

