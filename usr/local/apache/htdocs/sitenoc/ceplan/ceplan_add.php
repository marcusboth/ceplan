<?

//
// CEPLAN 2.0 - NOC - 2004
// recebe o post dos preenchimento dos plantoes.
// possuie varios includes.
//
// ---------------------------------------------------------------



$i_preenchido="0"; $preenchido[]=""; $iferiado="0"; $preenchidoferiado[]=""; $totalpreenchido[]=""; $tot_preenchido="0"; $marcadx[]="";
$tot="100"; $todos="0";
for($a=0;$a<$tot;$a++)
{
  $marcado="marcado$a";
  $ma="ma$a"; // madrugada a
  $mb="mb$a"; // madrugada b
  $mh="mh$a"; // manha a 
  $mi="mi$a"; // manha b
  $ta="ta$a"; // tarde a
  $tb="tb$a"; // tarde b
  $na="na$a"; // noite a
  $nb="nb$a"; // noite b

 // toda a tabela de plantoes
 if(!empty($HTTP_POST_VARS[$marcado])) //madruga a (ma)
  {
   $marcadx[$todos]="$HTTP_POST_VARS[$marcado]";
   $todos++;
  }

 // Preenchidos
 if(!empty($HTTP_POST_VARS[$ma])) //madruga a (ma)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$ma]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$mb])) // madruga b (mb)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$mb]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$mh])) // manha a (mh)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$mh]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$mi])) // manha b (mi)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$mi]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$ta])) // tarde a (ta)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$ta]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$tb])) // tarde b (tb)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$tb]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$na])) // noite a (na)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$na]";
   $i_preenchido++;
  }
 if(!empty($HTTP_POST_VARS[$nb])) // noite b (nb)
  {
   $preenchido[$i_preenchido]="$HTTP_POST_VARS[$nb]";
   $i_preenchido++;
  }

  $maferiado="maferiado$a"; // madrugada a feriado
  $mbferiado="mbferiado$a"; // madrugada b feriado
  $mhferiado="mhferiado$a"; // manha a     feriado
  $miferiado="miferiado$a"; // manha b     feriado
  $taferiado="taferiado$a"; // tarde a     feriado
  $tbferiado="tbferiado$a"; // tarde b     feriado
  $naferiado="naferiado$a"; // noite a     feriado
  $nbferiado="nbferiado$a"; // noite b     feriado

 if(!empty($HTTP_POST_VARS[$maferiado])) //madruga a (ma feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$maferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$mbferiado])) // madruga b (mb feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$mbferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$mhferiado])) // manha a (mh feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$mhferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$miferiado])) // manha b (mi feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$miferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$taferiado])) // tarde a (ta feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$taferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$tbferiado])) // tarde b (tb feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$tbferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$naferiado])) // noite a (na feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$naferiado]";
   $iferiado++;
  }
 if(!empty($HTTP_POST_VARS[$nbferiado])) // noite b (nb feriado)
  {
   $preenchidoferiado[$iferiado]="$HTTP_POST_VARS[$nbferiado]";
   $iferiado++;
  }

} // ate aqui incrementa a veriavel dos plantoes preenchidos.


$num="$HTTP_POST_VARS[num]";
$num=($num/2);
$sysop_1="$HTTP_POST_VARS[sysop_1]";
$sysop_2="$HTTP_POST_VARS[sysop_2]";


// Verifica se a variavel limite de plantoes permitido nao veio em branco. -----------
$permitido="$HTTP_POST_VARS[permitido]";
if(empty($permitido))
 {
  $mesg="Variavel limite de plantoes permitido veio em branco.";
  chamaerro($mesg,$permitido);
  exit;
 }


$periodo=$HTTP_POST_VARS[mesini];
if(empty($periodo))
 {
  $mesg="Variavel mesini periodo veio em branco.";
  chamaerro($mesg,$permitido);
  exit;
 }


//echo "Iferiado $iferiado<BR>";
//echo "tot_preen $tot_preenchido<BR>";
// testa se por algum motivo a variavel veio zerada.

$sysoplogado=$HTTP_POST_VARS[sysoplogado];
$sysop_0=$HTTP_POST_VARS[sysop_0];

// Verifica se a variavel sysop_0 preenchedor nao veio em branco. -----------------------
if(empty($sysop_0))
 {
  $mesg="Variavel sysop veio em branco.";
  chamaerro($mesg,$permitido);
  exit;
 }

$em_nome=$HTTP_POST_VARS['em_nome'];
$faltapreencher=$HTTP_POST_VARS['faltapreencher'];


//echo "PERMITIDO $permitido<BR>";
echo "Solicitado por $sysoplogado.<BR>";
echo "autenticado: $sysoplogado - eh a vez do: $sysop_0<BR>";
echo "Em nome de $em_nome<BR>";

// Verifica se o moderador esta pedindo plantao em nome de outro sysop. ---------------
include ('config.php'); // Verifica quem eh o moderador ------------
if(("$moderador" != "$sysoplogado") AND (!empty($em_nome)))
 {
  echo "Moderador $sysoplogado esta autorizado a preencher em nome do $sysop_0.<BR>";
  exit;
 }

if("$sysoplogado" != "$sysop_0")
if((empty($em_nome)) AND ("$sysoplogado" == "$moderador"))
 {
  echo "Moderador $sysoplogado verifique se clicou na opcao Preencher em nome do $sysop_0.<BR>";
  exit;
 }

if(("$moderador" == "$sysoplogado") AND (!empty($em_nome)))
  echo "Moderador $sysoplogado esta autorizado a preencher em nome do $sysop_0.<BR>";


// Certifica quem esta pedindo plantao e de quem eh a vez. -------------------------------
include ('paradorot.php'); // Verifica de quem eh a vez de preencher plantao -----------
list($sysop_proximo_0,$desde,$permitido)=split("-;-",$mesg_retorno[0]);
//echo "Proximo: $mesg_impressa - Permitido: $permitido - Desde $desde<BR>";
if($sysop_proximo_0 != $sysop_0)
 {
  $mesg="Eh a vez do $syso_proximo_0 preencher plantao.";
  chamaerro($mesg,$permitido);
  exit;
 }


$limite=$i_preenchido-$iferiado;

// Verifica se foi escolhido mais de um plantao pago -----------------
if($iferiado > 1)
 {
  $mesg="Permitido a escolha de apenas 1 plantao pago(feriado).";
  $permitido="1";
  chamaerro($mesg,$permitido); exit;
 }

// Verifica se foi escolhido plantao --------------------------
if(empty($i_preenchido))
 {
  $mesg="Eh obrigatorio a escolha de plantao.";
  $permitido="";
  chamaerro($mesg,$permitido); exit;
 }

// $i_preenchido eh o acumulador de numero de plantoes preenchido para verificacao. 
// Verifica se foi escolhido o numero de plantoes permitido. --------------------------

if($i_preenchido != $permitido) 
 {
  if($faltapreencher !=1)
  {
   $mesg="Deve preencher somente o numero de plantoes permitido.";
   chamaerro($mesg,$permitido); exit;
  }
  if($faltapreencher == 1)
  {
   $permitido=1;
  }
 }

//if($faltapreencher <= 2)
// {
//  chama funcao para testar  se o ultimo sysop a preencher nao restara a ele preencher plantao com mais de 12horas (3 seguidos).
// }

include ('ceplan_converturno.php'); // Verifica o preenchimento no mesmo dia/turno/horario ---------------

// Verifica se esta preenchendo o mesmo turno e dia, caso ambos estejam em branco, status 'preencher'. ---------------
for($i=0;$i<$permitido;$i++)
  $testa_repetido[$i]=verificarturno($preenchido[$i]);

for($x=0;$x<$permitido;$x++)
 {
  list($seqx[$x],$turnox[$x],$diax[$x])=split(";",$testa_repetido[$x]);
  for($y=1;$y<$permitido;$y++)
   {
    list($seqy[$y],$turnoy[$y],$diay[$y])=split(";",$testa_repetido[$y]);
    if(($turnox[$x] == $turnoy[$y]) AND ($diax[$x] == $diay[$y])) // testa_repetido[$x] == $testa_repetido[$y])
     {
      $mesg="Nao eh possivel escolher o mesmo horario/turno e dia.";
      chamaerro($mesg,$permitido);
      exit;
      }
      //echo "Foi escolhido o mesmo dia e turno $x $y - $testa_repetido[$x] - $testa_repetido[$y]<BR>\n";
      $y=$permitido;
      $x=$permitido;
   }
 }

// Verifica se preencheu no mesmo turno e dia que jah estava marcado. ----------------------
for($y=0;$y<$permitido;$y++)
 {
  list($seqy,$numseqy,$turnoy,$diay)=split(";",$preenchido[$y]);
  $ant1vez=($seqy-1);
  list($seq_marcadoa1,$turno_marcadoa1,$sysop_marcadoa1,$dia_marcadoa1)=split(";",$marcadx[$ant1vez]); 
  $testa_repetido_m="$seq_marcadoa1;9X9;$turno_marcadoa1;$dia_marcadoa1";
  $testa_repetido_p=verificarturno($preenchido[$y]); // _p para Preenchido
  $testa_repetido_m=verificarturno($testa_repetido_m); // _m para jah Marcados
  list($tmp_a,$tmp_turno)=split(";",$testa_repetido_p);
  $mesmoturno=ereg($tmp_turno,$testa_repetido_m);
  if($mesmoturno)
   if(($diay ==  $dia_marcadoa1) AND ($sysop_0 ==  $sysop_marcadoa1)) 
    {
      //echo "ERRO- MESMO TURNO $testa_repetido_p --- $testa_repetido_m<BR>";
      $mesg="Nao eh possivel escolher o mesmo horario/turno e dia.";
      chamaerro($mesg,$permitido);
      exit;
    }
  $pos1vez=($seqy+1);
  list($seq_marcadop1,$turno_marcadop1,$sysop_marcadop1,$dia_marcadop1)=split(";",$marcadx[$pos1vez]);
  $testa_repetido_m="$seq_marcadop1;9X9;$turno_marcadop1;$dia_marcadop1";
  $testa_repetido_p=verificarturno($preenchido[$y]); // _p para Preenchido
  $testa_repetido_m=verificarturno($testa_repetido_m); // _m para jah Marcados

  list($tmp_a,$tmp_turno)=split(";",$testa_repetido_p);
  $mesmoturno=ereg($tmp_turno,$testa_repetido_m);
  if($mesmoturno)
   if(($diay ==  $dia_marcadop1) AND ($sysop_0 ==  $sysop_marcadop1))
    {
     echo "ERRO- MESMO TURNO $testa_repetido_p --- $testa_repetido_m<BR>";
     $mesg="Nao eh possivel escolher o mesmo horario/turno e dia.";
     chamaerro($mesg,$permitido);
     exit;
    }

 } // fim do teste se preencheu no mesmo turno e dia que jah estava marcado.

// criar uma variavel contendo todos os plantoes preenchidos pelo sysop corrente (sysop_0).
// para Verificar se o proximo sysop (sysop_1) nao sera prejudicado com os plantoes restantes. ----------------
$marcado_temp0=$marcadx;

//echo "Total de plantoes Preenchidos $i_preenchido<BR>";
for($x=0;$x<$i_preenchido;$x++)
 {
  list($seq,$numseq,$turnoescolhido,$dia)=split(";",$preenchido[$x]);
   $marcado_temp0[$seq]="$seq;$turnoescolhido;$sysop_0;$dia";
  // Cria a tabela temporaria contendo o/os plantao/oes preenchido/os. - na posicao correta.
 }
$seq="";$numseq="";$turnoescolhido="";$dia="";

for($x=0;$x<$iferiado;$x++)
 {
  list($seq,$numseq,$turnoescolhido,$dia)=split(";",$preenchidoferiado[$x]);
  switch($turnoescolhido)
   { 
    case "maferiado":
        $turnoescolhido = "ma";
        break;
    case "mbferiado":
        $turnoescolhido = "mb";
        break;
    case "mhferiado":
        $turnoescolhido = "mh";
        break;
    case "miferiado":
        $turnoescolhido = "mi";
        break;
    case "taferiado":
        $turnoescolhido = "ta";
        break;
    case "tbferiado":
        $turnoescolhido = "tb";
        break;
    case "naferiado":
        $turnoescolhido = "na";
        break;
    case "nbferiado":
        $turnoescolhido = "nb";
        break;
   }
   $ipreenchidoferiado[$x]="$seq;$numseq;$turnoescolhido;$dia";
   $marcado_temp0[$seq]="$seq;$turnoescolhido;$sysop_0;$dia";
  // Cria a tabela temporaria contendo o/os plantao/oes PAGOS preenchido/os. - na posicao correta.
 }


//for($i=0;$i<120;$i++)
//{
//  echo "Como ficou OS PREENCHIDOS $marcado_temp0[$i]<BR>";
//}


include ('ceplan_somaturnos.php'); // Verifica turno de 18 horas --------------
include ('ceplan_sem.php'); // apenas converte para o portugues.

// Verifica se preencheu no mesmo turno e dia que jah estava marcado, aqui controla 18hs, 3 turnos --------------
for($x=0;$x<$i_preenchido;$x++)
 {
  //$turnoescolhido=verificarturno($preenchido[$x]);
  echo "[teste 18horas] Passando o parametro: $preenchido[$x] -  $sysop_0<BR>";
  $trueorfalse=somaturnos($preenchido[$x],$marcado_temp0,$sysop_0);
  echo "[teste 18horas] Retorno(TRUE OR FALSE) ceplan_somaturnos: $trueorfalse<BR>";
  if($trueorfalse == "TRUE")
    $x=$i_preenchido;
 }
if($trueorfalse == "TRUE") 
 {
  $mesg="Erro na escolha do(s) plantao(oes) - provavel 18 horas - verifique.";
  chamaerro($mesg,$permitido);
  exit;
 } 

// ----

for($x=0;$x<$iferiado;$x++)
 {
  //$turnoescolhido=verificarturno($preenchido[$x]);
  echo "[teste 18horas] Passando o parametro com feriado: $ipreenchidoferiado[$x] -  $sysop_0<BR>";
  $trueorfalse=somaturnos($ipreenchidoferiado[$x],$marcado_temp0,$sysop_0);
  echo "[teste 18horas] Retorno(TRUE OR FALSE) ceplan_somaturnos: $trueorfalse<BR>";
  if($trueorfalse == "TRUE")
    $x=$iferiado;
 }
if($trueorfalse == "TRUE")
 {
  $mesg="Erro na escolha do(s) plantao(oes) - provavel 18 horas - verifique.";
  chamaerro($mesg,$permitido);
  exit;
 }

// ------


// ------------------------- remover este trecho ----------------inicio
// aqui testa somente 18horas, nao testa se marcou o mesmo turno e horario.
for($x=0;$x<$i_preenchido;$x++)
 {
  echo "Teste ANTIGO: $preenchido[$x] $i_preenchido<BR>";
  //$turnoescolhido=verificarturno($preenchido[$x]);
  $trueorfalse=somaturnos($preenchido[$x],$marcadx,$sysop_0);
  echo "Teste ANTIGO -TRUE OR FALSE ceplan_somaturnos [0] : $trueorfalse<BR>";
  if($trueorfalse == "TRUE")
    $x=$i_preenchido;
 }

// se retornar FALSE quer dizer que nao teve problema.
// se retornar TRUE quer dizer q SIM eh para abortar com mesg de erro.

if($trueorfalse == "TRUE")
 {
  $mesg="Erro na escolha do(s) plantao(oes) - provavel 18 horas - verifique.";
  chamaerro($mesg,$permitido);
  exit;
 }
// ------------------------- remover este trecho ----------------fim



//for($abc=0;$abc<5;$abc++)
// {
//  echo "MARCADO_TEMP0 - $marcado_temp0[$abc]<BR>";
// }

//if(empty($sysop_1))
// {
//  $mesg="Variavel sysop proximo (sysop_1) veio em branco.";
//  chamaerro($mesg,$permitido);
//  exit;
// }

echo "FALTAPREENCHER $faltapreencher e PERMITIDO $permitido<BR>";
$faltapreencher=($faltapreencher-$permitido);
if($faltapreencher == 1)
 $permitido=1;
echo "FALTAPREENCHER $faltapreencher e PERMITIDO $permitido<BR>";

$marcado_temp1=$marcado_temp0;
$preenchido_temp1="";

$i_preenchido_tmp=0; $preenchido_temp_db[]="";
// Verifica se nao restara para o proximo sysop preenchedor 18horas seguido --------------------------
if(($faltapreencher == 2) AND ($permitido == 2))
 {
  echo "[testa prox.] Teste 1o chamando funcao ceplan_testaprox.<BR>";
  include('ceplan_testaprox.php');
  echo "[testa prox.] Teste 2o retorno da funcao testaprox - $preenchido_temp1 - marcado_temp0 - $sysop_1<BR>";
  $trueorfalse=somaturnos($preenchido_temp1,$marcado_temp0,$sysop_1);
  echo "[testa prox.] Retorno(TRUE OR FALSE) ceplan_somaturnos Prox.sysop: $trueorfalse<BR>";
  if($trueorfalse == "TRUE")
   {
    $mesg="Restara para o proximo sysop $sysop_1 18 horas - verifique.";
    chamaerro($mesg,$permitido);
    exit;
   }
  else
   { 
    echo "[testa prox.] Teste 2o chamando funcao ceplan_testaprox.<BR>";
    include('ceplan_testaprox.php');
    $trueorfalse=somaturnos($preenchido_temp1,$marcado_temp0,$sysop_1);
    echo "[testa prox.] Retorno(TRUE OR FALSE) ceplan_somaturnos Prox.sysop: $trueorfalse<BR>";
   }
  if($trueorfalse == "TRUE")
   {
    $mesg="Restara para o proximo sysop $sysop_1 18 horas - verifique.";
    chamaerro($mesg,$permitido);
    exit;
   }
 }

if(($faltapreencher == 1) AND ($permitido == 1))
 {
  if($faltapreencher !=1)
   {
    echo "[testa prox.] Teste 1o chamando funcao ceplan_testaprox.php..<BR>";
    include('ceplan_testaprox.php');
    echo "[testa prox.] Teste 2o retorno da funcao testaprox - $preenchido_temp1 - marcado_temp0 - $sysop_1<BR>";
    $trueorfalse=somaturnos($preenchido_temp1,$marcado_temp0,$sysop_1);
    echo "[testa prox.] Retorno(TRUE OR FALSE) ceplan_somaturnos Prox.sysop: $trueorfalse<BR>";
    if($trueorfalse == "TRUE")
     {
      $mesg="Restara para o proximo sysop $sysop_1 18 horas - verifique.";
      chamaerro($mesg,$permitido);
      exit;
     }
   }
 }

  // TRUE = nao pode preencher.
  // FALSE = Liberado.


//for($abc=0;$abc<$i_preenchido_tmp;$abc++)
// {
//  echo "PREENCHIDO_TEMP $preenchido_temp_db[$abc]<BR>";
// }  


//for($x=0;$x<$i_preenchido;$x++)
// {
  //echo "TotalPree $totalpreenchido[$x]<BR>";
  //echo "Marcado_temp $marcado_temp0[$x]<BR>";
//  echo "Vou gravar isto no banco $x $preenchido[$x]<BR>";
// }

 // ----------------- Tratamento do proximo sysop (sysop_1) -- fim.



if($trueorfalse == "FALSE")  //  faz o update na tabela, se a variavel trueorfalse estiver como FALSE.
{
include ('mbcfg.inc'); 
// Grava o preenchimento normal/plantao obrigatorio e pago. ---------


 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
for($x=0;$x<$i_preenchido;$x++)
  {
  echo "$preenchido[$x]<BR>"; 
  list($lixotemp,$numseq,$hora,$dia)=split(";",$preenchido[$x]); 
if($hora == "ma")
 $sqlinsere="UPDATE tabpla SET madrugaa='$sysop_0' WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "mb")
 $sqlinsere="UPDATE tabpla SET madrugab='$sysop_0' WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

if($hora == "mh") 
 $sqlinsere="UPDATE tabpla SET manhaa='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "mi")
 $sqlinsere="UPDATE tabpla SET manhab='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

if($hora == "ta") 
 $sqlinsere="UPDATE tabpla SET tardea='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "tb") 
 $sqlinsere="UPDATE tabpla SET tardeb='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

if($hora == "na") 
 $sqlinsere="UPDATE tabpla SET noitea='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "nb") 
 $sqlinsere="UPDATE tabpla SET noiteb='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
  $resultado = mysql_query($sqlinsere)
 or die ("Nao foi  possivel realizar a consulta ao banco de dados $numseq");
}


for($x=0;$x<$iferiado;$x++)
 {
  //$turnoescolhido=verificarturno($preenchido[$x]);
  echo "[feriado] . Passando o parametro: $ipreenchidoferiado[$x] -  $sysop_0<BR>";
  $trueorfalse=somaturnos($ipreenchidoferiado[$x],$marcado_temp0,$sysop_0);
  //echo "TRUE OR FALSE ceplan_somaturnos: $trueorfalse<BR>";
  if($trueorfalse == "TRUE")
    $x=$iferiado;
 }

$lixotemp=""; $numseq=""; $hora=""; $dia="";
if(!empty($iferiado))
{
  list($lixotemp,$numseq,$hora,$dia)=split(";",$ipreenchidoferiado[0]);
if($hora == "ma") 
 $sqlinseref="UPDATE tabpla SET madrugaa='$sysop_0' WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "mb")
 $sqlinseref="UPDATE tabpla SET madrugab='$sysop_0' WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

if($hora == "mh")
 $sqlinseref="UPDATE tabpla SET manhaa='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "mi")
 $sqlinseref="UPDATE tabpla SET manhab='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

if($hora == "ta")
 $sqlinseref="UPDATE tabpla SET tardea='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "tb")
 $sqlinseref="UPDATE tabpla SET tardeb='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

if($hora == "na")
 $sqlinseref="UPDATE tabpla SET noitea='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";
if($hora == "nb")
 $sqlinseref="UPDATE tabpla SET noiteb='$sysop_0'  WHERE numseq='$numseq' AND periodo='$periodo' AND dia='$dia';";

  $resultadof = mysql_query($sqlinseref)
 or die ("Nao foi  possivel realizar a consulta ao banco de dados $numseq");
}

// Verifica se houve refresh do browser -------------------------
//include ('paradorot.php');
list($sysop_proximo_0,$desde,$permitido)=split("-;-",$mesg_retorno[0]);
//echo "Proximo: $mesg_impressa - Permitido: $permitido - Desde $desde<BR>";
if($sysop_proximo_0 != $sysop_0)
 {
  //echo "Nao posso fazer update - sysop $sysop_0 tentando fazer refresh no browser<BR>";
  $mesg="$sysop plantao jah preenchido.";
  chamaerro($mesg,$permitido);
  exit;
 }

// Atualiza a tabela de ordem, diminuindo o saldos do mes.
$sql = "SELECT numseq,periodo,sysop,nplant,saldomes FROM tabord WHERE periodo='$mesini' and sysop='$sysop_0'";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $numseq_up=$linha["numseq"];
 $periodo  =$linha["periodo"];
 $sysop_up =$linha["sysop"];
 $nplant   =$linha["nplant"];
 $saldomes =$linha["saldomes"];
 $saltot   =$linha["saltot"];
  //echo "BEFORE: nplant $nplant<BR>";
  //echo "BEFORE: permi  $permitido<BR>";
 $nplant=($nplant-$permitido);
 $saldomes=$saldomes-($permitido*6);
  //echo "AFTER: saldomes $saldomes<BR>";
  //echo "AFTER: nplant $nplant<BR>";
}

// Updating...
$sqlup = "UPDATE tabord SET nplant='$nplant', saldomes='$saldomes' WHERE periodo='$mesini' and sysop='$sysop_0' and numseq='$numseq_up'";
$resultado = mysql_query($sqlup)
or die ("Nao foi possivel atualizar a tabord - $mesini - $sysop_0 - $numseq_up");

} // fim do update na tabela, se a variavel trueorfalse estiver como FALSE.


// grava tambem o preenchimento do proximo sysop_1
if(!empty($i_preenchido_tmp))
 {
  include ('ceplan_add_prox.php');
 }

// Controle para ver se o preenchemto acabou, se o periodo deve ser finalizado. -----------------------
$acabou="";
$acabou=($faltapreencher-$permitido);
if($acabou <= 0)
 {
  //echo "O periodo deve ser fechado, nao existe mais a TAG faltapreencher.<BR>\n";
  $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
  $db = mysql_select_db($imp_banco);
  $sql = "UPDATE tabsal SET ctrl='f' WHERE periodo='$mesini'";
  $resultado = mysql_query($sql)
  or die ("Nao foi possivel realizar a consulta ao banco de dados TABSAL");
  //echo "<h1>Registro alterado com sucesso!</h1>";
 }
echo "Ainda falta $acabou<BR>";


//envia email pra lista.
include ('ceplan_envmail.php');



// - erro
$permitido="1"; ///////// Both 2005 11 11
Function chamaerro($mesg,$permitido)
{
 echo "mensagem: $mesg<BR>";
 if(!empty($permitido))
   echo "Eh permitido $permitido plantao(oes). <BR>";
}

?>
