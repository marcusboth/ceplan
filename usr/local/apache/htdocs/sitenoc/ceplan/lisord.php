<?
echo "<b><font face='Courier New' size='3'>Lista dos sorteados:</font></b>";
$i=0; $flag="false"; $mesini="";
include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord  ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $numseq   =$linha["numseq"];
 $periodo  =$linha["periodo"];
 $sysop    =$linha["sysop"];

 $mesi=substr($periodo,2,2);
 $anoi=substr($periodo,4,4);
 $mesf=substr($periodo,11,2);
 $anof=substr($periodo,13,4);
 $english_mes=date("M", mktime(0,0,0,$mesi,16,$anoi));
 $traduz_mesi=traduz_mes($english_mes);
 $english_mes=date("M", mktime(0,0,0,$mesf,16,$anoi));
 $traduz_mesf=traduz_mes($english_mes);
 $descricao="16";
 $descricao.="$traduz_mesi";
 $descricao.=" a ";
 $descricao.="15";
 $descricao.="$traduz_mesf ";
 $descricao.="$prox_anof";
 $descricao.="$anoi";

 if($mesini != "$periodo")
  {
   echo "<hr><font face='Courier New' size='2'>$descricao </font><BR>";
   $mesini=$periodo;
   $i=0;
  }
  $i++;
  echo "<font face='Courier New' size='2'>$i. $sysop </font><BR>";
}

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
echo "<hr>";
echo "<p><font face='Courier New' size='2'><a href='/'>Capa</a> <a href='/'></font></p>";

?>
