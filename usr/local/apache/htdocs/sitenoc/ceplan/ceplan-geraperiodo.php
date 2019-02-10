<?

// 1o passo para abrir/gerar novo periodo de preenchimento.

include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabsal ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
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
  echo "<p><font face='Courier New' size='2'>Ultimo Periodo: </font><font face='Courier New' size='2' color='#FF0000'> $ult_descricao - Ainda nao foi fechado.</font></p>";
  exit;
 }


$totsysop="0";
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT numseq,sysop FROM tabord where periodo='$ult_periodo' ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq   =$linha["numseq"];
 $sysop    =$linha["sysop"];
 if($numseq > $ultnumseq)
   $ultnumseq=$numseq;
 $totsysop++;
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
/*echo "Num.de dias no mes $numdiamesi\n";
echo "Num.de dias no mes $numdiamesf\n";
*/

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

//echo "Ultimo periodo cadastrado: $ult_periodo\n";
//echo "Ultimo numseq tabord:  $ultnumseq\n";
//echo "Total de sysop ultimo no periodo: $totsysop\n";
//echo "\n";
//echo "Novo Periodo: $mesini -  $prox_descricao\n";

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

include ('ceplan-gerap-i.inc');
?>
