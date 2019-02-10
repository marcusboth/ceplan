<?
//$mes  =$HTTP_POST_VARS['mesi'];
//$ano  =$HTTP_POST_VARS['anoi'];
//$mes_d=$HTTP_GET_VARS['mes_d'];

$ano='2005';
$mes='02';
$mes_d='Fevereiro';

if(empty($ano))
$ano=$HTTP_GET_VARS['ano'];

if(!empty($mes))
list($mes_n,$mes_d)=split("-;-",$mes);

$numero_de_dias=date("t",mktime(0,0,0,$mes_n,01,$ano));

$totsem=0; $tot_semanas=1; $totaldias=0;
$parte[0]=0;

include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql ="SELECT * from escala where mes='$mes_d' and ano='$ano' ORDER by dia;";
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

// $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
// $db = mysql_select_db($imp_banco);
$sql_ch ="SELECT * from escala_ch where mes='$mes_d' and ano='$ano' ORDER by dia;";
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
 $vespertino_ch=$linha_ch["vespertinoh"];
 $noitea_ch    =$linha_ch["noitea"];
 $noiteb_ch    =$linha_ch["noiteb"];

 $madrugaa=$madrugaa_ch;
 $madrugab=$madrugab_ch;
 echo "$dia_ch;0100;$madrugaa_ch;$madrugab_ch<BR>;"; 
 
}




  $numseq=$linha["numseq"];
  $dia   =$linha["dia"];
  $dia_sem=$linha["dia_sem"];
  $mes   =$linha["mes"];
  $ano   =$linha["ano"];
  //echo "$numseq - $dia $dia_sem\n";
  $totaldias++;
  $totsem++;
  if($dia_sem == Sexta)
   {
    //echo "Total de dias nesta semana $totsem<BR>\n";
    $indice=$tot_semanas-1;
    $soma=$parte[$indice]+$totsem;
    $parte[$tot_semanas]=$soma;
    $tot_semanas++;
    $totsem=0;
    $soma=0;
   }
}
//if(($totsem < 5) AND ($totsem != 0))
// {
//  //echo "Somar mais uma semana <BR>\n";
//  $indice=$tot_semanas-1;
//  $soma=$parte[$indice]+$totsem;
//  $parte[$tot_semanas]=$soma;
//  $tot_semanas++;
//  $totsem=0;
//  $soma=0;
// }

// -----------------------------------------------------------------------------------------------
//if(empty($parte[1]))
// {
//  chamacadastro($mes_d,$ano);
//  exit;
// }
echo "<p class='linhanormal'><a href='trocas_pessoais-cvs.php?mes_d=$mes_d&ano=$ano&tipo=TODO'>$mes_d [Ver todo o mes]</a> &nbsp;&nbsp;&nbsp;";
for($i=0;$i<$tot_semanas;$i++)
{
 $numero=($i+1);
 $numero.="a";
 if($i == 0)
  echo "<a href='trocas_pessoais-cvs.php?mes_d=$mes_d&ano=$ano&tipo=DIVIDIDO&limitei=0&limitef=$parte[1]'>[$numero Semana]</a>&nbsp;&nbsp;&nbsp; ";
 else
  echo "<a href='trocas_pessoais-cvs.php?mes_d=$mes_d&ano=$ano&tipo=DIVIDIDO&limitei=$parte[$i]&limitef=5'>[$numero Semana]</a>&nbsp;&nbsp;&nbsp;";
}


//$mes_d=$HTTP_GET_VARS['mes_d'];
$mes_d='Fevereiro';
$limite_i=$HTTP_GET_VARS['limitei'];
$limite_f=$HTTP_GET_VARS['limitef'];
$tipo=$HTTP_GET_VARS['tipo'];

if(empty($tipo))
 exit;
?>

<style type='text/css'>
<!--
.linhanormal {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        color: #333333;
}
.tabelanormal {
        border: 1px solid #FFFF66;
        background-color: #FFFF99;
}
.tabelatroca {
        border: 1px solid #FF9900;
        background-color: #CCCCCC;
}
.linhadestaque {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #000000;
}
.linhaembranco {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 2px;
}
-->
</style>
</head>

<table width='230' border='0'>
  <tr class='linhanormal'>

<?
$dia="";
$dia_sem="";
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
if($tipo == TODO)
$sql ="SELECT escala.*, escala_ch.* from escala,escala_ch where (escala.ano='$ano' AND escala_ch.ano='$ano') AND (escala.mes='$mes_d' AND escala_ch.mes='$mes_d') ORDER by escala_ch.numseq ;";
if($tipo == DIVIDIDO)
$sql ="SELECT escala.*, escala_ch.* from escala,escala_ch where (escala.ano='$ano' AND escala_ch.ano='$ano') AND (escala.mes='$mes_d' AND escala_ch.mes='$mes_d') ORDER by escala_ch.numseq limit $limite_i, $limite_f;";
$resultado = mysql_query($sql)
or die ("Selecione.");
$coluna=0;
while ($linha=mysql_fetch_array($resultado)) 
{
//echo "escala.numseq   0 $linha[0]\n";  // numseq
/*
echo "escala.mes      0 $linha[1]\n";  // mes
echo "escala.ano      0 $linha[2]\n";  // ano
echo "escala.madrugaa 0 $linha[3]\n";  // madruga a
echo "escala.madrugab 0 $linha[4]\n";  // madruga b
echo "escala.manhaa   0 $linha[5]\n";  // manha a
echo "escala.manhab   0 $linha[6]\n";  // manha b
echo "escala.manhac   0 $linha[7]\n";  // manha c
echo "escala.matutino 0 $linha[8]\n";  // matutino
echo "escala.tardea   0 $linha[9]\n";  // tarde a
echo "escala.tardeb   0 $linha[10]\n"; // tarde b
echo "escapa.tardec   0 $linha[11]\n"; // tarde c
echo "escapa.tarded   0 $linha[12]\n"; // tarde d
echo "escala.vespertino 0 $linha[13]\n"; // vespertino
echo "escala.noitea     0 $linha[14]\n";   // noitea
echo "escala.noiteb     0 $linha[15]\n";   // noiteb

echo "escala_ch.numseq   0 $linha[16]\n";  // numseq
echo "escala_ch.dia      0 $linha[17]<BR>\n";  // dia
echo "escala_ch.dia_sem  0 $linha[18]<BR>\n";  // dia sem
echo "escala_ch.mes      0 $linha[19]\n";  // mes
echo "escala_ch.ano      0 $linha[20]\n";  // ano
echo "escala_ch.madrugaa 0 $linha[21]\n";  // madruga a
echo "escala_ch.madrugab 0 $linha[22]\n";  // madruga b
 echo "escala_ch.manhaa   0 $linha[23]<BR>\n";  // manha a
echo "escala_ch.manhab   0 $linha[24]\n";  // manha b
echo "escala_ch.manhac   0 $linha[25]\n";  // manha c
echo "escala_ch.matutino 0 $linha[26]\n";  // matutino
echo "escala_ch.tardea   0 $linha[27]\n";  // tarde a
echo "escala_ch.tardeb   0 $linha[28]\n"; // tarde b
echo "escapa_ch.tardec   0 $linha[29]\n"; // tarde c
echo "escapa_ch.tarded   0 $linha[30]\n"; // tarde d
echo "escala_ch.vespertino 0 $linha[31]\n"; // vespertino
echo "escala_ch.noitea     0 $linha[32]\n";   // noitea
echo "escala_ch.noiteb    0 $linha[33]\n";   // noiteb
*/
/*
 echo "Mes: $mes <BR>\n";
 echo "Dia $dia<BR>\n";
 echo "1 $aaa \n";
 echo "2 $madrugaa\n";
*/

$numseq="$linha[0]";

//echo "escala_ch.numseq   0 $linha[16]\n";  // numseq
//echo "escala - $md_b_ch[22]<BR>";
$numseq_ch[$coluna]="$linha[16]"; //numseq ch
$dia[$coluna]    ="$linha[17]";
$dia_sem[$coluna]="$linha[18]";
$md_a[$coluna]   ="$linha[3]";
$md_a_ch[$coluna]="$linha[21]";
$md_b[$coluna]   ="$linha[4]";
$md_b_ch[$coluna]="$linha[22]";

$ma_a[$coluna]   ="$linha[5]";
$ma_a_ch[$coluna]="$linha[23]";
$ma_b[$coluna]   ="$linha[6]";
$ma_b_ch[$coluna]="$linha[24]";
$ma_c[$coluna]   ="$linha[7]";
$ma_c_ch[$coluna]="$linha[25]";

$mat_a[$coluna]   ="$linha[8]";  // matutino
$mat_a_ch[$coluna]="$linha[26]";

$ta_a[$coluna]   ="$linha[9]";
$ta_a_ch[$coluna]="$linha[27]";
$ta_b[$coluna]   ="$linha[10]";
$ta_b_ch[$coluna]="$linha[28]";
$ta_c[$coluna]   ="$linha[11]";
$ta_c_ch[$coluna]="$linha[29]";
$ta_d[$coluna]   ="$linha[12]";
$ta_d_ch[$coluna]="$linha[30]";

$ves_a[$coluna]   ="$linha[13]";  // vespertino
$ves_a_ch[$coluna]="$linha[31]";

$na_a[$coluna]   ="$linha[14]";
$na_a_ch[$coluna]="$linha[32]";
$na_b[$coluna]   ="$linha[15]";
$na_b_ch[$coluna]="$linha[33]";

$coluna++;

}

//if(empty($numseq))
// {
//  chamacadastro($mes_d,$ano);
//  exit;
// }

$numero_de_dias=$coluna;

echo " Turno/Dia";
for($x=0;$x<$numero_de_dias;$x++)
  echo "$dia[$x]/$dia_sem[$x];";

echo ">Madruga(A)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($md_a_ch[$x]))
  echo ";01:00;$md_a[$x];";
 if(!empty($md_a_ch[$x]))
  echo ";01:00;$md_a_ch[$x];";
}
echo " ,";

echo "Madruga(B)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($md_b_ch[$x]))
   echo "$md_b[$x]<BR>;";
 if(!empty($md_b_ch[$x]))
   echo "$md_b_ch[$x]<B>R;";
}
echo " ,";

echo " ; ";

// Manha ***************************************************** A

for($x=0;$x<$numero_de_dias;$x++)
  echo "$dia[$x]/$dia_sem[$x];";

echo "Manha(A)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ma_a_ch[$x]))
   echo "$ma_a[$x]";
 if(!empty($ma_a_ch[$x]))
   echo "$ma_a_ch[$x]";
}
echo "  ,";

// Manha ***************************************************** B
echo " Manha(B)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ma_b_ch[$x]))
 {
   echo "$ma_b[$x]";
 }
 if(!empty($ma_b_ch[$x]))
 {
   echo "$ma_b_ch[$x]";
 }
}
echo "  ,";

// Manha ***************************************************** C
echo  "Manha(C)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ma_c_ch[$x]))
  echo "$ma_c[$x]";
 if(!empty($ma_c_ch[$x]))
  echo "$ma_c_ch[$x]";
}
echo "  ,";


echo " ;";

// Matutino ***************************************************** 
echo " Matutino";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($mat_a_ch[$x]))
   echo "$mat_a[$x]";
 if(!empty($mat_a_ch[$x]))
   echo "$mat_a_ch[$x]";
}

echo " ; ";

// Tarde ***************************************************** A
echo " Tarde(A)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_a_ch[$x]))
  echo "$ta_a[$x]";
 if(!empty($ta_a_ch[$x]))
  echo "$ta_a_ch[$x]";
}
echo "  ,";

// Tarde ***************************************************** B
echo " Tarde(B)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_b_ch[$x]))
  echo "$ta_b[$x]";
 if(!empty($ta_b_ch[$x]))
  echo "$ta_b_ch[$x]";
}
echo "  ,";

// Tarde ***************************************************** C
echo " Tarde(C)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_c_ch[$x]))
  echo "$ta_c[$x]";
 if(!empty($ta_c_ch[$x]))
  echo "$ta_c_ch[$x]";
}
echo "  ,";

// Tarde ***************************************************** D
echo " Tarde(D)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_d_ch[$x]))
  echo "$ta_d[$x]";
 if(!empty($ta_d_ch[$x]))
  echo "$ta_d_ch[$x]";
}
echo "  ;";

// Vespertino ***************************************************** 
echo " Vespertino";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ves_a_ch[$x]))
   echo "$ves_a[$x]";
 if(!empty($ves_a_ch[$x]))
   echo "$ves_a_ch[$x]";
}
echo " ;";

// Noite **************************************************** A
echo " Noite(A)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($na_a_ch[$x]))
  echo "$na_a[$x]";
 if(!empty($na_a_ch[$x]))
  echo "$na_a_ch[$x]";
}
echo " ,";

// Noite **************************************************** B
echo " Noite(B)";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($na_b_ch[$x]))
  echo "$na_b[$x]";
 if(!empty($na_b_ch[$x]))
  echo "$na_b_ch[$x]";
}
echo " ;";



?>  


