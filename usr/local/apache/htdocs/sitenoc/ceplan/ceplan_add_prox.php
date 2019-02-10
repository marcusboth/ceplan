<?
//
// Grava o preenchimento normal obrigatorio do proximo [sysop_1] ---------
//

for($x=0;$x<$i_preenchido_tmp;$x++)
{
 echo "$preenchido[$x]<BR>";
 list($lixotemp,$lixotemp2,$hora,$dia,$sysoptmp)=split(";",$preenchido_temp_db[$x]);

if($hora == "ma")
 $sqlinsere="UPDATE tabpla SET madrugaa='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";
if($hora == "mb")
 $sqlinsere="UPDATE tabpla SET madrugab='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";

if($hora == "mh")
 $sqlinsere="UPDATE tabpla SET manhaa='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";
if($hora == "mi")
 $sqlinsere="UPDATE tabpla SET manhab='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";

if($hora == "ta")
 $sqlinsere="UPDATE tabpla SET tardea='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";
if($hora == "tb")
 $sqlinsere="UPDATE tabpla SET tardeb='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";

if($hora == "na")
 $sqlinsere="UPDATE tabpla SET noitea='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";
if($hora == "nb")
 $sqlinsere="UPDATE tabpla SET noiteb='$sysop_1' WHERE periodo='$periodo' AND dia='$dia';";

  $resultado = mysql_query($sqlinsere)
 or die ("Nao foi  possivel realizar a consulta ao banco de dados [sysop_1] $numseq");
}
// ----------------------------------------- fim - grava o proximo sysop_1


// Atualiza a tabela de ordem, diminuindo o saldos do mes.
$numseq_up=""; $periodo=""; $sysop_up=""; $nplant=""; $saldomes=""; $saltot=""; 
$sql = "SELECT numseq,periodo,sysop,nplant,saldomes FROM tabord WHERE periodo='$mesini' and sysop='$sysop_1'";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados - Proximo sysop: $sysop_1");
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

// Updating o proximo sysop_1
$sqlup = "UPDATE tabord SET nplant='$nplant', saldomes='$saldomes' WHERE periodo='$mesini' and sysop='$sysop_1' and numseq='$numseq_up'";
$resultado = mysql_query($sqlup)
or die ("Nao foi possivel atualizar a tabord - $mesini - $sysop_1 [sysop_1] $numseq_up");

// fim do update na tabela.

?>
