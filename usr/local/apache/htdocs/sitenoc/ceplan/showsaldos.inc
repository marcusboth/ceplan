<?
echo " <table width='300' border='0'>
<tr>
 <td> <table width='250' border='0'>";
 
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord WHERE periodo='$mesini' ORDER BY numseq"; 
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
$flag="FALSE"; $ordem="0";
while ($linha=mysql_fetch_array($resultado)) 
{
 $periodo  =$linha["periodo"];
 $trimestre=$linha["trimestre"];
 $librod   =$linha["librod"];
 $sysop    =$linha["sysop"];
 $nplant   =$linha["nplant"];
 $saldomes =$linha["saldomes"];
 $saltot   =$linha["saltot"];
 $qtferias =$linha["qtferias"];
 $ferias   =$linha["ferias"]; 
 
 $ordem++;
 if($flag == "FALSE")
  {
   echo " <tr> 
     <td> 
       <table width='100%' border='0' height='10' class='tabelasaldos'>
         <tr class='linhasaldosb'> 
           <td width='7%'  >$ordem</td>
           <td width='27%' >$sysop</td>
           <td width='15%' ><div align='right'>$nplant</td>
           <td width='8%'  ><div align='right'>$qtferias</td>
           <td width='15%' ><div align='right'>$saldomes</td>
           <td width='15%' ><div align='right'>$saltot</td>";
           if($qtferias != 0) 
             echo "<td width='2%' ><div align='right'><img src='ico_atencao.gif' alt='Clique no Icone Ferias'>  </td>";
           else 
             echo "<td width='2%' ><div align='right'>&nbsp;&nbsp;&nbsp;</td>"; 
    echo "</tr>
        </table>
     </td>
   </tr>";
   $flag="TRUE";
  }
 else
  {
   echo " <tr>
      <td>
        <table width='100%' height='10' border='0' class='tabelasaldos'>
          <tr class='linhasaldosb'> 
            <td width='7%'  >$ordem</td>
            <td width='27%' >$sysop</td>
            <td width='15%' ><div align='right'>$nplant</td>
            <td width='8%'  ><div align='right'>$qtferias</td>
            <td width='15%' ><div align='right'>$saldomes</td>
            <td width='15%' ><div align='right'>$saltot</td>";
           if($qtferias != 0) 
             echo "<td width='2%' ><div align='right'><img src='ico_atencao.gif' alt='Clique no Icone Ferias'>  </td>";
           else 
             echo "<td width='2%' ><div align='right'>&nbsp;&nbsp;&nbsp;</td>";  
     echo "</tr>
        </table>
     </td>
    </tr>";
   $flag="FALSE";
  }
}
?>
