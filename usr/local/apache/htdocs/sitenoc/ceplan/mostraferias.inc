<?
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT sysop,qtferias,ferias FROM tabord WHERE periodo='$mesini' AND ferias != '0' ORDER BY numseq"; 
$resultado = mysql_query($sql)
or die ("Nao foi possivel realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $sysop    =$linha["sysop"];
 $qtferias =$linha["qtferias"];
 $ferias   =$linha["ferias"]; 
 echo "
  <td> 
    <table width='100%' border='0' class='subtabela'>
     <tr>
       <td width='100%' class='linhasaldosb'><b>$sysop</b></td>
     </tr>
     <tr>
       <td width='100%' class='linhasaldosb'>$ferias</td>
     </tr>
    </table>
  </tr>
 </table></td>";
}
?>
