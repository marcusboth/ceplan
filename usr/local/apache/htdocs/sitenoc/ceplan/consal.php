<html>

<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Saldos do <? echo "$HTTP_GET_VARS[mesini]"; ?> </title>
</head>

<body>

<table border='0' width='50%'>
  <tr>
    <td width='15%'><font face='Courier New' size='2'><b>Sysop</b></font></td>
    <td width='6%'><font face='Arial' size='1'><b>No.Plantao Faltante</b></font></td>
    <td width='5%'><font face='Arial' size='1'><b>&nbsp;Dias Ausente</b></font></td>
    <td width='7%'><font face='Arial' size='1'><b>SaldoMes (Horas)</b></font></td>
    <td width='7%'><font face='Courier New' size='2'><b>&nbsp;SaldoTotal</b></font></td>
    <td width='63%'><font face='Courier New' size='2'><b>Ferias</b></font></td>
  </tr>
  <tr>
<?
$mesini="$HTTP_GET_VARS[mesini]";
echo "<p><font face='Courier New' size='2'>Saldos do Periodo: $HTTP_GET_VARS[mesini]</font></p>";
//echo "$HTTP_GET_VARS[mesini]<BR>";
//echo "$HTTP_GET_VARS[descricao]<BR>";
include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord WHERE periodo='$mesini' ORDER BY numseq"; 
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
$flag="FALSE";
while ($linha=mysql_fetch_array($resultado)) 
{
 $periodo  =$linha["periodo"];
 $trimestre=$linha["trimestre"];
 $librod   =$linha["librod"];
 $sysop    =$linha["sysop"];
 $nplant   =$linha["nplant"];
 $saldomes =$linha["saldomes"];
 $saltot   =$linha["saltot"];
 $qtferias =$linha["qtferias"];
 $ferias   =$linha["ferias"];
 
 if($flag == "FALSE")
  {
   echo "<td width='15%'><font face='Courier New' size='2'>&nbsp;$sysop</font></td>";
   echo "<td width='6%'><font face='Courier New' size='2'>$nplant</font></td>";
   echo "<td width='5%'><font face='Courier New' size='2'>$qtferias&nbsp;</font></td>";
   echo "<td width='7%'><font face='Courier New' size='2'>$saldomes&nbsp;</font></td>";
   echo "<td width='7%'><font face='Courier New' size='2'>&nbsp;$saltot</font></td>";
   echo "<td width='63%'><font face='Courier New' size='2'>$ferias&nbsp;</font></td>";
   echo " </tr>";
   $flag="TRUE";
  }
 else
  {
   echo "<td width='15%' bgcolor='#66CCFF'><font face='Courier New' size='2'>&nbsp;$sysop</font></td>";
   echo "<td width='6%' bgcolor='#66CCFF'><font face='Courier New' size='2'>$nplant</font></td>";
   echo "<td width='5%' bgcolor='#66CCFF'><font face='Courier New' size='2'>$qtferias&nbsp;</font></td>";
   echo "<td width='7%' bgcolor='#66CCFF'><font face='Courier New' size='2'>$saldomes&nbsp;</font></td>";
   echo "<td width='7%' bgcolor='#66CCFF'><font face='Courier New' size='2'>&nbsp;$saltot</font></td>";
   echo "<td width='63%' bgcolor='#66CCFF'><font face='Courier New' size='2'>$ferias&nbsp;</font></td>";
   echo " </tr>";
   $flag="FALSE";
  }
}

?>
</table>

<p>&nbsp;&nbsp; <font face='Courier New' size='1'> </font></p>

</body>
</html>
<?
echo "<hr>";
include 'plantoes.php';
?>
