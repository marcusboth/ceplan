<?
// Usado para preencher os sorteados manualmente conforme a ordem.

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>CEPLAN </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.texto {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.campo {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #003399;
	text-decoration: none;
	border: 1px solid #0066FF;
}
.botao {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
	border: 1px solid #CCCCCC;
}
-->
</style>
</head>
<p class='texto'>Preenchimento manual da ordem dos sorteados</p>
<p class='texto'>1o. Se o sysop n�o existir mais, deixar em branco.</p
<body>
<form name="form1" method="post" action="ceplan-gerap-iii.php">
  <table width="75%" border="0">
    
<?
$ultimoperiodo =$HTTP_POST_VARS['ultperiodo'];
$ultnumseq     =$HTTP_POST_VARS['ultnumseq'];
$prox_descricao=$HTTP_POST_VARS['prox_descricao'];
$proxperiodo   =$HTTP_POST_VARS['proxperiodo'];
$numero=$HTTP_POST_VARS['numero'];
$numero++;
if(($numero < 8) OR ($numero > 18))
 {
  $mesg="Ops...... Verifique o numero de sysops - deve ter no minimo 8 e no maximo 18.";
 // chamaerro($mesg); 
  echo "$mesg<BR>";
  exit;
 }

echo "<p class='texto'>2o. Periodo $prox_descricao - <a href='http://aquario.terra.com.br/ceplan/listasorteados.txt' target='_blank'>Veja a lista de sorteados</a></p>";

echo "<font face='Courier New' color=#FF0000 size='2'>3o. Verifique se os feriados jah foram devidamente cadastrados.&nbsp;<a href='confer.php'>Feriados</a></font><BR>";

$ultnumseq="0";
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabfer WHERE periodo='$proxperiodo'";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{  
 $numseq     =$linha["numseq"];
 $periodo    =$linha["periodo"];
 $dia        =$linha["dia"];
 $diasem     =$linha["diasem"];
 $descricao_f  =$linha["descricao"];
 echo "<font face='Courier New' size='2'>$periodo - $dia $diasem - $descricao_f </font><BR>";
 if($numseq > $ultnumseq)
  $ultnumseq=$numseq;
}


$x="1";
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT numseq,sysop FROM tabord where periodo='$ultimoperiodo' ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq        =$linha["numseq"];
 $listasysop[$x]=$linha["sysop"];
 if($numseq > $ultnumseq)
   $ultnumseq=$numseq;
 
 $x++;
}

if(!empty($numero))
for($a=1;$a<$numero;$a++)
 {
 echo "
     <tr> 
      <td height='29'>&nbsp;</td>
      <td><div align='right'>$a&ordm;</div></td>
      <td>";
      if($a<$x)
       {
        echo "<select class='campo' name='nome$a'>";
        for($b=0;$b<$x;$b++)
         {
           echo "<option class='campo' value='$listasysop[$b]'>$listasysop[$b]</option>";
         }
         echo "</select>";
        }
      else
        echo "<input name='nome$a' class='campo' type='text' size='10' maxlength='10'>";
      echo "</td>
      <td>&nbsp;</td>
    </tr>
  ";
  }

?>
   <input type="hidden" name="ultperiodo" value='<? echo "$ultimoperiodo"; ?>'>
   <input type="hidden" name="ultnumseq" value='<? echo "$ultnumseq"; ?>'>
   <input type="hidden" name="proxperiodo" value='<? echo "$proxperiodo"; ?>'>
   <input type="hidden" name="prox_descricao" value='<? echo "$prox_descricao"; ?>'>
   <input type="hidden" name="acm" value='<? echo "$a"; ?>'>
  </table>
  <input name="Submit" type="submit" class="botao" value="Proximo &gt;&gt;">
</form>
</body>
</html>

