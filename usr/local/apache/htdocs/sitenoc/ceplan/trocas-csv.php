<?
//$mes  =$HTTP_POST_VARS['mesi'];
//$ano  =$HTTP_POST_VARS['anoi'];
//$mes_d=$HTTP_GET_VARS['mes_d'];

// Marcus Both - mar/2005.
// 
// --------------- Ainda nao existe um fronend para inserir os parametros
// ---------- deve-se inserir os dados nestas tres primeiras variaveis.
// ----- A saida do Relatorio eh o mes cheio.

$ano="2005";
$mes="02";
$mes_d="Fevereiro";

// -----------------------------------------------------

$mes_y=$mes;
//if(empty($ano))
//$ano=$HTTP_GET_VARS['ano'];

//$numero_de_dias=date("t",mktime(0,0,0,$mes_n,01,$ano));

include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql ="SELECT * from escala where mes='$mes_d' and ano='$ano'";
$resultado = mysql_query($sql)
or die ("Selecione.");
$coluna=0;
while ($linha=mysql_fetch_array($resultado))
{
 $numseq    =$linha["numseq"];
 $dia       =$linha["dia"];    
 $dia_sem   =$linha["dia_sem"];
 $mes       =$linha["mes"];
 $ano       =$linha["ano"];    
 $madrugaa  =$linha["madrugaa"];
 $madrugab  =$linha["madrugab"];
 $manhaa    =$linha["manhaa"];
 $manhab    =$linha["manhab"]; 
 $manhac    =$linha["manhac"]; 
 $matutino  =$linha["matutino"]; 
 $tardea    =$linha["tardea"];
 $tardeb    =$linha["tardeb"]; 
 $tardec    =$linha["tardec"]; 
 $tarded    =$linha["tarded"]; 
 $vespertino=$linha["vespertino"];
 $noitea    =$linha["noitea"];
 $noiteb    =$linha["noiteb"];
}

$sql_dia ="SELECT dia from escala_ch where mes='$mes_d' and ano='$ano' ORDER by dia;";
$resultado_dia = mysql_query($sql_dia)
or die ("Selecione.");
while ($linha_dia=mysql_fetch_array($resultado_dia))
{
 $dia_dia=$linha_dia["dia"];
 dias($ano,$mes_y,$mes_d,$dia_dia,$madrugaa,$madrugab,$manhaa,$manhab,$manhac,$matutino,$tardea,$tardeb,$tardec,$tarded,$vespertino,$noitea,$noiteb);
}

Function dias($ano,$mes_y,$mes_d,$dia_dia,$madrugaa,$madrugab,$manhaa,$manhab,$manhac,$matutino,$tardea,$tardeb,$tardec,$tarded,$vespertino,$noitea,$noiteb)
{
 include ('mbcfg.inc');
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql_ch ="SELECT * from escala_ch where mes='$mes_d' and ano='$ano' and dia='$dia_dia'";
 $resultado_ch = mysql_query($sql_ch)
 or die ("Selecione.");
 while ($linha_ch=mysql_fetch_array($resultado_ch))
 {
  $numseq_ch    =$linha_ch["numseq"];
  $dia_ch       =$linha_ch["dia"];
  $dia_sem_ch   =$linha_ch["dia_sem"];
  $mes_ch       =$linha_ch["mes"];
  $ano_ch       =$linha_ch["ano"];
  $madrugaa_ch  =$linha_ch["madrugaa"];
  $madrugab_ch  =$linha_ch["madrugab"];
  $manhaa_ch    =$linha_ch["manhaa"];
  $manhab_ch    =$linha_ch["manhab"];
  $manhac_ch    =$linha_ch["manhac"];
  $matutino_ch  =$linha_ch["matutino"];
  $tardea_ch    =$linha_ch["tardea"];
  $tardeb_ch    =$linha_ch["tardeb"];
  $tardec_ch    =$linha_ch["tardec"];
  $tarded_ch    =$linha_ch["tarded"];
  $vespertino_ch=$linha_ch["vespertino"];
  $noitea_ch    =$linha_ch["noitea"];
  $noiteb_ch    =$linha_ch["noiteb"];
 
  if(empty($madrugaa_ch))
    $v_madrugaa=$madrugaa;
  else 
    $v_madrugaa=$madrugaa_ch;

  if(empty($madrugab_ch))
    $v_madrugab=$madrugab;
   else
    $v_madrugab=$madrugab_ch;

  if(empty($manhaa_ch))
    $v_manhaa=$manhaa;
   else
    $v_manhaa=$manhaa_ch;

  if(empty($manhab_ch))
    $v_manhab=$manhab;
   else
    $v_manhab=$manhab_ch;

  if(empty($manhac_ch))
    $v_manhac=$manhac;
   else
    $v_manhac=$manhac_ch;

  if(empty($matutino_ch))
    $v_matutino=$matutino;
   else
    $v_matutino=$matutino_ch;

  if(empty($tardea_ch))
    $v_tardea=$tardea;
   else
    $v_tardea=$tardea_ch;

  if(empty($tardeb_ch))
    $v_tardeb=$tardeb;
   else
    $v_tardeb=$tardeb_ch;

  if(empty($tardec_ch))
    $v_tardec=$tardec;
   else
    $v_tardec=$tardec_ch;

  if(empty($tarded_ch))
    $v_tarded=$tarded;
   else
    $v_tarded=$tarded_ch;

  if(empty($noitea_ch))
    $v_noitea=$noitea;
   else
    $v_noitea=$noitea_ch;

  if(empty($noiteb_ch))
    $v_noiteb=$noiteb;
   else
    $v_noiteb=$noiteb_ch;

  if(empty($vespertino_ch))
    $v_vespertino=$vespertino;
   else
    $v_vespertino=$vespertino_ch;

  echo "$dia_ch/$mes_y/$ano;0100;$v_madrugaa;$v_madrugab<br>\n"; 
  echo "$dia_ch/$mes_y/$ano;0700;$v_manhaa;$v_manhab;$v_manhac<br>\n";
  echo "$dia_ch/$mes_y/$ano;1000;$v_matutino<br>\n";
  echo "$dia_ch/$mes_y/$ano;1300;$v_tardea;$v_tardeb;$v_tardec;$v_tarded<br>\n";
  echo "$dia_ch/$mes_y/$ano;1400;$v_vespertino<br>\n";
  echo "$dia_ch/$mes_y/$ano;1900;$v_noitea;$v_noiteb<br>\n";
 }
}

?>
