<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Plantoes</title>
<style type="text/css">
<!--
.chamada {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	text-transform: uppercase;
	color: #0066FF;
	font-weight: bold;
}
-->
</style>
</head>

<body leftmargin='10' topmargin='0' marginwidth='10' marginheight='10'>
<? include 'config1.php'; echo $mostramsglogado; ?>
<p></p>
<table valign='0' colspan='0' rowspan='0' width="66%">
  <tr>
    <td valign='0' width="34%"><font face="Courier New" size="2">Marcar/Consultar plantao</font></td>
    <td valign='0' width="53%"><font face="Courier New" size="2">
<p class='chamada'><a href='http://aquario.terra.com.br/ceplan/tabfr.php'>Experimente  o CEPLAN2</a> </p>
<form method="POST" action="cadpla.php">
  <p><font face="Arial" size="2"><select size="1" name="mesini">

<?
  $todosfechado="";
  include 'mbcfg.php';
  $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
  $db = mysql_select_db($imp_banco);
  $sql = "SELECT * FROM tabsal ORDER BY numseq DESC"; 
  $resultado = mysql_query($sql)
  or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
  while ($linha=mysql_fetch_array($resultado)) 
  {
   $numseq    =$linha["numseq"];
   $periodo   =$linha["periodo"];
   $ctrl      =$linha["ctrl"];
   $num       =$linha["num"];
   $descricao =$linha["descricao"];
 
   if($ctrl == "c")
    {
    echo "<option selected value=$periodo> $descricao - ATUAL</option>";
    $todosfechado="FALSE";
    }
   else
    echo  "<option value='$periodo'>$descricao</option>";
  }

echo "  </select> <input type='submit' value='OK' name='B1'> </font></p>
</form>
    </font></td>
    <td valign='0' width='13%'>&nbsp;</td>
  </tr>
  <tr>
    <td valign='0' width='34%'><font face='Courier New' size='2'>Consultar Saldo</font></td>
    <td valign='0' width='53%'>

<form method='GET' action='consal.php?mesini=$mesini&descricao=$descricao'>
<p><font face='Arial' size='2'><select size='1' name='mesini'>
";
 include 'mbcfg.php';
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "SELECT * FROM tabsal ORDER BY numseq DESC";
 $resultado = mysql_query($sql)
 or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
 while ($linha=mysql_fetch_array($resultado))
 {
  $numseq    =$linha["numseq"];
  $periodo   =$linha["periodo"];
  $ctrl      =$linha["ctrl"];
  $num       =$linha["num"];
  $descricao =$linha["descricao"];
 
  if($ctrl == "c")
   echo "<option selected value=$periodo> $descricao - ATUAL</option>";
  else
   echo  "<option value='$periodo'>$descricao</option>";
 }

$mesini=$periodo;
echo "
</select> <input type='submit' value='OK' name='B1'>
</form>
    </td>
    <td width='13%'>&nbsp;</td>
  </tr>
</table>
";
?>





<p></p>
<table valign='0' colspan='0' rowspan='0' width="66%">
  <tr>
    <td valign='0' width="34%"><font face="Courier New" size="2">Consulta trocas pessoais.</font></td>
    <td valign='0' width="53%"><font face="Courier New" size="2">
<form method="POST" action="cadchange.php">
  <p><font face="Arial" size="2"><select size="1" name="mesini">

<?
  include 'mbcfg.php';
  $todosfechado="";
  $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
  $db = mysql_select_db($imp_banco);
  $sql = "SELECT * FROM tabsal ORDER BY numseq"; 
  $resultado = mysql_query($sql)
  or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
  while ($linha=mysql_fetch_array($resultado)) 
  {
   $numseq    =$linha["numseq"];
   $periodo   =$linha["periodo"];
   $ctrl      =$linha["ctrl"];
   $num       =$linha["num"];
   $descricao =$linha["descricao"];
 
   if($ctrl == "c")
    {
    echo "<option selected value=$periodo> $descricao - ATUAL</option>";
    $todosfechado="FALSE";
    }
   else
    echo  "<option value='$periodo'>$descricao</option>";
  }
  
$mesini=$periodo;
?>

</select> <input type='submit' value='OK' name='B1'>
</form>
    </td>
    <td width='13%'>&nbsp;</td>
  </tr>
</table>


</font>
<?
include 'config1.php';
if ($todosfechado == "FALSE")
 echo $paradoem;
else
 echo "<p><font face='Courier New' size='2'>Ja pode ser aberto novo periodo. Avise o moderador.</font></p>";

echo "
</font>
<hr>
<p><font face='Courier New' size='2'>Administracao: <a href='confer.php'>Feriados</a> - <a href='ceplan-geraperiodo.php'>Novo Periodo</a> - <a href='lisord.php'>Ordem de Preenchimento</a></font></p>
 </font>
<table border='0' width='100%'>
  <tr>
    <td width='11%'><font face='Courier New' size='2'>Relatorio: &nbsp;&nbsp;</font></td>
    <td width='89%'>
<form method='POST' action='relticket.php'>
  <p><font face='Courier New' size='2'><select size='1' name='anoi'>
    <option>2003</option>
    <option selected>2004</option>
  </select><select size='1' name='mesi'>
    <option value='01'>Janeiro</option>
    <option value='02'>Fevereiro</option>
    <option value='03'>Marco</option>
    <option value='04'>Abril</option>
    <option value='05'>Maio</option>
    <option value='06'>Junho</option>
    <option value='07'>Julho</option>
    <option value='08'>Agosto</option>
    <option value='09'>Setembro</option>
    <option value='10'>Outubro</option>
    <option value='11'>Novembro</option>
    <option value='12'>Dezembro</option>
  </select>&nbsp; <input type='submit' value='Gerar' name='B1'></font></p>
</form>
</td>
  </tr>
</table>

</body>

</html>
";
?>
