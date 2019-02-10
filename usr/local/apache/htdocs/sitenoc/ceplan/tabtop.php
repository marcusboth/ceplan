<html>
<style type="text/css">
<!--
.menuformatado {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
        color: #003399;
        background-color: #FFFFFF;
        font-weight: bold;
        border: 1px solid #0099CC;
}
-->
</style>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FF6600" leftmargin="0" topmargin="0">
<table width="100%" border="0">
  <tr class="menuformatado"> 
    <td width="14%"><div align="center"><a href="confer.php" target='mainFrame'> 
        Feriados</a></div></td>
    <td width="20%"><div align="center"><a href="ceplan-geraperiodo.php" target='mainFrame'>Novo 
        Periodo</a></div></td>
    <td width="21%"><div align="center"><a href="listasorteados.txt" target='mainFrame'>Ordem Sorteada</a></div></td>
	<td width="23%"><div align="center"><a href="\\poasna1\Noc\Ferias\ferias-OPE.xls" target='mainFrame'>Planilha de Ferias</a></div></td>
    <td width="22%"><div align="center"><a href="estatuto.htm" target='mainFrame'>Estatuto</a></div></td>
  </tr>
</table> 
<table width="100%" border="0">
  <tr> 
    <td width="34%" height="79"> 
      <? include ('periodos_menu.inc'); ?>
      <form name="form1" method="post" action='tabpl.php' target='mainFrame'>
        <div align="center"> 
          <select name="mesini" class="menuformatado">
         <?  for($x=0;$x<$a;$x++)
               echo "<option value='$select_per[$x]'>$select_desc[$x]</option>";
             ?>
          </select>
          <input type='hidden' name='periodoemaberto' value='<? echo "$periodoemaberto"; ?>'>
          <br>
          <input type="submit" name="Submit" class="menuformatado" value="Plantoes">
        </div>
      </form></td>
    <td width="31%"> 


    </td>
    <td width="33%"> <form action='trocas_pessoais.php' method='POST' target='mainFrame'>
        <p align="center"><font face='Courier New' size='2'> 
          <select name='anoi' size='1' class="menuformatado" >


<?
$anocorrente=date('y');
$anocorrente=substr($anocorrente,1,2);

$ano[4]="<option value='2004'>2004</option>";
$ano[5]="<option value='2005'>2005</option>";
$ano[6]="<option value='2006'>2006</option>";
$ano[7]="<option value='2007'>2007</option>";
$anoselected[4]="<option value='2004' selected>2004</option>";
$anoselected[5]="<option value='2005' selected>2005</option>";
$anoselected[6]="<option value='2006' selected>2006</option>";
$anoselected[7]="<option value='2007' selected>2007</option>";
for($y=4;$y<7;$y++)
{
 if($anocorrente == $y)
   echo "$anoselected[$y]<BR>";
 else
   echo "$ano[$y]<BR>";
}
?>

          </select>
          <select name='mesi' size='1' class="menuformatado">

<?
$mes[1]="<option value='1-;-Janeiro'>Janeiro</option>";
$mes[2]="<option value='2-;-Fevereiro'>Fevereiro</option>";
$mes[3]="<option value='3-;-Marco'>Marco</option>";
$mes[4]="<option value='4-;-Abril'>Abril</option>";
$mes[5]="<option value='5-;-Maio'>Maio</option>";
$mes[6]="<option value='6-;-Junho'>Junho</option>";
$mes[7]="<option value='7-;-Julho'>Julho</option>";
$mes[8]="<option value='8-;-Agosto'>Agosto</option>";
$mes[9]="<option value='9-;-Setembro'>Setembro</option>";
$mes[10]="<option value='10-;-Outubro'>Outubro</option>";
$mes[11]="<option value='11-;-Novembro'>Novembro</option>";
$mes[12]="<option value='12-;-Dezembro'>Dezembro</option>";

$messelected[1]="<option value='1-;-Janeiro' selected>Janeiro</option>";
$messelected[2]="<option value='2-;-Fevereiro' selected>Fevereiro</option>";
$messelected[3]="<option value='3-;-Marco' selected>Marco</option>";
$messelected[4]="<option value='4-;-Abril' selected>Abril</option>";
$messelected[5]="<option value='5-;-Maio' selected>Maio</option>";
$messelected[6]="<option value='6-;-Junho' selected>Junho</option>";
$messelected[7]="<option value='7-;-Julho' selected>Julho</option>";
$messelected[8]="<option value='8-;-Agosto' selected>Agosto</option>";
$messelected[9]="<option value='9-;-Setembro' selected>Setembro</option>";
$messelected[10]="<option value='10-;-Outubro' selected>Outubro</option>";
$messelected[11]="<option value='11-;-Novembro' selected>Novembro</option>";
$messelected[12]="<option value='12-;-Dezembro' selected>Dezembro</option>";

$mescorrente=date('n');
//echo "$mescorrente\n";
for($i=1;$i<13;$i++)
 {
  if($mescorrente == $i)
   echo "$messelected[$i]<BR>\n";
  else
   echo "$mes[$i]<BR>\n";
  }

?>

          </select>
          <br>
          <input name='B1' type='submit' class="menuformatado" value='Troca semanal'>
          </font></p>
      </form></td>
  </tr>
</table>
</body>
</html>
