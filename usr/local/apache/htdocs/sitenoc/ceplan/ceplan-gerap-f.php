<?
// Ultimo passo para gerar o periodo. aqui grava no banco.

//Eh obrigatorio que este script seja chamado pelo "$obriga":
$obriga="gera";
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
 $mesg="";
 naoabre($mesg);
 exit;
}

$ultperiodo=$HTTP_POST_VARS['ultperiodo'];
//echo "ult periodo $ultperiodo<BR>";
$acm=$HTTP_POST_VARS['acm'];
$tothoras=$HTTP_POST_VARS['tothoras'];
$totplan=$HTTP_POST_VARS['totplan'];

if(empty($tothoras))
  echo "PROBLEMA tothoras<BR>";

if(empty($totplan))
  echo "PROBLEMA totplan <BR>";

$nomes[]="";
for($a=1;$a<$acm;$a++)
{ 
 $nomes[$a]=$HTTP_POST_VARS["nome$a"];
 //echo "$a - $nomes[$a]<BR>";
}

$prox_descricao="$HTTP_POST_VARS[prox_descricao]";

$mesini=$HTTP_POST_VARS[proxperiodo];
$mesi=substr($mesini,2,2);
$anoi=substr($mesini,4,4);
$mesf=substr($mesini,11,2);
$anof=substr($mesini,13,4);

$totalpost=$HTTP_POST_VARS['acm'];
$totalpost=($totalpost*11); // total de sysop multiplicado pelo nu. de final de semana, "11 eh impossivel q tenha".


// Verifica quem estara ausente - incrementa variavel CADASTROAUSENTE. --------------------------------
//echo "TOTALPOST $totalpost<BR>";
$t=0; $sysop=0; $diaferias[]=0; $cadastroausencia[]=0; $t_dia[]=0; $t_mes[]=0; $sysopy[]="";
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
    //echo "Indo para traducao: $t_semana[$t]<BR>";
    $t_semana[$t]=traduz_semana($t_semana[$t]);
    $tot_ausencia[$t]="$sysopy[$t];$diaferias[$t]$t_semana[$t]";
    //echo " sysopy: $sysopy[$t] - $diaferias[$t] - $t_semana[$t]<BR>";
   }
 }
$t++;

// incrementa a variavel TAB_ORDEM - AUSENTE vs PRESENTES. ----------------------------------------------
$i_acm="0";
for($a=1;$a<$acm;$a++)
{
 //echo "ACM $a - $nomes[$a]<BR>";
 $quantferias="0"; $ferias="";
 $i_acm++;

 if($t > 1)
 {
  for($v=1;$v<$t;$v++)
   {
    list($t_sysop,$t_diaferias)=split(";",$tot_ausencia[$v]);
    //echo "v $v $tot_ausencia[$v]<BR>";
    if($nomes[$a] == $t_sysop)
     {
      $quantferias++;
      $ferias.="$t_diaferias";
      $totplanferias=($totalplantoes-($quantferias/2));
      $ferias_num_dias=($quantferias/2);
      $horas_para_ferias=($tothoras-($ferias_num_dias*6));
                                             // nplant - saldomes - qtferias - ferias
     }
    $tabordnovo[$i_acm]="$nomes[$a]-;-$totplanferias-;-$horas_para_ferias-;-$ferias_num_dias-;-$ferias";
    if(($nomes[$a] != $t_sysop) AND (empty($ferias)))
      $tabordnovo[$i_acm]="$nomes[$a]-;-0-;-0-;-0-;-0";
   }
 } 

 if($t <= 1)
  $tabordnovo[$i_acm]="$nomes[$a]-;-0-;-0-;-0-;-0";

} 

//for($a=1;$a<$i_acm;$a++)
//{
//  echo "$i_acm $a TN $tabordnovo[$a]<BR>";
//}

// consulta do saldo dos sysops do ultimo mes (ultperiodo). ------------------------------------------------------
// e incrementa a variavel tabordnovo ---------------------------------------------------------------------------
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$tabordnovasaldo[]=""; $acm_sobra="";
$jahpasou="FALSE";
for($a=0;$a<=$i_acm;$a++)
{
 list($new_sysop,$new_nplant,$new_saldomes,$new_qtferias,$new_ferias)=split("-;-",$tabordnovo[$a]);
 //echo "$acm $a $new_sysop TNNNN $tabordnovo[$a]<BR>";
 //echo "ultperido: $ultperiodo<BR>";
 //echo "NOVOS VALORES $totplan - $tothoras<BR>";
 $sql = "SELECT * FROM tabord WHERE periodo='$ultperiodo' AND sysop='$new_sysop'";
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

  echo "$new_sysop ESTAVA COM $saldomes<BR>";
  if(!empty($sysop))
   {
    if($saldomes <= 0)
     {
      $converte=($saldomes)*(-1);
      $saltot=$saltot+$converte;
     }
    if($saldomes > 0)
     $saltot=$saltot-$saldomes;
 
    // nplant = saldomes - saltot - qtferias - ferias
    //echo "new-qtferias $new_qtferias<BR>";
    if(empty($new_qtferias))
     {
      //echo "77: $new_sysop<BR>";
      $tabordnovasaldo[$a]="$new_sysop-;-$mesini-;-$totplan-;-$tothoras-;-$saltot-;-0-;-0";
      //echo "VAI FICAR 77: $tabordnovasaldo[$a]<BR>";
     }
    if(!empty($new_qtferias))
     {
      //echo "88: $new_sysop --- - - $new_saldomes<BR>";
      $bbb=($totplan)-(-$new_nplant);
      $tabordnovasaldo[$a]="$new_sysop-;-$mesini-;-$bbb-;-$new_saldomes-;-$saltot-;-$new_qtferias-;-$new_ferias";
      //echo "VAI FICAR 88: $tabordnovasaldo[$a]<BR>";
      $japrocessado="$new_sysop";
     }
   }
 }
 if(empty($tabordnovasaldo[$a]))
  {
   $japrocesasdo=$new_sysop;
   //$sysop="$new_sysop";
   //echo "99 new jahproce: $new_sysop<BR>";
   $tabordnovasaldo[$a]="$new_sysop-;-$mesini-;-$totplan-;-$tothoras-;-0-;-0-;-0";
   //echo "VAI FICAR 99: $tabordnovasaldo[$a]<BR>";
   $sobra="OK";
   $acm_sobra++;
  }
}

$i_acm=($i_acm+$acm_sobra);

//for($a=0;$a<$i_acm;$a++)
//{
// echo "INSERT $tabordnovasaldo[$a]<BR>";
//}

$english_day=0; $traduz_semana=0; $diasemana[]=0; 

// verifica pra ver quantos dias tem o mes.
$tmes=date("t", mktime(0,0,0,$mesi,16,$anoi));
//echo "Num.de dias no mes $numdiamesi\n";

$totdia=0;
$plantao[]=0; $itot=0;

// --- verifica se tem feriado ------------------------------------------------------------
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
 $descricao=$linha["descricao"];

 //echo "feriado - $periodo<BR>";
 $temferiado="sim";
 $feriado.="$dia$diasem;";
}
// -------------------------------------- fim do feriado.

// checa pra ver quantos dias tem o mes.
$tmes=date("t", mktime(0,0,0,$mesi,16,$anoi));
//echo "Num.de dias no mes $numdiamesi\n";

$itot=0;
//echo "TEM FERIADO: $temferiado<BR>\n";
//echo "FERIADO - $feriado<BR>\n";
$oqei="";

//  procura pelos finais de semana ----------------------------------------------------------------------
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
// fim da procura pelos finais de semana ---------------------------------------------------------------


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

// Aqui a variavel plantao ja esta incrementada contendo todos os dias da semana,
// todos os dias de plantao.
// echo "Plantoes para o periodo $mesini <BR>";
$contadorplantao=0; $tabplantao[]=0; $totplan=0; $totdia=0; $totint=0; $tothoras=0; $totalintegrante=0;
//echo "itot: $itot<BR>";
for($t=0;$t<$itot;$t++)   // itot eh o numero de dias de plantoes.
 {
  //echo "<font face='Courier' size='2'>$plantao[$t] </font><br>";
  list($tperiodo[$t],$tdia[$t],$tflag[$t],$tdiasemana[$t])=split("-;-",$plantao[$t]);
   //quebra os plantoes com periodo, dia, feriado, dia da semana.
   //echo "$plantao[$t]<BR>";
   //echo "periodo/dia/flag - $tperiodo[$t] - $tdia[$t] - $tflag[$t] <BR>";
  //echo "tdia: $tdiasemana[$t]<BR>";
  $totalintegrante=ordemsorteada($tdia[$t],$tdiasemana[$t],$acm,$tabordnovasaldo);
  //echo "total dia: $totalintegrante<BR>";

  list($totint,$acmmenos)=split("-;-",$totalintegrante);
  echo "TOTIN $totint ACMME $acmmenos - $totalintegrante<BR>";
  if($tflag[$t]=="s")
   {
    $totint=$totint-$acmmenos;
    $totdia=ctrlnumplan($totint,$tflag[$t]);
    echo "Numero de plantoes para este Sabado dia $tdia[$t] eh de: $totint - $acmmenos totdia $totdia<BR>";

    if($totdia == "4")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-";

    if($totdia == "5")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-";

    if($totdia == "6")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-";

    if($totdia == "7")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-";

    $contadorplantao++;
    $totplan++; // =$totplan+$totdia;
   }
  if($tflag[$t]=="d")
   {
    $totint=$totint-$acmmenos;
    $totdia=ctrlnumplan($totint,$tflag[$t]);
    echo "Numero de plantoes para Domingo dia $tdia[$t] eh de: $totint - $acmmenos totdia $totdia<BR>";

    if($totdia == "4")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-";

    if($totdia == "5")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-";

    if($totdia == "6")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-";

    if($totdia == "7")
      $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-n-;-$totdia-;-preencher-;-vazio-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-preencher-;-";
	  
    $contadorplantao++;
    $totplan++; // =$totplan+$totdia;
   }
  if($tflag[$t]=="f")
   {
    $tabplantao[$contadorplantao]="$mesini-;-$tdia[$t]-$tdiasemana[$t]-;-f-;-5-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-preencher-;-vazio-;-";
    $contadorplantao++;
   }
 }


 $libera="TRUE";

// ----------------------- controle para evitar registro duplicado e ou refresh no browser. --inicio
 include ('mbcfg.inc');
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);

 $testa_mesini="";
 $sql = "SELECT periodo FROM tabord WHERE periodo='$mesini'";
 $resultado = mysql_query($sql)
 or die ("Nao foi possivel realizar a consulta ao banco de dados AA ");
 while ($linha=mysql_fetch_array($resultado))
 {
  $testa_mesini=$linha["periodo"];
  if(!empty($testa_mesini))
    $libera="FALSE";
 }
 if($libera == "FALSE")
  {
   $mesg="Jah possui dados na tabela de ordem de preenchimento para o periodo $mesini";
   naoabre($mesg);
   exit;
  }  

 $testa_mesini="";
 $sql = "SELECT periodo FROM tabsal WHERE periodo='$mesini'";
 $resultado = mysql_query($sql)
 or die ("Nao foi possivel realizar a consulta ao banco de dados BB");
 while ($linha=mysql_fetch_array($resultado))
 {
  $testa_mesini=$linha["periodo"];
  if(!empty($testa_mesini))
    $libera="FALSE";
 }
 if($libera == "FALSE")
  {  
   $mesg="Jah possui dados na tabela de saldos para o periodo $mesin";
   naoabre($mesg);
   exit;
  }  

 $testa_mesini="";
 $sql = "SELECT periodo FROM tabpla WHERE periodo='$mesini'";
 $resultado = mysql_query($sql)
 or die ("Nao foi possivel realizar a consulta ao banco de dados CC");
 while ($linha=mysql_fetch_array($resultado))
 {
  $testa_mesini=$linha["periodo"];
  if(!empty($testa_mesini))
    $libera="FALSE";
 }
 if($libera == "FALSE")
  {
   $mesg="Jah possui dados na tabela de plantoes para o periodo $mesin";
   naoabre($mesg);
   exit;
  }
// ----------------------- controle para evitar registro duplicado e ou refresh no browser. --fim


if($libera == TRUE)
{
  // TABPLA
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 for($f=0;$f<$contadorplantao;$f++)
 {
  list($inperiodo[$f],$india[$f],$inflag[$f],$innumplant[$f],$inmadrugaa[$f],$inmadrugab[$f],$inmanhaa[$f],$inmanhab[$f],$intardea[$f],$intardeb[$f],$innoitea[$f],$innoiteb[$f])=split("-;-",$tabplantao[$f]);
  //echo "TABPLANTAO: $tabplantao[$f]<BR>";
  $db = mysql_select_db($imp_banco);
  $sql = "INSERT INTO tabpla (periodo,dia,flag,numplan,madrugaa,madrugab,manhaa,manhab,tardea,tardeb,noitea,noiteb) VALUES ('$inperiodo[$f]','$india[$f]','$inflag[$f]','$innumplant[$f]','$inmadrugaa[$f]','$inmadrugab[$f]','$inmanhaa[$f]','$inmanhab[$f]','$intardea[$f]','$intardeb[$f]','$innoitea[$f]','$innoiteb[$f]');";
  //echo "SQL $sql<BR>";
  $resultado = mysql_query($sql)
   or die ("N�o foi poss�vel realizar a consulta ao banco de dados tabpla- $periodo $dia  $flag $numplant  $madrugaa  $madrugab  $manhaa  $manhab  $tardea  $tardeb  $noitea  $noiteb");
 } 

 // TABORD
 for($f=0;$f<$i_acm;$f++)
 {
  list($insysop[$f],$intrimestre[$f],$innplant[$f],$insaldomes[$f],$insaldoatu[$f],$inqtferias[$f],$inferias[$f])=split("-;-",$tabordnovasaldo[$f]);
  //echo "IN $insysop[$f] - $tabordnovasaldo[$f]<BR>";
  //echo "<p><font face='Courier New' size=2>$mesini - $trimestre - $libord - $sysop - $nplant - $saldomes - $saldo_atu - $qtferias- $ferias Fer $f</font></p>";
  if(!empty($insysop[$f]))
   {
    $sql = "INSERT INTO tabord (periodo,sysop,trimestre,nplant,saldomes,saltot,qtferias,ferias,librod) VALUES  ('$mesini','$insysop[$f]','$intrimestre[$f]','$innplant[$f]','$insaldomes[$f]','$insaldoatu[$f]','$inqtferias[$f]','$inferias[$f]','0');";
    //echo "sql $sql<BR>";
    $resultado = mysql_query($sql)
     or die ("N�o foi poss�vel gravar no banco, provavel registro duplicado.");
   }
 }

 // tabSALDOS
 $ultnumseq="0";
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "INSERT INTO tabsal (periodo,ctrl,num,descricao) VALUES ('$mesini','c','$totplan','$prox_descricao');";
 $resultado = mysql_query($sql)
 or die ("N�o foi poss�vel realizar a consulta ao banco de dados tabsal - $ultnumseq");


echo "Periodo $mesini cadastrado<BR>";
}

Function ctrlnumplan($totint,$flag)
{
 // 13 eh o numero de sysops trabalhando atualmente na equipe (Abril/2004).
 switch($totint)
 {
   case 14:
        if($flag == "s")
           $totdia=7;
        else
           $totdia=7;
        break;
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

// baseado na tabela da ordem, subtrai pelos que estaram ausentes.
Function ordemsorteada($dia,$diaseman,$acm,$tabordnovasaldo)
{
 //echo "$acm - tabordnovosaldo<BR>";
 for($a=1;$a<$acm;$a++)
 {
  $totintegrante++;
  //echo "TABNOVO $tabordnovasaldo[$a]<BR>";
  list($sysop,$lixoa,$lixob,$lixoc,$lixod,$lixoe,$ferias)=split("-;-",$tabordnovasaldo[$a]);
  $acha=ereg("$dia$diaseman",$ferias,$lala);
  //echo " - $ferias<BR>";
  if($acha)
   {
    $acmmenosdias++;           //diminue pelo total de sysop de ferias neste dia.
    //echo "FERIAS $ferias<BR>";  //echo "acm: $acmmenosdias<BR>";
   }
 } 
  //echo "retornando $totintegrante  $acmmenosdias <BR>";
  return("$totintegrante-;-$acmmenosdias");
}

Function naoabre($mesg)
{
 echo "$mesg<BR>";
}

?>
