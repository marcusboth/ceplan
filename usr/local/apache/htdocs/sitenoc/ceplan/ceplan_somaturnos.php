<?

// temporarimente com constante anos = 2005.

function somaturnos($turno_preenchido,$marcados,$sysop)
{
  $limitea="";
  $acm=1; 
  $seq=""; $numseq=""; $turno=""; $dia=""; $temp_sysop="";
  $flag="FALSE";
  echo "[t18hs] Funcao ceplan_somaturnos-parametros recebidos: $turno_preenchido - $sysop <BR>";
  list($seq,$numseq,$turno,$dia,$temp_sysop)=split(";",$turno_preenchido);

  echo "[t18hs] Seq: $seq Numseq - $numseq Turno $turno - Dia $dia - temp $temp_sysop<BR>";
  list($dia_temp,$dia_sem)=split("-",$dia);
  list($dia_a,$mes)=split("/",$dia_temp);
  $dia_anterior=date("d", mktime(0,0,0,$mes,($dia_a)-1,2005));
  $dia_anterior_sem=date("D", mktime(0,0,0,$mes,($dia_a)-1,2005));
 
  //echo "Dia Marcado: $dia_temp - $dia_a $dia_sem - $mes <BR>";
  //echo "Dia Testado: $dia_anterior_sem - $dia_anterior $mes <BR>";

 // ---------------------------------------------------------------------------------------------------------
 // verifica se o dia anterior esta na tabela dos ja marcados, caso esteja marcando na madrugada ou na manha.
 if(($turno == "ma") OR ($turno == "mb") OR ($turno == "mh") OR ($turno == "mi"))
  {
   //verifica se o dia anterior - se esta no banco - se esta na tabela - e q dia eh ontem.
   $indice=($seq-4);
   echo "[t18hs] Tabela marcados: $indice $marcados[$indice]<BR>";
   list($seq_marcado_tmp,$turno_marcado_tmp,$sysop_marcado_tmp,$dia_marcado_tmp)=split(";",$marcados[$indice]); 
   list($dia_tmp,$dia_sem_tmp)=split("-",$dia_marcado_tmp);
   list($dia_a_tmp,$mes_tmp)=split("/",$dia_tmp);
   //$dia_anterior_tmp=date("d", mktime(0,0,0,$mes,$dia_a_tmp,2005));
   //$dia_anterior_sem_tmp=date("D", mktime(0,0,0,$mes,$dia_a,2005));
   list($lixo,$dia_marcado)=split("-",$dia_marcado_tmp); 

   $dia_anterior_sem=traduz_semana($dia_anterior_sem);

   echo "[t18hs] Dia anterior na tabela de marcados $dia_marcado_tmp Dia Marcado: [$dia_marcado] Dia Anterior [$dia_anterior_sem]<BR>";
   if($dia_anterior_sem == $dia_marcado) 
   {
    if($turno == "ma")
     { 
      $limitea=2; $limite=4; $direcao="a";
     }
    if($turno == "mh")
     {
      $limitea=1;$limite=3; $direcao="a";
     }
    if($turno == "mi") // mb madrugada B nao tem controle.
     {
      $limitea=2;$limite=4; $direcao="a";
     }
    echo "[t18hs] R5egra1: jogando para processamento $limite - $seq - $direcao - $sysop<BR>";
    $acm=verifica_dia_anterior_ou_posterior($limitea,$limite,$seq,$direcao,$sysop,$marcados,$acm);
   }
   else
    {
     if($turno == "mh")
      {
       $limitea=1;$limite=1; $direcao="a"; // testado, caso seja preechido sabado manhaA e nao ter plantao sex.
       }
     if($turno == "mi") // mb madrugada B nao tem controle.
      {
       $limitea=2;$limite=3; $direcao="a";
      }
     echo "[t18hs] Regra1-2: jogando para processamento $limite - $seq - $direcao - $sysop<BR>";
     $acm=verifica_dia_anterior_ou_posterior($limitea,$limite,$seq,$direcao,$sysop,$marcados,$acm);
    }

    if($turno == "ma") 
     {
      $limitea=2;$limite=4; $direcao="p";
     }
    if($turno == "mh")
     {
      $limitea=3;$limite=5; $direcao="p";  //testado.
     }

    if($turno == "mi") // mb  madruga B nao existe.
     {
      $limitea=2;$limite=4; $direcao="p";
     }
    echo "[t18hs] Regra2: jogando para processamento $limite - $seq - $direcao - $sysop<BR>";
    $acm=verifica_dia_anterior_ou_posterior($limitea,$limite,$seq,$direcao,$sysop,$marcados,$acm);
  }

 // -----------------------------------------------------------------------------------------------------
 // verifica se o dia posterior esta na tabela dos ja marcados, caso esteja marcando na tarde ou noite.
 if(($turno == "ta") OR ($turno == "tb") OR ($turno == "na") OR ($turno == "nb"))
  {
   //verifica se o dia posteriora - se esta no banco - se esta na tabela - e q dia eh amanha.
   $indice=($seq+4);
   //echo "INDICE $indice $marcados[$indice]<BR>";
   //echo "Seq: $seq Numseq - $numseq Turno $turno - Dia $dia - temp $temp_sysop<BR>";
   list($dia_temp,$dia_sem)=split("-",$dia);
   list($dia_a,$mes)=split("/",$dia_temp);
   $dia_posterior=date("d", mktime(0,0,0,$mes,($dia_a)+1,2005));
   $dia_posterior_sem=date("D", mktime(0,0,0,$mes,($dia_a)+1,2005));

   //echo "Dia Marcado: $dia_temp - $dia_a $dia_sem - $mes <BR>";
   //echo "Dia Testado: $dia_posterior_sem - $dia_posterior $mes <BR>";

   list($seq_marcado_tmp,$turno_marcado_tmp,$sysop_marcado_tmp,$dia_marcado_tmp)=split(";",$marcados[$indice]);
   list($dia_tmp,$dia_sem_tmp)=split("-",$dia_marcado_tmp);
   list($dia_a_tmp,$mes_tmp)=split("/",$dia_tmp);
   list($lixo,$dia_marcado)=split("-",$dia_marcado_tmp);

   $dia_posterior_sem=traduz_semana($dia_posterior_sem);

   echo "[t18hs] Dia posterior na tabela de marcados $dia_marcado_tmp Dia Marcado: [$dia_marcado] Dia Anterior [$dia_posterior_sem]<BR>";
   if($dia_posterior_sem == $dia_marcado)  // deve-se verificar se tera 18horas.
   {
    if($turno == "ta")
     {
      $limitea=4;$limite=4; $direcao="p";  //testado.
     }
    if($turno == "na")
     {
      $limitea=2;$limite=4; $direcao="p";
     }
    if($turno == "tb")
     {
      $limitea=3;$limite=3; $direcao="p"; // testado.
     }
    if($turno == "nb")
     {
      $limitea=1;$limite=3; $direcao="p";
     }

    echo "Regra3: jogando para processamento $limite - $seq - $direcao - $sysop<BR>";
    $acm=verifica_dia_anterior_ou_posterior($limitea,$limite,$seq,$direcao,$sysop,$marcados,$acm);
   }
    if($turno == "ta")
     {
      $limitea=2;$limite=3; $direcao="a";
     }
    if($turno == "na")
     { 
      $limitea=2;$limite=4; $direcao="a";
     }
    if($turno == "tb")
     {
      $limitea=3;$limite=4; $direcao="a"; //testado.  *****************
     }
    if($turno == "nb") 
     {
      $limitea=3;$limite=5; $direcao="a";
     }

    echo "[t18hs] Regra4: jogando para processamento $limite - $seq - $direcao - $sysop<BR>";
    $acm=verifica_dia_anterior_ou_posterior($limitea,$limite,$seq,$direcao,$sysop,$marcados,$acm);
  }
// ===========================================================================================================

//if($acm>=3)
if($acm>$limitea)
 $flag="TRUE";
if($acm<$limitea)
 $flag="FALSE";
if($acm>=3)
 $flag="TRUE";

 return($flag);
}

 function verifica_dia_anterior_ou_posterior($limitea,$limite,$seq,$direcao,$sysop,$marcados,$acm)
 {
  echo "[t18hs] Verificando dia anterior ou posterior: $seq $limitea $acm $limite <BR>";
  $teste=$acm; $acm_segundo=0;
  for($i=1;$i<=$limitea;$i++)
  {
   if($direcao=="a")
    $seq=$seq-1;
   if($direcao=="p")
    $seq=$seq+1;
   $indice=$seq;
   echo "[t18hs] Verificando...LimiteA: $indice - $marcados[$indice]<BR>";
   list($seq_marcado1,$turno_marcado1,$sysop_marcado1,$dia_marcado1)=split(";",$marcados[$indice]);
   echo "[t18hs] Comparando $sysop_marcado1 == -------------- $sysop - $marcados[$indice]<BR>";
   if($sysop_marcado1 == $sysop)
    {
     $acm++;
     $acm_segundo++;
    }
  } 

  echo "[t18hs] Segunda verificacao TESTE $teste e ACM $acm ACM_SEG $acm_segundo<BR>"; // se o teste for igual a 1 eh sinal que nao houve ACM acumulo.
  echo "[t18hs] SubTotal_1 de plantoes seguido: $acm<BR>";
  
  if(($acm >= 2) AND ($acm_segundo >= 1)) // maior ou igual  if(($acm >= $limitea) AND ($acm_segundo >= 1))
  {
   for($i=$limitea;$i<$limite;$i++) //for($i=$limitea;$i<=$limite;$i++)
   {
    if($direcao=="a")
     $seq=$seq-1;
    if($direcao=="p")
     $seq=$seq+1;
    $indice=$seq;
    echo "[t18hs] Verificando...limite full: $indice - $marcados[$indice]<BR>";
    list($seq_marcado1,$turno_marcado1,$sysop_marcado1,$dia_marcado1)=split(";",$marcados[$indice]);
    echo "[t18hs] Comparando2 $sysop_marcado1 == -------------- $sysop - $marcados[$indice]<BR>";
    if($sysop_marcado1 == $sysop)
      $acm++;
   }
  }

  echo "[t18hs] Total_2 de plantoes seguido: $acm<BR>";
  return($acm);
 }


?>

