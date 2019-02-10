<?
include 'mbcfg.inc';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabsal ORDER BY numseq DESC"; 
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
$a="0"; $select_num=""; $select_per=""; $select_desc=""; 

while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq    =$linha["numseq"];
 $periodo   =$linha["periodo"];
 $ctrl      =$linha["ctrl"];
 $num       =$linha["num"];
 $descricao =$linha["descricao"];

 $select_num[$a]=$numseq;
 $select_per[$a]=$periodo;
 $select_desc[$a]=$descricao;
 $a++;
}
?>

