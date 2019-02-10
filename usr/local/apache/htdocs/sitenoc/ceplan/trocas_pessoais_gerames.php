<?
$ano=$HTTP_POST_VARS['ano'];
$mes=$HTTP_POST_VARS['mes'];

$numero_de_dias=date("t",mktime(0,0,0,$mes,01,$ano));

include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT numseq FROM escala_ch WHERE mes='$mes' and ano='$ano'";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{ 
 $numseq_up=$linha["numseq"];
}

if(!empty($numseq_up))
 echo "Erro: este Ano/Mes jah esta cadastrado na tabela de escala_ch TROCAS<BR>"; 

$sql = "SELECT numseq FROM escala WHERE mes='$mes' and ano='$ano'";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{ 
 $numseq_up=$linha["numseq"];
}

if(!empty($numseq_up))
 echo "Erro: este Ano/Mes jah esta cadastrado na tabela de escala HORARIO FIXO<BR>"; 


// Gera..............................................................................................
$madrugaa=$HTTP_POST_VARS['madrugaa'];
$madrugab=$HTTP_POST_VARS['madrugab'];
$manhaa  =$HTTP_POST_VARS['manhaa'];
$manhab  =$HTTP_POST_VARS['manhab'];
$manhac  =$HTTP_POST_VARS['manhac'];
$matutino=$HTTP_POST_VARS['matutino'];
$tardea  =$HTTP_POST_VARS['tardea'];
$tardeb  =$HTTP_POST_VARS['tardeb'];
$tardec  =$HTTP_POST_VARS['tardec'];
$tarded  =$HTTP_POST_VARS['tarded'];
$vespertino=$HTTP_POST_VARS['vespertino'];
$noitea    =$HTTP_POST_VARS['noitea'];
$noiteb    =$HTTP_POST_VARS['noiteb'];
$noitec    =$HTTP_POST_VARS['noitec'];

include ('ceplan_mes.php');
include ('mbcfg.inc');

//echo "MESSSSSSS $mes<BR>";
$mes_d=$mes;
$mes=convertemes($mes);

//Nao sei pq um dia eu coloquei esta linha.
//$numero_de_dias=$numero_de_dias-1;

$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "INSERT INTO escala (mes,ano, madrugaa, madrugab, manhaa, manhab, manhac, matutino, tardea, tardeb, tardec, tarded, vespertino, noitea, noiteb, noitec) VALUES ('$mes_d','$ano','$madrugaa', '$madrugab', '$manhaa', '$manhab', '$manhac', '$matutino', '$tardea', '$tardeb','$tardec', '$tarded', '$vespertino', '$noitea', '$noiteb','$noitec');";
$resultado = mysql_query($sql)
 or die ("Falha ao inserir na tabela $mes_d - $ano");

for($i=1;$i<=$numero_de_dias;$i++)
 {
  $dia_sem=date("D",mktime(0,0,0,$mes,$i,$ano));
  $dia=date("d",mktime(0,0,0,$mes,$i,$ano));
  $dia_sem=convertedia_sem($dia_sem);
  //echo "Passando $dia ---- $dia_sem<BR>";
  //if(($dia_sem != Sat) OR ($dia_sem !=  Sun))
  if(($dia_sem == Segunda) OR ($dia_sem == Terca) OR ($dia_sem == Quarta) OR ($dia_sem == Quinta) OR ($dia_sem == Sexta))
  {
   echo " $dia/$dia_sem <BR>\n";
   $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
   $db = mysql_select_db($imp_banco);
   $sql = "INSERT INTO escala_ch (dia,dia_sem,mes,ano) VALUES ('$dia','$dia_sem','$mes_d','$ano');";
   $resultado = mysql_query($sql)
    or die ("Falha ao inserir na tabela - $dia - $dia_sem - $mes_d - $ano");
  }
 }

?>
