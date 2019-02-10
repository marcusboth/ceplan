<?
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabpla WHERE periodo='$mesini' ORDER by numseq;";
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");

$i=0;
while ($linha=mysql_fetch_array($resultado))
{
 $numseq    = $linha["numseq"];
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
 $madrugaach= $linha["madrugaach"];
 $madrugabch= $linha["madrugabch"];
 $manhaach  = $linha["manhaach"];
 $manhabch  = $linha["manhabch"];
 $tardeach  = $linha["tardeach"];
 $tardebch  = $linha["tardebch"];
 $noiteach  = $linha["noiteach"];
 $noitebch  = $linha["noitebch"];

echo "
<table width='100%' border='0'>
  <tr class='linha'> 
    <td width='13%'>$dia</td>";

    list($diax,$dia_s)=split("-",$dia);
    if($dia_s == "Sab")
       echo "<hr>";

    echo "
    <td width='0%'></td>
    <td width='20%'><div align='center'> 
        <table width='100%' border='0'>
          <tr class='trocapessoal'> 
            <td>$madrugaa&nbsp;</td>
            <td>$madrugab&nbsp;</td>
          </tr>
          <tr class='linhasaldosb'> 
            <td><b>$madrugaach&nbsp;</b></td>
            <td><b>$madrugabch&nbsp;</b></td>
          </tr>
        </table>
      </div></td>
    <td width='20%'><div align='center'> 
        <table width='90%' border='0'>
          <tr class='trocapessoal'> 
            <td>$manhaa&nbsp;</td>
            <td>$manhab&nbsp;</td>
          </tr>
          <tr class='linhasaldosb'> 
            <td><b>$manhaach&nbsp;</b></td>
            <td><b>$manhabch&nbsp;</b></td>
          </tr>
        </table>
      </div></td>
    <td width='20%'><div align='center'> 
        <table width='90%' border='0'>
          <tr class='trocapessoal'> 
            <td>$tardea&nbsp;</td>
            <td>$tardeb&nbsp;</td>
          </tr>
          <tr class='linhasaldosb'> 
            <td><b>$tardeach&nbsp;</b></td>
            <td><b>$tardebch&nbsp;</b></td>
          </tr>
        </table>
      </div></td>
    <td width='20%'><div align='center'> 
        <table width='100%' border='0'>
          <tr class='trocapessoal'> 
            <td>$noitea&nbsp;</td>
            <td>$noiteb&nbsp;</td>
          </tr>
          <tr class='linhasaldosb'> 
            <td><b>$noiteach&nbsp;</b></td>
            <td><b>$noitebch&nbsp;</b></td>
          </tr>
        </table>
      </div></td>
  </tr>
</table>";
}
?>

