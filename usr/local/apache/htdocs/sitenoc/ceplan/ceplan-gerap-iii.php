<?
// Uasdo para informar a ausencia (ferias e etc) de algum sysop no perido.
?>

<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
<title>CEPLAN - Dias ausente</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
<style type='text/css'>
<!--
.texto1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #CC3300;
        font-weight: bold;
	background-color: #FFCC00;
}
.texto2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #0000FF;
	font-weight: bold;
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

<body>

<?
$ultimoperiodo =$HTTP_POST_VARS['ultperiodo'];
$ultnumseq     =$HTTP_POST_VARS['ultnumseq'];
$prox_descricao=$HTTP_POST_VARS['prox_descricao'];
$proxperiodo   =$HTTP_POST_VARS['proxperiodo'];

$periodo=$HTTP_POST_VARS['acm'];
$acm=$HTTP_POST_VARS['acm'];
//echo "$HTTP_POST_VARS[nome3]<BR>";

for($a=1;$a<$acm;$a++)
 $nomes[$a]=$HTTP_POST_VARS["nome$a"];

$i="1"; $listanova[]="";
for($a=1;$a<$acm;$a++)
 {
  if(!empty($nomes[$a]))
   {
    $listanova[$i]=$nomes[$a];
    $i++;
   }
 }


// Testa pra ver se nao foi selecionado mais de uma vez.
$vezes="0";
$listacomp=$listanova;
$acmcomp=$acm;
for($a=1;$a<$acm;$a++)
 {
  // echo "comeca com $listacomp[$a]<BR>";
  for($b=1;$b<$acmcomp;$b++)
   {
    //echo "testa com $listanova[$b]<BR>";
    if($listacomp[$a] == $listanova[$b])
     $vezes++;
   }
   if("$vezes" > "1")
    {
      echo "Nao pode haver dois ou mais sysop's em branco.<BR>";
      echo "Verifique se $listacomp[$a] foi selecionado mais uma vez.<BR>";
      $a=$acm;
      exit;
    }
   else
     $vezes="0";
 }  

$mesini=$HTTP_POST_VARS[proxperiodo];
echo "mesini $mesini<BR>";
if(empty($mesini))
 exit; 

$mesi=substr($mesini,2,2);
$anoi=substr($mesini,4,4);
$mesf=substr($mesini,11,2);
$anof=substr($mesini,13,4);

$english_day=0; $traduz_semana=0; $diasemana[]=0;
// checa pra ver quantos dias tem o mes.
$tmes=date("t", mktime(0,0,0,$mesi,16,$anoi));
//echo "Num.de dias no mes $numdiamesi\n";

// --------------------------------
// --- Consulta de feriado
$temferiado="";
$feriado="";
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabfer WHERE periodo='$mesini'";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $numseq  =$linha["numseq"];
 $periodo =$linha["periodo"];
 $dia     =$linha["dia"];
 $diasem  =$linha["diasem"];
 $descricao=$linha["descricao"];

 echo "feriado - $periodo<BR>";
 $temferiado="sim";
 $feriado.="$dia$diasem;";
}

//echo "TEM FERIADO: $temferiado<BR>\n";
//echo "FERIADO - $feriado<BR>\n";
$oqei=""; $itot="1";
for($dia=16;$dia<=$tmes;$dia++)   // tmes eh o num. de dias q tem o mes inicial.
{
 //echo "Dia $dia MesInicial: $mesi - <BR>";
 $english_day=date("D", mktime(0,0,0,$mesi,$dia,$anoi));
   //echo "eng: $english_day - <BR>";
   //echo "diastd: $diasemana[$totdia]<BR>";
 $diasemana[$totdia]=traduz_semana($english_day);
 $temferiado=ereg("$dia/$mesi$english_day",$feriado,$oqei);
   // quebra a variavel/vetor feriado e compara.
   // echo "compara: $oqei[0] ----- $dia/$mesi$english_day<BR>";
 if("$oqei[0]" == "$dia/$mesi$english_day")
 {
 if($temferiado)
  {
   $plantao[$itot]="$mesini-;-$dia/$mesi-;-f-;-$diasemana[$totdia]";
   echo "Tem Feriado: - $plantao[$itot]<BR>";
   $itot++;
  }
 }
 if(!$temferiado)
  {
   $diasemana[$totdia]=traduz_semana($english_day);
   if($diasemana[$totdia] == "Sab")
    {
     $plantao[$itot]="$mesini-;-$dia/$mesi-;-s-;-$diasemana[$totdia]";
     //echo "~ Feriado: - $plantao[$itot]<BR>";
     $itot++;
    }
   if($diasemana[$totdia] == "Dom")
    {
     $plantao[$itot]="$mesini-;-$dia/$mesi-;-d-;-$diasemana[$totdia]";
     //echo "~ Feriado: - $plantao[$itot]<BR>";
     $itot++;
    }
   $totdia++;
  }
}
// ----------------------- fim feriado

for($dia=1;$dia<16;$dia++)        // do dia 01 ate o dia 15.
{
 //echo "Dia $dia MesFinal: $mesf -";
 $english_day=date("D", mktime(0,0,0,$mesf,$dia,$anof));
 $diasemana[$totdia]=traduz_semana($english_day);
 //echo "Dia da Semana: $diasemana[$totdia]<BR>";
 $temferiado=ereg("$dia/$mesf$english_day",$feriado,$oqei);
 //echo "compara: $oqei[0] ----- $dia/$mesf$english_day<BR>";
 if("$oqei[0]" == "$dia/$mesf$english_day")
 {
 if($temferiado)
  {
   $plantao[$itot]="$mesini-;-$dia/$mesf-;-f-;-$diasemana[$totdia]";
   echo "Tem Feriado: - $plantao[$itot]<BR>";
   $itot++;
  }
 }
 if(!$temferiado)
  {
   $diasemana[$totdia]=traduz_semana($english_day);
   if($diasemana[$totdia] == "Sab")
   {
    $plantao[$itot]="$mesini-;-$dia/$mesf-;-s-;-$diasemana[$totdia]";
    $itot++;
   }
   if($diasemana[$totdia] == "Dom")
   {
    $plantao[$itot]="$mesini-;-$dia/$mesf-;-d-;-$diasemana[$totdia]";
    //echo "~ Feriado: - $plantao[$itot]<BR>";
    $itot++;
   }
   $totdia++;
  }
}

// Aqui a variavel plantao ja esta incrementada contendo todos os dias da semana,
// todos os dias de plantao.
echo "<font face='Courier New' size='2'>Plantoes para o periodo $mesini</font><BR>"; 
$contadorplantao=0; $tflag="0";
$totplan=(double)0; $totdia=0; $totint=0; $tothoras=0;
for($t=1;$t<$itot;$t++)   // itot eh o numero de dias de plantoes.
 {
  list($tperiodo[$t],$tdia[$t],$tflag[$t],$tdiasemana[$t])=split("-;-",$plantao[$t]);
  // quebra os plantoes com periodo, dia, feriado, dia da semana.
  if($tflag[$t]=="s")
   {
    $totplan++;
   }
  if($tflag[$t]=="d")
   {
    $totplan++;
   }
 }
$totplan=(double)($totplan/2);
$tothoras=$totplan*6;
echo "<font face='Courier New' size='2'>Minimo de plantoes obrigatorio por sysop: $totplan</font><BR>";
echo "<font face='Courier New' size='2'>Minimo de horas: $tothoras</font><BR>";
echo "<BR><font face='Courier New' color=#FF0000 size='2'>Abaixo deve-se informar os dias que o sysop estara ausente (ferias e etc).</font>";

echo "
<form name='form2' method='post' action='ceplan-gerap-f.php'>
";

for($i=0;$i<$acm;$i++)
 {
  if(!empty($listanova[$i]))
  {
  //list($lixoa,$lixob,$lixoc,$sysopx[$i],$lixod,$lixoe,$lixof)=split(";",$tabordmem[$i]);
  echo "$i $listanova[$i]<BR>";
  //echo "<BR><font face='Courier New' size='2'>$sysopx[$i]</font><BR>";
  for($t=1;$t<$itot;$t++)   // itot eh o numero de dias de plantoes.
   {
    //echo "PL $plantao[$t]<BR>";
    list($tperiodo[$t],$tdia[$t],$tflag[$t],$tdiasemana[$t])=split("-;-",$plantao[$t]);
    //echo "Tdia $tdia[$t] Tsysop $listanova[$i]   ";
    if(($tflag[$t] != "f") AND (!empty($listanova[$i])))
    {
     $totpost++;
     echo "<font face='Courier New' size='2'><input type='checkbox' name='ausente$totpost' value='$listanova[$i];$tdia[$t]'> $tdia[$t]$tflag[$t]</font>";
    }
    echo "<BR>";
   }
  }
 }

for($i=1;$i<$acm;$i++)
 {
  //echo "$i - LISTA NOVA $listanova[$i]<BR>";
  echo " <input type='HIDDEN' name='nome$i' value='$listanova[$i]'>";
 }


echo "</table><br>";
echo "
  <input type='hidden' name='ultperiodo' value='$ultimoperiodo'>
  <input type='hidden' name='proxperiodo' value='$proxperiodo'>
  <input type='hidden' name='prox_descricao' value='$prox_descricao'>
  <input type='hidden' name='acm' value='$acm'>
  <input type='hidden' name='totplan' value='$totplan'>
  <input type='hidden' name='tothoras' value='$tothoras'>

  <input type='submit' class='botao' name='Submit' value=' Cadastrar o periodo '>
</form>
";

Function traduz_semana($english_day)
{
switch($english_day)
{
    case "Mon":
        $portuguese_day = "Seg";
        break;
    case "Tue":
        $portuguese_day = "Ter";
        break;
    case "Wed":
        $portuguese_day = "Qua";
        break;
    case "Thu":
        $portuguese_day = "Qui";
        break;
    case "Fri":
        $portuguese_day = "Sex";
        break;
    case "Sat":
        $portuguese_day = "Sab";
        break;
    case "Sun":
        $portuguese_day = "Dom";
        break;
}
return ($portuguese_day);
}


?>
</body>
</html>

