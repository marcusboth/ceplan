<?
$periodoemaberto="TRUE";
////echo "MESINI $mesini<BR>";
$mesini=$HTTP_POST_VARS['mesini'];
if(empty($mesini))
 {
  include ('periodos_semselecao.inc');
  $mesini=$periodo;
 }

$mesg_retorno[]="";
$vezes="0";
$loop=0;
$limitloop=0;

 $modo="ferias";
 $procurasql="SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias>'0' AND nplant > 0.5 ORDER BY numseq;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra1:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++;
  }

while($limitloop<=3)
 {
 $modo="normal";
 $procurasql="SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant > 3.0 ORDER BY numseq limit $loop, 1;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++; $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   //echo "MESG $mesg_retorno[$vezes]\n";
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra2:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++;
  }
 }

//if($vezes<3)
// $limitloop=$vezes;
$limitloop=0; $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql="SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant > '1.5' AND nplant <= 3.0 ORDER BY numseq limit $loop, 1;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++;  $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   //echo "MESG $mesg_retorno[$vezes]\n";
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra3:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++; 
  }
 }

$limitloop=0; $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql="SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant <= 0.5 AND saldomes >= 0 AND saltot < -6 ORDER BY numseq limit $loop, 1;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++; $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra4:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++; 
  }
 }

$limitloop=0; $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql="SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant = 1.0 AND saldomes = 6 ORDER BY numseq limit $loop, 1;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++; $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra4-5:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++;
  }
 }


$limitloop=0;  $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql="SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant <= 0.5 AND saldomes >= 0 AND saltot > -6 AND saltot < 0 ORDER BY numseq limit $loop, 1;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++;  $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra5:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++; 
  }
 } 

$limitloop=0;  $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql = "SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant <= 0.5 AND nplant > 0 AND saltot = 0 ORDER BY numseq limit $loop, 1;";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto); 
 $loop++;  $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra6:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++; 
  }
 }

/*
$limitloop=0; $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql = "SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant <= 0.5 AND nplant >= 0 AND saltot <= 3 ORDER BY numseq limit $loop, 1";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++; $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   echo "Regra7:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++; 
  }
 }
*/ //provisoria - 2005-07-01

$limitloop=0; $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql = "SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND nplant <= 0.5 AND nplant >= 0 AND saltot <= -3 ORDER BY numseq limit $loop, 1";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++;  $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra8:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++; 
  }
 }

$limitloop=0; $loop=0;
while($limitloop<=3)
 {
 $modo="normal";
 $procurasql = "SELECT * FROM tabord WHERE periodo='$mesini' AND qtferias='0' AND (nplant = 1.0 AND saldomes = 6) ORDER BY numseq limit $loop, 1";
 $mesg_retorno[$vezes]=procuraproximo($modo,$procurasql,$periodoemaberto);
 $loop++;  $limitloop++;
 if(!empty($mesg_retorno[$vezes]))
  {
   list($sysop_dev[$vezes],$ultalt[$vezes],$permi_dev[$vezes])=split("-;-",$mesg_retorno[$vezes]);
   //echo "Regra9:[$vezes] $sysop_dev[$vezes] - $ultalt[$vezes] - $permi_dev[$vezes] - $mesg_retorno[$vezes]<BR>\n";
   $vezes++;
  }
 }

Function procuraproximo($modo,$procurasql,$periodoemaberto)
{
 $mesg_retorno="";
 //echo "SQL: $procurasql<BR>\n";
 include ('mbcfg.inc');
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql=$procurasql;
 $resultado = mysql_query($sql)
 or die ("Nao foi possiel realizar a consulta ao banco de dados");
 while ($linha=mysql_fetch_array($resultado))
 {
  $numseq   =$linha["numseq"];
  $periodo  =$linha["periodo"];
  $trimestre=$linha["trimestre"];
  $librod   =$linha["librod"];
  $sysop_ult=$linha["sysop"];
  $nplant   =$linha["nplant"];
  $saldomes =$linha["saldomes"];
  $saltot   =$linha["saltot"];
  $qtferias =$linha["qtferias"];
  $ferias   =$linha["ferias"];
  $sal=$saldomes; 
 
  //echo "NPLANT: $nplant SALDOmes: $saldomes SaldoTot: $saltot # $sysop_ult\n<BR>";
  if($modo == "ferias")
   {
    if($nplant > "0.5")
     {
      if("$nplant" == "3.5")
        $permitido="3";
      else
      if("$nplant" == "2.5")
        $permitido="2";
      else
      if("$nplant" == "1.5")
        $permitido="1";
      else
        $permitido=$nplant;
        $paradoem=$sysop_ult;
        //echo "$sysop_ult estara de ferias, deve preencher por primeiro $permitido plantao(oes) ($sal)<BR>\n";
        if($periodoemaberto == "TRUE")
         {
          $s = filectime("ctrlmarcacao.sys");
          $ultalt = date("d/m/Y H:i", $s);
          $mesg_retorno="$sysop_ult-;-$ultalt-;-$permitido";
          $periodoemaberto="FALSE";
         }
     }
   }  // fim do teste se estiver de ferias.
  else // modo normal.
   {
    $paradoem=$sysop_ult;
    $permitido="1";
    if ($nplant >= 2)
    {
     $paradoem=$sysop_ult;
     $permitido="2";
    }
    if($periodoemaberto == "TRUE")
     {
      $s = filectime("ctrlmarcacao.sys");
      $ultalt = date("d/m/Y H:i", $s);
      //echo "O preenchimento estah parado no $sysop_ult desde $ultalt - $permitido \n";
      //$mesg_retorno="per tah stopado no $sysop_ult - desde $ultalt - $permitido";
      $mesg_retorno="$sysop_ult-;-$ultalt-;-$permitido";
     }
   }

 }
 // uni a mensagem de retorno, de quem deve preencher plantao e mais o num. de plantao permitido com a flag NO,
 // para parar de pesquisar.
 //echo "Retornando - $mesg_retorno\n";
  return($mesg_retorno);
}
//echo "FIM: Libera $permitido plantao para o $sysop_ult DEVEDOR - $comdevedor<BR>\n";
?>
