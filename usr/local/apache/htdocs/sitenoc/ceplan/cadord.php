<?
// 19/Julho/2003 - Corrigido a soma do saldo_do_mes com a soma do saldo_total - MBoth
//

// Teste se o periodo jah estiver fechado.
include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabsal ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $numseq  =$linha["numseq"];
 $periodo =$linha["periodo"];
 $ctrl    =$linha["ctrl"];
 $num     =$linha["num"];
 $descricao=$linha["descricao"];
 
 $ult_numseq=$numseq;
 $ult_periodo=$periodo;
 $ult_descricao=$descricao;
 
 if($ctrl == "c")
   $liberado="FALSE";
 else
  $liberado="TRUE";
}

if($liberado=="FALSE")
 {
  echo "<p><font face='Courier New' size='2'>Ultimo Periodo: </font><font face='Courier New' size='2' color='#FF0000'> $ult_descricao - AINDA NAO FOI FECHADO.</font></p>";
  //echo "Ultimo Periodo: $ult_descricao - ainda nao foi fechado.<BR>\n";
  // echo "Ultimo Periodo: $ult_periodo<BR>\n";
  //echo "Ultimo numseq: $numseq<BR>\n";
  //echo "LIBERADO: $liberado<BR>\n";
  echo "<hr>";
  include 'plantoes.php';
  exit;
 }

// Quebra o periodo atual.
$mesi=substr($ult_periodo,2,2);
$anoi=substr($ult_periodo,4,4);
$mesf=substr($ult_periodo,11,2);
$anof=substr($ult_periodo,13,4);
/*echo "MesI: $mesi\n";
echo "AnoI: $anoi\n";
echo "MesI: $mesf\n";
echo "AnoI: $anof\n";
*/

// Gera proximo periodo.
$prox_mesi=date("m", mktime(0,0,0,$mesi+1,16,$anoi));
$prox_anoi=date("Y", mktime(0,0,0,$mesi+1,16,$anoi));
$prox_mesf=date("m", mktime(0,0,0,$mesi+2,16,$anoi));
$prox_anof=date("Y", mktime(0,0,0,$mesi+2,16,$anoi));
/*echo "prox_MesI: $prox_mesi\n";
echo "prox_AnoI: $prox_anoi\n";
echo "prox_MesF: $prox_mesf\n";
echo "prox_AnoF: $prox_anof\n";
*/

// checa pra ver quantos dias tem o mes.
$numdiamesi=date("t", mktime(0,0,0,$prox_mesi,16,$anoi));
$numdiamesf=date("t", mktime(0,0,0,$prox_mesf,16,$anoi));
//echo "Num.de dias no mes $numdiamesi\n";
//echo "Num.de dias no mes $numdiamesf\n";

// Monta o mesini.
$mesini="16";
$mesini.="$prox_mesi";
$mesini.="$prox_anoi";
$mesini.="a";
$mesini.="15";
$mesini.="$prox_mesf";
$mesini.="$prox_anof";
//echo "mesini: $mesini\n";

$english_mes=date("M", mktime(0,0,0,$prox_mesi,16,$anoi));
$traduz_mesi=traduz_mes($english_mes);
$english_mes=date("M", mktime(0,0,0,$prox_mesf,16,$anoi));
$traduz_mesf=traduz_mes($english_mes);

$prox_descricao="16";
$prox_descricao.="$traduz_mesi";
//$descricao.="$prox_anoi";
$prox_descricao.=" a ";
$prox_descricao.="15";
$prox_descricao.="$traduz_mesf ";
$prox_descricao.="$prox_anof";

//echo "Descricao: $prox_descricao<BR>\n";

$i="0"; $sysopatual="";
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord WHERE periodo='$ult_periodo'";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq   =$linha["numseq"];
 $periodo  =$linha["periodo"];
 $trimestre=$linha["trimestre"];
 $librod   =$linha["librod"];
 $sysop    =$linha["sysop"];
 $nplant   =$linha["nplant"];
 $saldomes =$linha["saldomes"];
 $saltot   =$linha["saltot"];
 $qtferias =$linha["qtferias"];
 $ferias   =$linha["ferias"];

 if($saldomes <= "0")
  {
   $converte=($saldomes)*(-1);
   $saltot=$saltot+$converte;  
  }
 if($saldomes > "0")
   $saltot=$saltot-$saldomes;

 $ult_saldo[$i]="$saltot";
 $sysopatual[$i]="$sysop";
 $i++;
}

echo "
<html>
<head>
<meta http-equiv='Content-Language' content='en-us'>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
<title>Cadastro da Ordem de preenchimento.</title>
</head>
<body>";

echo "<font face='Courier New' color=#FF0000 size='2'>Verifique se os feriados jah foram devidamente cadastrados.&nbsp;<a href='confer.php'>Feriados</a></font><BR>";
$ultnumseq="0";
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabfer WHERE periodo='$mesini'";
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


echo "<form method='POST' action='cadord2.php'>
<table border='0' width='100%'>
  <tr>
    <td width='41%'><font face='Courier New' size=2>&nbsp;Proximo Periodo: $mesini</font><input type='hidden' name=mesini value=$mesini size='18'>
    </td>
    <td width='34%'><font face='Courier New'>$prox_descricao</font></td>
    <td width='25%'><font face='Courier New'>&nbsp;</font></td>
  </tr>
  <tr>
    <td width='41%'><font face='Courier New'>&nbsp;</font></td>
    <td width='34%'>
<p><font face='Courier New'>
<input type='text' name='ord0' maxlength=2 size='2'>> $sysopatual[0] <input type='hidden' name='nome0' size='10' value='$sysopatual[0]'> <input type='HIDDEN' name='usaldo0' value='$ult_saldo[0]'><br>
<input type='text' name='ord1' maxlength=2 size='2'>> $sysopatual[1] <input type='hidden' name='nome1' size='10' value='$sysopatual[1]'> <input type='HIDDEN' name='usaldo1' value='$ult_saldo[1]'><br>
<input type='text' name='ord2' maxlength=2 size='2'>> $sysopatual[2] <input type='hidden' name='nome2' size='10' value='$sysopatual[2]'> <input type='HIDDEN' name='usaldo2' value='$ult_saldo[2]'><br>
<input type='text' name='ord3' maxlength=2 size='2'>> $sysopatual[3] <input type='hidden' name='nome3' size='10' value='$sysopatual[3]'> <input type='HIDDEN' name='usaldo3' value='$ult_saldo[3]'><br>
<input type='text' name='ord4' maxlength=2 size='2'>> $sysopatual[4] <input type='hidden' name='nome4' size='10' value='$sysopatual[4]'> <input type='HIDDEN' name='usaldo4' value='$ult_saldo[4]'><br>
<input type='text' name='ord5' maxlength=2 size='2'>> $sysopatual[5] <input type='hidden' name='nome5' size='10' value='$sysopatual[5]'> <input type='HIDDEN' name='usaldo5' value='$ult_saldo[5]'><br>
<input type='text' name='ord6' maxlength=2 size='2'>> $sysopatual[6] <input type='hidden' name='nome6' size='10' value='$sysopatual[6]'> <input type='HIDDEN' name='usaldo6' value='$ult_saldo[6]'><br>
<input type='text' name='ord7' maxlength=2 size='2'>> $sysopatual[7] <input type='hidden' name='nome7' size='10' value='$sysopatual[7]'> <input type='HIDDEN' name='usaldo7' value='$ult_saldo[7]'><br>
<input type='text' name='ord8' maxlength=2 size='2'>> $sysopatual[8] <input type='hidden' name='nome8' size='10' value='$sysopatual[8]'> <input type='HIDDEN' name='usaldo8' value='$ult_saldo[8]'><br>
<input type='text' name='ord9' maxlength=2 size='2'>> $sysopatual[9] <input type='hidden' name='nome9' size='10' value='$sysopatual[9]'> <input type='HIDDEN' name='usaldo9' value='$ult_saldo[9]'><br>
<input type='text' name='ord10' maxlength=2 size='2'>> $sysopatual[10] <input type='hidden' name='nome10' value='$sysopatual[10]'> <input type='HIDDEN' name='usaldo10' value='$ult_saldo[10]'><br>
<input type='text' name='ord11' maxlength=2 size='2'>> $sysopatual[11] <input type='hidden' name='nome11' value='$sysopatual[11]'> <input type='HIDDEN' name='usaldo11' value='$ult_saldo[11]'><br>
<input type='text' name='ord12' maxlength=2 size='2'>> $sysopatual[12] <input type='hidden' name='nome12' value='$sysopatual[12]'> <input type='HIDDEN' name='usaldo12' value='$ult_saldo[12]'><br>
<input type='text' name='ord13' maxlength=2 size='2'>> $sysopatual[13] <input type='hidden' name='nome13' value='$sysopatual[13]'> <input type='HIDDEN' name='usaldo13' value='$ult_saldo[13]'><br>
  <input type='HIDDEN' name='prox_descricao' value='$prox_descricao'>
 <BR> <input type='submit' value=' Gerar ' name='B1'>&nbsp; <input type='reset' value='Apagar' name='B2'></font></p>
</form>
&nbsp;</td>
    <td width='25%'><font face='Courier New'>&nbsp;</font></td>
  </tr>
</table>
</body>";

Function traduz_mes($english_mes)
{
 switch($english_mes)
  {
    case "Jan":
        $portuguese_mes = "Janeiro";
        break;
    case "Feb":
        $portuguese_mes = "Fevereiro";
        break;
    case "Mar":
        $portuguese_mes = "Marco";
        break;
    case "Apr":
        $portuguese_mes = "Abril";
        break;
    case "May":
        $portuguese_mes = "Maio";
        break;
    case "Jun":
        $portuguese_mes = "Junho";
        break;
    case "Jul":
        $portuguese_mes = "Julho";
        break;
    case "Aug":
        $portuguese_mes = "Agosto";
        break;
    case "Sep":
        $portuguese_mes = "Setembro";
        break;
    case "Oct":
        $portuguese_mes = "Outubro";
        break;
    case "Nov":
        $portuguese_mes = "Novembro";
        break;                        
    case "Dec":
        $portuguese_mes = "Dezembro";
        break;
  }
  return ($portuguese_mes);
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

