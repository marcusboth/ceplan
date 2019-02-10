<style type='text/css'>
<!--
.linhanormal {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        color: #333333;
}
-->
</style>
</head>

<?
$mes  =$HTTP_POST_VARS['mesi'];
$ano  =$HTTP_POST_VARS['anoi'];
$mes_d=$HTTP_GET_VARS['mes_d'];

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
$sql ="select numseq,dia,dia_sem,mes,ano from escala_ch where escala_ch.ano='$ano' AND escala_ch.mes='$mes_d' ORDER by escala_ch.numseq ;";
$resultado = mysql_query($sql)
or die ("Selecione.");
$coluna=0;
while ($linha=mysql_fetch_array($resultado))
{
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
if(empty($parte[1]))
 {
  chamacadastro($mes_d,$ano);
  exit;
 }
echo "<p class='linhanormal'><a href='trocas_pessoais.php?mes_d=$mes_d&ano=$ano&tipo=TODO'>$mes_d [Ver todo o mes]</a> &nbsp;&nbsp;&nbsp;";
for($i=0;$i<$tot_semanas;$i++)
{
 $numero=($i+1);
 $numero.="a";
 if($i == 0)
  echo "<a href='trocas_pessoais.php?mes_d=$mes_d&ano=$ano&tipo=DIVIDIDO&limitei=0&limitef=$parte[1]'>[$numero Semana]</a>&nbsp;&nbsp;&nbsp; ";
 else
  echo "<a href='trocas_pessoais.php?mes_d=$mes_d&ano=$ano&tipo=DIVIDIDO&limitei=$parte[$i]&limitef=5'>[$numero Semana]</a>&nbsp;&nbsp;&nbsp;";
}


$mes_d=$HTTP_GET_VARS['mes_d'];
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
$sql ="select escala.*, escala_ch.* from escala,escala_ch where (escala.ano='$ano' AND escala_ch.ano='$ano') AND (escala.mes='$mes_d' AND escala_ch.mes='$mes_d') ORDER by escala_ch.numseq ;";
if($tipo == DIVIDIDO)
$sql ="select escala.*, escala_ch.* from escala,escala_ch where (escala.ano='$ano' AND escala_ch.ano='$ano') AND (escala.mes='$mes_d' AND escala_ch.mes='$mes_d') ORDER by escala_ch.numseq limit $limite_i, $limite_f;";
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
echo "escala.noitec     0 $linha[16]\n";   // noitec

echo "escala_ch.numseq   0 $linha[17]\n";  // numseq
echo "escala_ch.dia      0 $linha[18]<BR>\n";  // dia
echo "escala_ch.dia_sem  0 $linha[19]<BR>\n";  // dia sem
echo "escala_ch.mes      0 $linha[20]\n";  // mes
echo "escala_ch.ano      0 $linha[21]\n";  // ano
echo "escala_ch.madrugaa 0 $linha[22]\n";  // madruga a
echo "escala_ch.madrugab 0 $linha[23]\n";  // madruga b
 echo "escala_ch.manhaa   0 $linha[24]<BR>\n";  // manha a
echo "escala_ch.manhab   0 $linha[25]\n";  // manha b
echo "escala_ch.manhac   0 $linha[26]\n";  // manha c
echo "escala_ch.matutino 0 $linha[27]\n";  // matutino
echo "escala_ch.tardea   0 $linha[28]\n";  // tarde a
echo "escala_ch.tardeb   0 $linha[29]\n"; // tarde b
echo "escapa_ch.tardec   0 $linha[30]\n"; // tarde c
echo "escapa_ch.tarded   0 $linha[31]\n"; // tarde d
echo "escala_ch.vespertino 0 $linha[32]\n"; // vespertino
echo "escala_ch.noitea     0 $linha[33]\n";   // noitea
echo "escala_ch.noiteb    0 $linha[34]\n";   // noiteb
echo "escala_ch.noitec    0 $linha[35]\n";  // noitec
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
$numseq_ch[$coluna]="$linha[17]"; //numseq ch
$dia[$coluna]    ="$linha[18]";
$dia_sem[$coluna]="$linha[19]";
$md_a[$coluna]   ="$linha[3]";
$md_a_ch[$coluna]="$linha[22]";
$md_b[$coluna]   ="$linha[4]";
$md_b_ch[$coluna]="$linha[23]";

$ma_a[$coluna]   ="$linha[5]";
$ma_a_ch[$coluna]="$linha[24]";
$ma_b[$coluna]   ="$linha[6]";
$ma_b_ch[$coluna]="$linha[25]";
$ma_c[$coluna]   ="$linha[7]";
$ma_c_ch[$coluna]="$linha[26]";

$mat_a[$coluna]   ="$linha[8]";  // matutino
$mat_a_ch[$coluna]="$linha[27]";

$ta_a[$coluna]   ="$linha[9]";
$ta_a_ch[$coluna]="$linha[28]";
$ta_b[$coluna]   ="$linha[10]";
$ta_b_ch[$coluna]="$linha[29]"; /////////
$ta_c[$coluna]   ="$linha[11]";
$ta_c_ch[$coluna]="$linha[30]";
$ta_d[$coluna]   ="$linha[12]";
$ta_d_ch[$coluna]="$linha[31]";

$ves_a[$coluna]   ="$linha[13]";  // vespertino
$ves_a_ch[$coluna]="$linha[32]";

$na_a[$coluna]   ="$linha[14]";
$na_a_ch[$coluna]="$linha[33]";
$na_b[$coluna]   ="$linha[15]";
$na_b_ch[$coluna]="$linha[34]";
$na_c[$coluna]   ="$linha[16]";
$na_c_ch[$coluna]="$linha[35]";

$coluna++;

}

if(empty($numseq))
 {
  chamacadastro($mes_d,$ano);
  exit;
 }

$numero_de_dias=$coluna;

echo "<form name='form' method='post' action='trocas_pessoais_add.php'>";
echo "<tr class='linhanormal'>";
echo " <td>Turno/Dia</td>";
for($x=0;$x<$numero_de_dias;$x++)
  echo " <td>$dia[$x]/$dia_sem[$x]</td>";
echo "  </tr>";

echo "<tr  class='linhadestaque'>";
echo " <td width='153' class='tabelanormal'>Madruga(A)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($md_a_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20'  name='$numseq_ch[$x]-;-madrugaa_ch' value='$md_a[$x]'></td>         <input type='hidden' name='$numseq_ch[$x]-;-madrugaa' value='$md_a[$x]'>";
if(!empty($md_a_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20'  name='$numseq_ch[$x]-;-madrugaa_ch' value='$md_a_ch[$x]'></td>     <input type='hidden' name='$numseq_ch[$x]-;-madrugaa' value='$md_a_ch[$x]'>";
}
echo "</tr>";

echo "<tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Madruga(B)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($md_b_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-madrugab_ch' value='$md_b[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-madrugab' value='$md_b[$x]'>";
 if(!empty($md_b_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-madrugab_ch' value='$md_b_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-madrugab' value='$md_b_ch[$x]'>";
}
echo "  </tr>";

echo "<tr class=linhaembranco'>
<td . </td>
</td>";

// Manha ***************************************************** A
echo "<tr  class='linhadestaque'>";
echo " <td class='tabelanormal'>Manha(A)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
  //echo "$ma_a[$x] - $ma_a_ch[$x]<BR>";
 if(empty($ma_a_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-manhaa_ch' value='$ma_a[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-manhaa' value='$ma_a[$x]'>";
 if(!empty($ma_a_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-manhaa_ch' value='$ma_a_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-manhaa' value='$ma_a_ch[$x]'>";
}
echo "  </tr>";


// Manha ***************************************************** B
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Manha(B)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ma_b_ch[$x]))
 {
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-manhab_ch' value='$ma_b[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-manhab' value='$ma_b[$x]'>";
 }
 if(!empty($ma_b_ch[$x]))
 {
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-manhab_ch' value='$ma_b_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-manhab' value='$ma_b_ch[$x]'>";
 }
}
echo "  </tr>";


// Manha ***************************************************** C
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Manha(C)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ma_c_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-manhac_ch' value='$ma_c[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-manhac' value='$ma_c[$x]'>";
 if(!empty($ma_c_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-manhac_ch' value='$ma_c_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-manhac' value='$ma_c_ch[$x]'>";
}
echo "  </tr>";


echo "<tr class=linhaembranco'>
<td> </td>
</td>";

// Matutino ***************************************************** 
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Matutino</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($mat_a_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-matutino_ch' value='$mat_a[$x]'></td>                 <input type='hidden' name='$numseq_ch[$x]-;-matutino' value='$mat_a[$x]'>";
 if(!empty($mat_a_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-matutino_ch' value='$mat_a_ch[$x]'></td>                 <input type='hidden' name='$numseq_ch[$x]-;-matutino' value='$mat_a_ch[$x]'>";
}
echo "  </tr>";


echo "<tr class=linhaembranco'>
<td> </td>
</td>";

// Tarde ***************************************************** A
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Tarde(A)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_a_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tardea_ch' value='$ta_a[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tardea' value='$ta_a[$x]'>";
 if(!empty($ta_a_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tardea_ch' value='$ta_a_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tardea' value='$ta_a_ch[$x]'>";
}
echo "  </tr>";

// Tarde ***************************************************** B
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal' >Tarde(B)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_b_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tardeb_ch' value='$ta_b[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tardeb' value='$ta_b[$x]'>";
 if(!empty($ta_b_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tardeb_ch' value='$ta_b_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tardeb' value='$ta_b_ch[$x]'>";
}
echo "  </tr>";

// Tarde ***************************************************** C
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Tarde(C)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_c_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tardec_ch' value='$ta_c[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tardec' value='$ta_c[$x]'>";
 if(!empty($ta_c_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tardec_ch' value='$ta_c_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tardec' value='$ta_c_ch[$x]'>";
}
echo "  </tr>";

// Tarde ***************************************************** D
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Tarde(D)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ta_d_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tarded_ch' value='$ta_d[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tarded' value='$ta_d[$x]'>";
 if(!empty($ta_d_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-tarded_ch' value='$ta_d_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-tarded' value='$ta_d_ch[$x]'>";
}
echo "  </tr>";

echo "<tr class=linhaembranco'>
<td> </td>
</td>";

// Vespertino ***************************************************** 
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Vespertino</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($ves_a_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-vespertino_ch' value='$ves_a[$x]'></td>                 <input type='hidden' name='$numseq_ch[$x]-;-vespertino' value='$ves_a[$x]'>";
 if(!empty($ves_a_ch[$x]))
   echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-vespertino_ch' value='$ves_a_ch[$x]'></td>                 <input type='hidden' name='$numseq_ch[$x]-;-vespertino' value='$ves_a_ch[$x]'>";
}
echo "  </tr>";

echo "<tr class=linhaembranco'>
<td> </td>
</td>";


// Noite **************************************************** A
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Noite(A)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($na_a_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-noitea_ch' value='$na_a[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-noitea' value='$na_a[$x]'>";
 if(!empty($na_a_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-noitea_ch' value='$na_a_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-noitea' value='$na_a_ch[$x]'>";
}
echo "  </tr>";

// Noite **************************************************** B
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Noite(B)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($na_b_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-noiteb_ch' value='$na_b[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-noiteb' value='$na_b[$x]'>";
 if(!empty($na_b_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-noiteb_ch' value='$na_b_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-noiteb' value='$na_b_ch[$x]'>";
}
echo "  </tr>";


// Noite **************************************************** C
echo "   <tr class='linhadestaque'>";
echo " <td class='tabelanormal'>Noite(C)</td>";
for($x=0;$x<$numero_de_dias;$x++)
{
 $registros++;
 if(empty($na_c_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-noitec_ch' value='$na_c[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-noitec' value='$na_c[$x]'>";
 if(!empty($na_c_ch[$x]))
  echo "<td width='153'><input type='text' class='tabelatroca'  size='5' maxlength='20' name='$numseq_ch[$x]-;-noitec_ch' value='$na_c_ch[$x]'></td>                  <input type='hidden' name='$numseq_ch[$x]-;-noitec' value='$na_c_ch[$x]'>";
}
echo "  </tr>";  


echo "</table>";
echo "<input type='hidden' name='totpost' value='$registros'>";
echo "<input type='hidden' name='mes' value='$mes_d'>";
echo "<input type='hidden' name='ano' value='$ano'>";
echo "<input type='submit' name='Submit' value='Registrar troca'></form>";

Function chamacadastro($mes)
{
 //echo "$mes - $mes_d $ano<BR>";
 include ('trocas_pessoais_novoper.php');
}

?> 


