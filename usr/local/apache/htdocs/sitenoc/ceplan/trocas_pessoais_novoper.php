<?

include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql ="select escala.mes,escala.ano from escala order by numseq;";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
$coluna=0;
include ('ceplan_mes.php');
while ($linha=mysql_fetch_array($resultado))
{
 $ult_mes=$linha["mes"];
 $ult_ano=$linha["ano"];

 $mes_us=convertemes($ult_mes);
 $prox_mes=date("F", mktime(0,0,0,($mes_us)+1,01,$ano));
 //echo "$mes_us<BR>";
 if($mes_us==12)
  {
   $mes_us="1";
   $ult_ano=$ult_ano+1;
  }
 else
  $mes_us=$mes_us+1;

  // echo " $mes_us - $prox_mes<BR>";
 $mes_br=convertemes_br($mes_us);
 //echo "M $mes_br<BR>";

}
echo "
<p>Ainda nao foi cadastrado os horarios fixos do mes de $mes_br/$ult_ano .</p>
<form name='form1' method='post' action='trocas_pessoais_gerames.php'>

<p>&nbsp;</p>
<table width='280' border='1'>";

include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql ="select * from escala order by numseq DESC limit 1;";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $madrugaa=$linha["madrugaa"];
 $madrugab=$linha["madrugab"];
 $manhaa  =$linha["manhaa"];
 $manhab  =$linha["manhab"];
 $manhac  =$linha["manhac"];
 $matutino=$linha["matutino"];
 $tardea  =$linha["tardea"];
 $tardeb  =$linha["tardeb"];
 $tardec  =$linha["tardec"];
 $tarded  =$linha["tarded"]; 
 $vespertino=$linha["vespertino"];
 $noitea  =$linha["noitea"];
 $noiteb  =$linha["noiteb"]; 
 $noitec  =$linha["noitec"];

echo "
  <tr>
      <td width='171'>Madrugada(a)</td>
    <td width='93'><input type='text' name='madrugaa' value='$madrugaa'></td>
  </tr>
  <tr>
      <td>Madrugada(b)</td>
    <td><input type='text' name='madrugab' value='$madrugab'></td>
  </tr>
  <tr>
      <td>Manha(a)</td>
    <td><input type='text' name='manhaa' value='$manhaa'></td>
  </tr>
  <tr>
      <td>Manha(b)</td>
    <td><input type='text' name='manhab' value='$manhab'></td>
  </tr>
  <tr>
      <td>Manha(c)</td>
    <td><input type='text' name='manhac' value='$manhac'></td>
  </tr>
  <tr>
      <td>Matutino</td>
    <td><input type='text' name='matutino' value='$matutino'></td>
  </tr>
  <tr> 
      <td>Tarde(a)</td>
    <td><input type='text' name='tardea' value='$tardea'></td>
  </tr>
  <tr>
      <td>Tarde(b)</td>
    <td><input type='text' name='tardeb' value='$tardeb'></td>
  </tr>
  <tr>
      <td>Tarde(c)</td>
    <td><input type='text' name='tardec' value='$tardec'></td>
  </tr>
  <tr>
      <td>Tarde(d)</td>
    <td><input type='text' name='tarded' value='$tarded'></td>
  </tr>
  <tr>
      <td>Vespertino</td>
    <td><input type='text' name='vespertino' value='$vespertino'></td>
  </tr>
  <tr>
    <td>Noite(a)</td>
    <td><input type='text' name='noitea' value='$noitea'></td>
  </tr>
  <tr>
    <td>Noite(b)</td>
    <td><input type='text' name='noiteb' value='$noiteb'></td>
  </tr>
  <tr>
    <td>Noite(c)</td>
    <td><input type='text' name='noitec' value='$noitec'></td>
  </tr>
</table>
  <p>
    <input type='hidden' name='mes' value='$mes_br'>
    <input type='hidden' name='ano' value='$ult_ano'>
    <input type='submit' name='Submit' value='Cadastrar este mes'>
  </p>
</form>";
} 
?>
