<?
// Alterado em 14/Julho/2003 - Nao estava pegando o feriado de domingo a noite duplo.
//
//
//Eh obrigatorio que este script seja chamado pelo "$obriga":
$obriga="cadpla.php";
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

$ctrlrefresh="ctrlmarcacao.sys";
$fd = fopen ("$ctrlrefresh", "r");
while (!feof ($fd))
 {
  $buffer = fgets($fd, 4096);
  $minusculo=strtolower($HTTP_POST_VARS[sysop]);
  $efecinco=ereg($minusculo,$buffer);
  //echo "$buffer<BR>\n";
  // se o camarada tecler F5 (efecinco) deve chamar erro, caso contrario iria diminuir do saldo do banco.
  if($efecinco)
   {
    naoabre();
    exit;
   }
 }
fclose($fd);

$sysop=$HTTP_POST_VARS[sysop];
//echo "$sysop foi quem preencheu.<BR>";

$permitido=$HTTP_POST_VARS[permitido];
 if(empty($permitido))
  {
   naoabre();
   exit;
  }

//echo "PERMITIDO $permitido<BR>";
$saldo=$HTTP_POST_VARS[saldo];
//echo "saldo: $saldo<BR>";
$nperiodo=$HTTP_POST_VARS[nperiodo];
//echo "No periodo $nperiodo<BR>";

$faltapreencher=$HTTP_POST_VARS[faltapreencher];

Global $marcacao;
$marcacao[]=0; $acm=0; $acmferiado=0;

// Faz um for de ate 100 para ver quais dias foram marcados.
for($i=0;$i<100;$i++)
 {
   $ma=$HTTP_POST_VARS["ma$i"];
   if(!empty($ma))
    {
     $marcacao[$acm]=$ma;
     $acm++;
    }
   $mh=$HTTP_POST_VARS["mh$i"];
   if(!empty($mh))
    {
     $marcacao[$acm]=$mh;
     $acm++;
    }
   $mi=$HTTP_POST_VARS["mi$i"];
   if(!empty($mi))
    {
     $marcacao[$acm]=$mi;
     $acm++;
    }
   $ta=$HTTP_POST_VARS["ta$i"];
   if(!empty($ta))
    {
     $marcacao[$acm]=$ta;
     $acm++;
    }
   $tb=$HTTP_POST_VARS["tb$i"];
   if(!empty($tb))
    {
     $marcacao[$acm]=$tb;
     $acm++;
    }
   $na=$HTTP_POST_VARS["na$i"];
   if(!empty($na))
    {
     $marcacao[$acm]=$na;
     $acm++;
    }
   $nb=$HTTP_POST_VARS["nb$i"];
   if(!empty($nb))
    {
     $marcacao[$acm]=$nb;
     $acm++;
    }
  $maferiado=$HTTP_POST_VARS["maferiado$i"];
  if(!empty($maferiado))
   {
    //echo "maf $maferiado<BR>\n";
    $marcacao[$acm]=$maferiado;
    $acm++;
    $acmferiado++;
   }
  $mhferiado=$HTTP_POST_VARS["mhferiado$i"];
  if(!empty($mhferiado))
   {
    //echo "mHf $maferiado<BR>\n";
    $marcacao[$acm]=$mhferiado;
    $acm++;
    $acmferiado++;
   }
  $miferiado=$HTTP_POST_VARS["miferiado$i"];
  if(!empty($miferiado))
   {
    //echo "mIf $miferiado<BR>\n";
    $marcacao[$acm]=$miferiado;
    $acm++;
    $acmferiado++;
   }
  $taferiado=$HTTP_POST_VARS["taferiado$i"];
  if(!empty($taferiado))
   {
    $marcacao[$acm]=$taferiado;
    $acm++;
    $acmferiado++;
   }
  $naferiado=$HTTP_POST_VARS["naferiado$i"];
  if(!empty($naferiado))
   {
    $marcacao[$acm]=$naferiado;
    $acm++;
    $acmferiado++;
   }
  $nbferiado=$HTTP_POST_VARS["nbferiado$i"];
  if(!empty($nbferiado))
   {
    $marcacao[$acm]=$nbferiado;
    $acm++;
    $acmferiado++;
   }
 }

// Verifica se foi marcado mais de um plantao/pago.
$limite=$acm-$acmferiado;

if($acmferiado > 1)
 {
  $mesg="Escolha somente 1 feriado.";
  $permitido="1";
  chamaerro($mesg,$permitido); exit;
 }

if(empty($acm))
 {
  $mesg="Voce nao escolheu nenhum plantao!!!";
  $permitido="";
  chamaerro($mesg,$permitido); exit;
 }

//echo "ACM $acm<BR>\n";
//echo "faltapreencher $faltapreencher<BR>";
if($limite != $permitido) 
 {
  if($faltapreencher !=1)
  {
   //$mesg="Voce deve preencher somente o numero de plantoes permitido.";
   $mesg="<font face='Courier New' size='2' color='#FF0000'>Voce deve preencher somente o numero de plantoes permitido.</font>";
   print $mesg;
   chamaerro($mesg,$permitido); exit;
  }
  if($faltapreencher == 1)
  {
   $permitido=1;
  }
 }

// Ate aqui trata o que deve ser preenchido.
// ------------
$mesini=$HTTP_POST_VARS[mesini];
Global $mesini;

include 'mbcfg.php';
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabpla WHERE periodo='$mesini' ORDER BY `numseq`;";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");

$i=0; 
$ptot=0; // server para o controle de envio de email.
$tabnew="";

// faz o split do array
while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq    = $linha["numseq"];
 $periodo   = $linha["periodo"];
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

 //echo "DIA $mesini - $dia<BR>";
 $tp="ma"; // tp = turno preenchido.
 $recretornoma=rec($dia,$marcacao,$tp);
 //echo "retorna: $recretornoma<BR>";

 if(!empty($recretornoma))
 {
  $ptot++;
  //echo "RetorMaDRUGA: $recretornoma<BR>\n";
  //echo "$dia - Madrugada 1h as 7hs<BR>";
  $preenchido[$ptot]="$dia - Madrugada 1h as 7hs";
  list($recdata,$recturno)=split(";",$recretornoma);
  $madrugaa=$sysop;
  $ctrl="OK";
 }

 $tp="mh";
 $recretornomh=rec($dia,$marcacao,$tp);
 if(!empty($recretornomh))
 {
  $ptot++;
  //echo "RetoMANHA: $recretornomh<BR>\n";
  //echo "$dia - Manha 7hs as 13hs<BR>";
  $preenchido[$ptot]="$dia - Manha 7hs as 13hs";
  list($recdata,$recturno)=split(";",$recretornomh);
  $manhaa=$sysop;
  $ctrl="OK";
 }

 $tp="mi";
 $recretornomi=rec($dia,$marcacao,$tp);
 if(!empty($recretornomi))
 {
  $ptot++;
  //echo "RetoMANHAi: $recretornomi<BR>\n";
  //echo "$dia - Manha 7hs as 13hs B<BR>";
  $preenchido[$ptot]="$dia - Manha 7hs as 13hs b";
  list($recdata,$recturno)=split(";",$recretornomi);
  $manhab=$sysop;
  $ctrl="OK";
 }

 $tp="ta";
 $recretornota=rec($dia,$marcacao,$tp);
 if(!empty($recretornota))
 {
  $ptot++;
  //echo "RetoTardeA: $recretornota<BR>\n";
  //echo "$dia - Tarde 13hs as 19hs<BR>";
  $preenchido[$ptot]="$dia - Tarde 13hs as 19hs";
  list($recdata,$recturno)=split(";",$recretornota);
  $tardea=$sysop;
  $ctrl="OK";
 }

 $tp="tb";
 $recretornotb=rec($dia,$marcacao,$tp);
 if(!empty($recretornotb))
 {
  $ptot++;
  //echo "$dia - Tarde 13hs as 19hs<BR>";
  $preenchido[$ptot]="$dia - Tarde 13hs as 19hs b";
  list($recdata,$recturno)=split(";",$recretornotb);
  $tardeb=$sysop;
  $ctrl="OK";
 }

 $tp="na";
 $recretornona=rec($dia,$marcacao,$tp);
 if(!empty($recretornona))
 {
  $ptot++;
  //echo "RetoNOITEa: $recretornona<BR>\n";
  //echo "$dia - Noite 19hs a 1h<BR>";
  $preenchido[$ptot]="$dia - Noite 19h a 1h";
  list($recdata,$recturno)=split(";",$recretornona);
  $noitea=$sysop;
  $ctrl="OK";
 }

 $tp="nb";
 $recretornonb=rec($dia,$marcacao,$tp);
 if(!empty($recretornonb))
 {
  $ptot++;
  //echo "RetoNOITEBEB: $recretornonb<BR>\n";
  //echo "$dia - Noite 19hs a 1h<BR>";
  $preenchido[$ptot]="$dia - Noite 19h a 1h b";
  list($recdata,$recturno)=split(";",$recretornonb);
  $noiteb=$sysop;
  $ctrl="OK";
 }

 //Feriados
 $tp="maferiado";
 $recretornomaferiado=rec($dia,$marcacao,$tp);
 if(!empty($recretornomaferiado))
 {
  $ptot++;
  //echo "Feriado Madru: $recretornomaferiado<BR>\n";
  //echo "$dia - Madrugada 1h as 7hs<BR>";
  $preenchido[$ptot]="Feriado $dia - Madrugada 1h as 7hs";
  list($recdata,$recturno)=split(";",$recretornomaferiado);
  $madrugaa=$sysop;
  $ctrl="OK";
 }

 $tp="mhferiado";
 $recretornomhferiado=rec($dia,$marcacao,$tp);
 if(!empty($recretornomhferiado))
 {
  $ptot++;
  //echo "Feriado Manha: $recretornomhferiado<BR>\n";
  //echo "$dia - Manha 7hs as 19hs<BR>";
  $preenchido[$ptot]="Feriado $dia - Manha 7hs as 13hs";
  list($recdata,$recturno)=split(";",$recretornomhferiado);
  $manhaa=$sysop;
  $ctrl="OK";
 }

 $tp="taferiado";
 $recretornotaferiado=rec($dia,$marcacao,$tp);
 if(!empty($recretornotaferiado))
 {
  $ptot++;
  //echo "Feriado Tarde: $recretornotaferiado<BR>\n";
  //echo "$dia - Tarde 13hs as 19hs <BR>";
  $preenchido[$ptot]="Feriado $dia - Tarde 13hs as 19hs";
  list($recdata,$recturno)=split(";",$recretornotaferiado);
  $tardea=$sysop;
  $ctrl="OK";
 }

 $tp="naferiado";
 $recretornonaferiado=rec($dia,$marcacao,$tp);
 if(!empty($recretornonaferiado))
 {
  $ptot++;
  //echo "Feriado Noite A: $recretornonaferiado<BR>\n";
  //echo "$dia - Noite 19hs a 1h <BR>";
  $preenchido[$ptot]="Feriado $dia - Noite 19hs a 1h";
  list($recdata,$recturno)=split(";",$recretornonaferiado);
  $noitea=$sysop;
  $ctrl="OK";
 }

 $tp="nbferiado";
 $recretornonbferiado=rec($dia,$marcacao,$tp);
 if(!empty($recretornonbferiado))
 {
  $ptot++;
  //echo "Feriado Noite B: $recretornonbferiado<BR>\n";
  //echo "$dia - Noite 19hs a 1h <BR>";
  $preenchido[$ptot]="Feriado $dia - Noite 19hs a 1h b";
  list($recdata,$recturno)=split(";",$recretornonbferiado);
  $noiteb=$sysop;
  $ctrl="OK";
 }

 if ($ctrl== "OK")
  {
   $i++;
   //echo "$i: SQL UPDATE - $numseq : $madrugaa  - $manhaa<BR>";
   $tabnew[$i]="$numseq-;-$periodo-;-$dia-;-$flag-;-$numplan-;-$madrugaa-;-$madrugab-;-$manhaa-;-$manhab-;-$tardea-;-$tardeb-;-$noitea-;-$noiteb";
   //echo "SQL UPDATE $tabnew[$i]<BR>";
   $ctrl="";
  }

}

//echo "$i registro alterado<BR>";
$numseq="";$periodo="";$dia="";$flag="";$numplan="";$madrugaa="";$madrugab="";$manhaa="";$manhab="";$tardea=""; $tardeb="";$noitea="";$noiteb="";
$x=0;
$i++;
while ($x < $i)
{
 list($numseq[$x],$periodo[$x],$dia[$x],$flag[$x],$numplan[$x],$madrugaa[$x],$madrugab[$x],$manhaa[$x],$manhab[$x],$tardea[$x],$tardeb[$x],$noitea[$x],$noiteb[$x])=split("-;-",$tabnew[$x]); 

 //echo "$x: SQL: $numseq[$x] : $madrugaa[$x]<BR>";
 //echo "$tabnew[$x]<BR>";

 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "UPDATE tabpla SET numseq='$numseq[$x]',periodo='$periodo[$x]',dia='$dia[$x]',flag='$flag[$x]',numplan='$numplan[$x]',madrugaa='$madrugaa[$x]',madrugab='$madrugab[$x]',manhaa='$manhaa[$x]', manhab='$manhab[$x]',tardea='$tardea[$x]',tardeb='$tardeb[$x]',noitea='$noitea[$x]',noiteb='$noiteb[$x]' WHERE numseq='$numseq[$x]';";
 $resultado = mysql_query($sql)
 or die ("Não foi possível realizar a consulta ao banco de dados");
 //echo "<h1>Registro alterado com sucesso!</h1>";
 $x++;
}

// Grava  ------------
Function rec($dia,$marca,$tp)
{
 //echo "Dia: $dia pp Marcacao $marca[0]<BR>\n";
 $acm=60;
 for($i=0;$i<$acm;$i++)
 {
  //echo "marca $marca[$i]<BR>";
  list($turno[$i],$data[$i])=split(";",$marca[$i]);
  //echo "eco: $dia --- $data[$i]  E $turno[$i] -- $tp <BR>\n";
  if(($dia == $data[$i]) AND ($turno[$i] == $tp)) //OR ($turno[$i] == "mh")))
   {
    //echo "OI<BR>";
    $recretorno="$data[$i];$turno[$i]";
    //echo "Vai retornar: $data[$i] <> $turno[$i]<BR>\n";
    //echo "$data[$i] - Horario: $turno[$i]<BR>\n";
    $i=$acm;  
   }
  }
 return ($recretorno);
}

// ------begin erro-----
Function chamaerro($mesg,$permitido)
 {
  if(empty($permitido))
   {
   //echo "$mesg";
   echo "<p><font face='Courier New' size='2' color='#FF0000'>$mesg</font></p>";
   echo "<p><a href=\'javascript:history.back()\'><font face='Courier New' size='2'>Voltar</font></a></p>";
   }
  else
   {
   echo "<BR><font face='Courier New' size='2'>Eh permitido $permitido plantao(oes)</font>";
   echo "<p><a href='javascript:history.back()'><font face='Courier New' size='2'>Voltar</font></a></p>";
   }
 }

// ------end erro -----

// se esta variavel for FALSE sinal q dah pra fechar o periodo, nao existe mais a TAG preencher.
/*
$periodofechado="";
//echo "ACM_p: $acm_p";
for($i=0;$i<$acm_p;$i++)
 {
 //echo "como_ficou: $tabnew[$i]<BR>";
 $periodofechado=ereg('preencher',$tabnew[$i]);
 if(($periodofechado) and ($acm_p != $i))
  $i=$acm_p;
 else
  if((!$periodofechado) and ($acm_p == $i))
   $i=$acm_p;
 }
*/

// Mexe no tabORDEM
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord WHERE periodo='$mesini' and sysop='$sysop'";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
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

 //echo "BEFORE: nplant $nplant<BR>";
 //echo "BEFORE: permi  $permitido<BR>";

 $nplant=($nplant-$permitido);
 $saldomes=$saldomes-($permitido*6);

 //echo "AFTER: saldomes $saldomes<BR>";
 //echo "AFTER: nplant $nplant<BR>";
}

$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "UPDATE tabord SET numseq='$numseq', periodo='$mesini', trimestre='$trimestre', librod='$librod', sysop='$sysop', nplant='$nplant', saldomes='$saldomes', saltot='$saltot', qtferias='$qtferias', ferias='$ferias' WHERE periodo='$mesini' and sysop='$sysop'";
$resultado = mysql_query($sql)
or die ("Não foi possível atualizar a tabord - Tabela OrdemXSaldos");


// Controle para ver se o preenchemnto acabou, se o periodo deve ser finalizado.
$acabou="";
$acabou=($faltapreencher-$permitido);
if($acabou <= 0)
 {
  //echo "O periodo deve ser fechado, nao existe mais a TAG preencher.<BR>\n";
  $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
  $db = mysql_select_db($imp_banco);
  $sql = "UPDATE tabsal SET ctrl='f' WHERE periodo='$mesini'";
  $resultado = mysql_query($sql)
  or die ("Não foi possível realizar a consulta ao banco de dados");
  //echo "<h1>Registro alterado com sucesso!</h1>";
 }
//echo "Ainda falta $acabou<BR>";
include 'mbcfg.php';
$today=date("d/m/Y H:i");
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabsal WHERE periodo='$mesini'";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
 {
  $numseq    =$linha["numseq"];
  $periodo   =$linha["periodo"];
  $ctrl      =$linha["ctrl"];
  $num       =$linha["num"];
  $descricao =$linha["descricao"];
  echo "<font size='2' face='Courier New'>Periodo: $descricao<BR>";
  $assunto="[Ceplan] Periodo: $descricao";
  $messagesid=$periodo;
 }

echo "<font size='2' face='Courier New'><b>$sysop preencheu  em: $today os seguintes horarios:</b><BR>";
$ptot++;
for($i=0;$i<$ptot;$i++)
 echo "<font size='2' face='Courier New'>$preenchido[$i]<BR>";

// Envio do email para lista informado os plantoes preenchidos e o nome do proximo sysop q deve preencher o plantao.
$texto="";
// manda o email
$sysop=strtolower($sysop);
$isysop=$HTTP_SERVER_VARS[PHP_AUTH_USER];
//$email.="$isysop@terra.com.br";
$email.="$imp_emailto";
$mailheaders="From: ".$isysop ."<$email>\n";
$mailheaders.="Reply-To: ."<"$email>\n";
$mailheaders.="Content-transfer-encoding: 7BIT\n";
$mailheaders.="References: <$messagesid.trrceplan@terra.com.br>\n";
$mailheaders.="Return-Path: <$email>\n";
$mailheaders.="Message-id: <$messagesid.trrceplan@terra.com.br>\n";
$mailheaders.="IP: "."<$REMOTE_ADDR>\n";
$mailheaders.="X-mailer: XServer\n";

if($acabou <= 0)
 $mailheaders.="Comments: OKA\n";

$mailheaders.="MIME-version: 1.0\n";
$subject="$assunto";
$texto="$sysop preencheu em: $today os seguintes horarios:\n";
for($i=0;$i<$ptot;$i++)
  $texto.="$preenchido[$i]\n";
$texto.="---\n";

$prox_sysop=proximo_da_lista($mesini);
// Caso nao tenha mais a TAG preencher eh sinal q acabou o preenchimeno, logo nao tem o proximo marcador.
if($acabou > 0)
 $texto.="PROXIMO: $prox_sysop\n";
else
 $texto.="Periodo encerrado.\n";

$texto.="\n"; 
$texto.="http://aquario.terra.com.br/ceplan/\n";
$texto.="--[Ceplan]--\n";

mail("$imp_emailto", $subject, $texto, $mailheaders);

$fd = fopen ("ctrlmarcacao.sys", "w") 
or die ("Erro na aberturado do arquivo temporario");
fputs($fd, $sysop ."$today");
fputs($fd, $fim."\n");
fclose($fd);

echo "<p>&nbsp;</p>
<hr>";
include 'plantoes.php';

// - erro
Function naoabre()
{
 print "<html>";
 print "<head>";
 print "<meta http-equiv=\"Content-Language\" content=\"en-us\">";
 print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1252\">";
 print "<title>error</title>";
 print "</head>";
 print "<body>";
 //print "<p><font face=\"Courier New\">erro.</font></p>";
 print "<p><font face='Courier New' size='2'><a href='/'>Capa</a> <a href='/'></font></p>";
 print "</body>";
 print "</html>";
}

Function proximo_da_lista($mesini)
{
 include 'mbcfg.php';
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "SELECT * FROM tabord WHERE periodo='$mesini' ORDER BY numseq";
 $resultado = mysql_query($sql)
 or die ("Não foi possível realizar a consulta ao banco de dados");

$flag="-99"; $devflag="99";
$comdevedor="NO";

while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq   =$linha["numseq"];
 $periodo  =$linha["periodo"];
 $trimestre=$linha["trimestre"];
 $librod   =$linha["librod"];
 $sysop_ult    =$linha["sysop"];
 $nplant   =$linha["nplant"];
 $saldomes =$linha["saldomes"];
 $saltot   =$linha["saltot"];
 $qtferias =$linha["qtferias"];
 $ferias   =$linha["ferias"];

 //echo "NPLANT: $nplant SALDOmes: $saldomes SaldoTot: $saltot # $sysop_ult\n";
 if($qtferias == 0)
  {
   if(($nplant > 0.5) AND ($nplant > $flag))
    {
     $flag=$nplant;
     $paradoem=$sysop_ult;
     $permitido="1";
     if ($nplant >= 2)
      {
       $flag=$nplant;
       $paradoem=$sysop_ult;
       $permitido="2";
      }
     //echo "Libera $permitido plantao para o $sysop_ult<BR>\n";
    }
   if(($nplant <= 0.5) AND ($saldomes >= 0) AND ($saltot < 0))
    {
     //$comdevedor="true";
     $saldodevedor=($saldomes+$saltot);
     if($saldodevedor < $devflag)
      {
       $devflag=$saldodevedor;
       //echo "FLAG ficou com $saldodevedor<BR>\n";
       $paradoem=$sysop_ult;
       $permitido="1";
       //$comdevedor="true";
      }
      //echo "......Libera $permitido plantao para o $sysop_ult DEVEDOR<BR>\n";
      $comdevedor="OK";
    }    
  //echo "a $comdevedor<BR>\n";
  if($comdevedor == "NO")
   {
   if (($nplant <= 0.5) AND ($nplant > 0) AND ($saltot == 0))
    {
     //echo "Tem zerado $sysop_ult<BR>\n";
     //$devflag=$saldodevedor;
     //echo "FLAG ficou com $saldodevedor<BR>\n";
     $paradoem=$sysop_ult;
     $permitido="1";
     $comdevedor="OK";
    }
  if(($nplant <= 0.5) AND ($nplant > 0) AND ($saltot <= 3))
   {
    $devflag=$saldodevedor;
    $paradoem=$sysop_ult;
    $permitido="1";
    $comdevedor="OK";
   }
   }
  }
}
 return ($paradoem);
}

?>
