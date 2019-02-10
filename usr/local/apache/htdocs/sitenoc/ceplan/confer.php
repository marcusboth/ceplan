<?
echo "<p><font face='Courier New' size='3'>Feriados Jah Cadastrados:</font></p>";
$ultnumseq="0";
include ('mbcfg.inc');
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabfer ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("Não foi possível realizar a consulta ao banco de dados");
while ($linha=mysql_fetch_array($resultado))
{
 $numseq   =$linha["numseq"];
 $periodo  =$linha["periodo"];
 $dia      =$linha["dia"];
 $diasem   =$linha["diasem"];
 $descricao=$linha["descricao"];
 echo "<font face='Courier New' size='2'>$periodo - $dia $diasem - $descricao </font><BR>";
 if($numseq > $ultnumseq)
  $ultnumseq=$numseq;
}

echo "
<BR>
<form method='POST' action='cadfer.php'>
  <p>
  <input type='text' name='periodo'   size='20' value='DDMMYYYaDDMMYYYY'> 
  <input type='text' name='dia'       size='5'  value='09/09'>
   <select name='diasem'>
    <option value='Sun'>Domingo</option>
    <option value='Mon'>Segunda</option>
    <option value='Tue'>Terca</option>
    <option value='Wed'>Quarta</option>
    <option value='Thu'>Quinta</option>
    <option value='Fri'>Sexta</option>
    <option value='Sat'>Sabado</option>

  </select>
  <input type='text' name='descricao' size='20'><br>
  <br>
  <input type='HIDDEN' name=ultnumseq value='$ultnumseq'>
  <input type='submit' value='Cadastrar' name='B1'></p>
</form>

 <p><font face='Courier New' size='2'><a href='ceplan-geraperiodo.php' target='mainFrame'>Novo Periodo</a></font></p>

</body>
</html>
";
?>
