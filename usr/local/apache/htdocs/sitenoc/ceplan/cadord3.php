<?
//Eh obrigatorio que este script seja chamado pelo "$obriga":
$obriga="cadord2.php";
$headers = getallheaders();
while (list ($header, $value) = each ($headers))
 {
  $temrefer=ereg($obriga,$value);
  if($temrefer)
    $passa="OK";
 //echo "$header: $value<br/>\n";
}

if((!$passa=="OK") OR (empty($passa)))
{
 naoabre();
 exit;
}

$mesini=$HTTP_POST_VARS[mesini];
$mesini_b=$HTTP_POST_VARS[mesini];

$totalpost=$HTTP_POST_VARS[totalpost];
$tothoras=$HTTP_POST_VARS[tothoras];
$totalplantoes=$HTTP_POST_VARS[totplan];
$prox_descricao="$HTTP_POST_VARS[prox_descricao]";
$ultnumseq=$HTTP_POST_VARS[ultnumseq];

//for($f=0;$f<11;$f++)
// {
//  $tmp=$HTTP_POST_VARS["tabord$f"];
//  echo "$tmp<BR>";
// }

include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
for($f=0;$f<11;$f++)
 {
  list($mesini,$trimestre,$libord,$sysopx,$nplant,$saldomes,$saldo_atu,$qtferias,$ferias)=split(";",$HTTP_POST_VARS["tabord$f"]);
  //echo "<p><font face='Courier New' size=2>$mesini - $trimestre - $libord - $sysop - $nplant - $saldomes - $saldo_atu - $qtferias - $ferias Fer $f</font></p>";
  $ultnumseq=$ultnumseq+1;
  $sql = "INSERT INTO tabord (numseq,periodo,trimestre,librod,sysop,nplant,saldomes,saltot,qtferias,ferias) VALUES ('$ultnumseq','$mesini','$trimestre','$libord','$sysopx','$nplant','$saldomes','$saldo_atu','$qtferias','$ferias');";
  //echo "sql $sql<BR>";
  $resultado = mysql_query($sql)
  or die ("N�o foi poss�vel gravar no banco, provavel registro duplicado.");
 }

//echo "TOTPLAN $totalplantoes<BR>";
//echo "TOTHORAS $tothoras<BR>";
//echo "TOTALPOST $totalpost<BR>";
$plantoes=$HTTP_POST_VARS[plantoes];

$mesi=substr($mesini_b,2,2);
$anoi=substr($mesini_b,4,4);
//echo "mesini - $mesini_b - ANOI $anoi<BR>";
$mesf=substr($mesini_b,11,2);
$anof=substr($mesini_b,13,4);

$totalpost=$totalpost+1;

$t=0; $sysop=0; $diaferias[]=0; $cadastroausencia[]=0; $t_dia[]=0; $t_mes[]=0;
$sysopy[]="";
for ($i=0;$i<$totalpost;$i++)
 {
  //echo "$HTTP_POST_VARS[ausente]<BR>";
  $cadastroausencia[$i]=($HTTP_POST_VARS["ausente$i"]);
  if(!empty($cadastroausencia[$i]))
   {
    $t++;
    list($sysopy[$t],$diaferias[$t])=split(";",$cadastroausencia[$i]);
    list($t_dia[$t],$t_mes[$t])=split("/",$diaferias[$t]);
    //echo "Passando $t_mes[$t] - $t_dia[$t] - $anoi - $anof<BR>";
    if(($t_dia[$t] >= 16) AND ($t_dia[$t] <= 31))
      $t_semana[$t]=date("D", mktime(0,0,0,$t_mes[$t],$t_dia[$t],$anoi)); 
    if(($t_dia[$t] >= 1) AND ($t_dia[$t] <= 15))
      $t_semana[$t]=date("D", mktime(0,0,0,$t_mes[$t],$t_dia[$t],$anof));
    //$diasemana[$t]=traduz_semana($t_semana[$t]);
    echo "Indo para traducao: $t_semana[$t]<BR>";
    $t_semana[$t]=traduz_semana($t_semana[$t]);
    $tot_ausencia[$t]="$sysopy[$t];$diaferias[$t]$t_semana[$t]";
    echo " sysopy: $sysopy[$t] - $diaferias[$t] - $t_semana[$t]<BR>";
   }
 }

// Tabord
$i="0"; $tabordnovo="";
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord WHERE periodo='$mesini'";
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

 $i++;
 $tabordnovo[$i]="$numseq-;-$periodo-;-$trimestre-;-$librod-;-$sysop-;-$totalplantoes-;-$tothoras-;-$saltot-;-0-;-0";
 //echo "TABORDNOVO $tabordnovo[$i]<BR>\n";

 $quantferias="0";
 $t=$t+1;
 for($v=0;$v<$t;$v++)
  {
   //echo "$tot_ausencia[$v]<BR>";
   list($t_sysop[$v],$t_diaferias[$v])=split(";",$tot_ausencia[$v]);
   if($sysop == $t_sysop[$v])
    {
     $quantferias++;
     $ferias.=$t_diaferias[$v];
     $totplanferias=($totalplantoes-($quantferias/2));
     //$quantferias=($quantferias/2);
     //echo "totplanferias $totplanferias<BR>";
     //echo "qtf $quantferias<BR>";

     $ferias_num_dias=($quantferias/2);
     $horas_para_ferias=($tothoras-($ferias_num_dias*6));
     //echo "horas para ferias $horas_para_ferias<BR>";
     $tabordnovo[$i]="$numseq-;-$periodo-;-$trimestre-;-$librod-;-$sysop-;-$totplanferias-;-$horas_para_ferias-;-$saltot-;-$ferias_num_dias-;-$ferias";
    }
  }
}

$i=$i+1;
for($replace=0;$replace<$i;$replace++)
 {
  list($numseq,$periodo,$trimestre,$librod,$sysop,$totplan,$tothoras,$saltot,$qtferias,$ferias)=split("-;-",$tabordnovo[$replace]);
  //echo "ComoFicou: $tabordnovo[$replace]<BR>";
  if(!empty($sysop))
   {
    //echo "O que esta gravando: $tabordnovo[$replace]<BR>";
    $sql = "UPDATE tabord SET numseq='$numseq', periodo='$periodo', trimestre='$trimestre', librod='$librod', sysop='$sysop', nplant='$totplan', saldomes='$tothoras', saltot='$saltot', qtferias='$qtferias', ferias='$ferias' WHERE periodo='$mesini' and sysop='$sysop'";
    $resultado = mysql_query($sql)
    or die ("N�o foi poss�vel atualizar a tabord - Tabela OrdemXSaldos");
   }
 }

// --- Consulta de feriado
$temferiado="";
$feriado="";
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabfer WHERE periodo='$mesini'";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $numseq  =$linha["numseq"];
 $periodo =$linha["periodo"];
 $dia     =$linha["dia"];
 $diasem  =$linha["diasem"];
 $descricao_fer=$linha["descricao"];

 //echo "feriado - $periodo<BR>";
 $temferiado="sim";
 //$feriado.="$dia$diasem;";
 $feriado.="$dia";
 $feriado.="$diasem";
 echo "FERIADO: $feriado<BR>";
}
// -- fim do feriado.

// checa pra ver quantos dias tem o mes.
$tmes=date("t", mktime(0,0,0,$mesi,16,$anoi));
//echo "Num.de dias no mes $numdiamesi\n";

$itot=0;
//echo "TEM FERIADO: $temferiado<BR>\n";
//echo "FERIADO - $feriado<BR>\n";
$oqei="";
for($dia=16;$dia<=$tmes;$dia++)   //  tmes eh o num. de dias q tem o mes inicial.
{
 //echo "Dia $dia MesInicial: $mesi - <BR>";
 $english_day=date("D", mktime(0,0,0,$mesi,$dia,$anoi)); 
  // echo "eng: $english_day - <BR>";
  // echo "diastd: $diasemana[$totdia]<BR>";
 $diasemana[$totdia]=traduz_semana($english_day);
 $temferiado=ereg("$dia/$mesi$english_day",$feriado,$oqei);
   // quebra a variavel/vetor feriado e compara. 
   // echo "campara: $oqei[0] ----- $dia/$mesi$english_day<BR>";
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
     //echo "nao eh feriado - $dia/#mesi<BR>";
     $plantao[$itot]="$mesini-;-$dia/$mesi-;-s-;-$diasemana[$totdia]";
     $itot++;
    } 
   if($diasemana[$totdia] == "Dom")
    {
     $plantao[$itot]="$mesini-;-$dia/$mesi-;-d-;-$diasemana[$totdia]";
     $itot++;
    }
   $totdia++;
  }
}

for($dia=1;$dia<16;$dia++)        // do dia 01 ate o dia 15.
{
 //echo "Dia $dia MesFinal: $mesf -";
 $english_day=date("D", mktime(0,0,0,$mesf,$dia,$anof));
 $diasemana[$totdia]=traduz_semana($english_day);
 //echo "Dia da Semana: $diasemana[$totdia]<BR>";
 $temferiado=ereg("$dia/$mesf$english_day",$feriado,$oqei);
 //echo "campara: $oqei[0] ----- $dia/$mesf$english_day<BR>";
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
    $itot++;
   }
   $totdia++;
  }
}

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

//----------------------------------
// Aqui a variavel plantao ja esta incrementada contendo todos os dias da semana,
// todos os dias de plantao.
// echo "Plantoes para o periodo $mesini <BR>"; 
$contadorplantao=0;
$tabplantao[]=0;
$totplan=0; $totdia=0; $totint=0; $tothoras=0;
//echo "itot: $itot<BR>";
for($t=0;$t<$itot;$t++)   // itot eh o numero de dias de plantoes.
 {
  //echo "<font face='Courier' size='2'>$plantao[$t] </font><br>";
  list($tperiodo[$t],$tdia[$t],$tflag[$t],$tdiasemana[$t])=split("-;-",$plantao[$t]); 
   //quebra os plantoes com periodo, dia, feriado, dia da semana.
   //echo "$plantao[$t]<BR>";
   //echo "periodo/dia/flag - $tperiodo[$t] - $tdia[$t] - $tflag[$t] <BR>";
  //echo "tdia: $tdiasemana[$t]<BR>";
  $totalintegrante=ordemsorteada($tdia[$t],$tdiasemana[$t],$acm_o,$tabordnovo);
  //echo "total dia: $totalintegrante<BR>";

  list($totint,$acmmenos)=split("-;-",$totalintegrante);
  if($tflag[$t]=="s")
   {
    $totint=$totint-$acmmenos;
    $totdia=ctrlnumplan($totint,$tflag[$t]);
    //echo "Numero de plantoes para este Sabado dia $tdia[$t] eh de: $totint - $acmmenos totdia $totdia<BR>";

    if($totdia == "4")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-";

    if($totdia == "5")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-";

    if($totdia == "6")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-";

    if($totdia == "7")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-";

    //$tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-";
    $contadorplantao++;
    $totplan++; // =$totplan+$totdia;
   }
  if($tflag[$t]=="d")
   {
    $totint=$totint-$acmmenos;
    $totdia=ctrlnumplan($totint,$tflag[$t]);
    //echo "Numero de plantoes para Domingo dia $tdia[$t] eh de: $totint - $acmmenos totdia $totdia<BR>";
    if($totdia == "4")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-";
   
    if($totdia == "5")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-";

    if($totdia == "6")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-";

    if($totdia == "7")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-";

//    $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-madruga1-;-madruga2-;-manha1-;-manha2-;-tarde1-;-tarde2-;-noite1-;-noite2-;-";
    $contadorplantao++;
    $totplan++; // =$totplan+$totdia;
   }
  if($tflag[$t]=="f")   
   {
    $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-f-;-5-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-";
    $contadorplantao++;
   }
 }


// tabplantoes
$ultnumseq="0";
// nao sei ainda se existe uma funcao para pegar o ultimo registro.
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabpla ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq    = $linha["numseq"];
 $dia       = $linha["dia"];
 $flag      = $linha["flag"];
 $numplan   = $linha["numplan"];
 $madrugaa  = $linha["madrugaa"];
 $madrugab  = $linha["madrugab"];
 $manhaa    = $linha["manhaa"];
 $manhab    = $linha["manhab"];
 $tardea    = $linha["tardea"];
 $tardeb    = $linha["tardeb"];
 $noitea    = $linha["noitea"];
 $noiteb    = $linha["noiteb"];
 //echo "NUMSEQ $numseq<BR>";
 if($numseq > $ultnumseq)
   $ultnumseq=$numseq;
}

$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
for($f=0;$f<$contadorplantao;$f++)
{
 list($periodo,$dia,$flag,$numplant,$madrugaa,$madrugab,$manhaa,$manhab,$tardea,$tardeb,$noitea,$noiteb)=split("-;-",$tabplantao[$f]);
 //echo "TABPLANTAO: $tabplantao[$f]<BR>";
 $db = mysql_select_db($imp_banco);
 $ultnumseq=$ultnumseq+1;
 $sql = "INSERT INTO tabpla (numseq,periodo,dia,flag,numplan,madrugaa,madrugab,manhaa,manhab,tardea,tardeb,noitea,noiteb) VALUES ('$ultnumseq','$periodo','$dia','$flag','$numplant','$madrugaa','$madrugab','$manhaa','$manhab','$tardea','$tardeb','$noitea','$noiteb');";
 $resultado = mysql_query($sql)
 or die ("N�o foi poss�vel realizar a consulta ao banco de dados $ultnumseq $periodo $dia  $flag $numplant  $madrugaa  $madrugab  $manhaa  $manhab  $tardea  $tardeb  $noitea  $noiteb");
}

// tabSALDOS
$ultnumseq="0";
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
 $descricao_ant_ =$linha["descricao"];
 //echo "NUMSEQ $numseq<BR>";
 if($numseq > $ultnumseq)
   $ultnumseq=$numseq;
}
$ultnumseq=$ultnumseq+1;
$sql = "INSERT INTO tabsal(numseq,periodo,ctrl,num,descricao) VALUES ('$ultnumseq','$mesini','c','$totplan','$prox_descricao');";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados $ultnumseq");

// ---------- tabela ordem de preenchimento
Function ordemsorteada($dia,$diaseman)
{
 global $mesini;
 include 'mbcfg.php';
 $acha=""; $diaferias[]="";
 $totintegrante=0; $acmmenosdias=0; $lala=0;
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "SELECT * FROM tabord WHERE periodo='$mesini' ORDER BY numseq";
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
 
  //echo "Dia/Semana: $dia$diaseman <BR>";
  //echo "$periodo - $sysop - $ferias -=- $dia$diaseman<BR>";
  $totintegrante++; //quantas pessoas tem trabalhando no dia.
  $acha=ereg("$dia$diaseman",$ferias,$lala);
  //echo "lala $lala - $ferias<BR>";
  if($acha)
   {
    $acmmenosdias++;           //diminue pelo total de sysop de ferias neste dia.
    //echo "$ferias<BR>";       
    //echo "acm: $acmmenosdias<BR>";
   }
}
  return("$totintegrante-;-$acmmenosdias");
}

Function ctrlnumplan($totint,$flag)
{
 switch($totint)
 {
   case 13:
        if($flag == "s")
           $totdia=7;
        else
           $totdia=6;
        break;
   case 12:
        if($flag == "s")
           $totdia=6;
        else
           $totdia=6;
        break;
   case 11:
        if($flag == "s")
           $totdia=5;
        else
           $totdia=6;
        break;
   case 10:
        if($flag == "s")
           $totdia=5;
        else
           $totdia=5;
        break;
   case 9:
        if($flag == "s")
           $totdia=4;
        else
           $totdia=5;
        break;
   case 8:
        if($flag == "s")
           $totdia=4;
        else
           $totdia=4;
        break;
 }
 return($totdia);
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

echo "<hr><BR>";
include 'plantoes.php';
?>