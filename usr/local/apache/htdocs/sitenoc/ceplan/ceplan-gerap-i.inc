<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>CEPLAN - inclusao ordem de sorteados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.texto {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
.campo {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #003399;
	text-decoration: none;
	border: 1px solid #0066FF;
}
-->
</style>
<style type="text/css">
<!--
.botao {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #333333;
	border: 1px solid #CCCCCC;
}
-->
</style>
</head>

<body>
<table width="90%" border="0">
  <tr>
    <td width="57%" class="texto">Informe o número de Sysop's para este período <? echo "$prox_descricao"; ?> </td>
    <td width="83%">      <form name="form1" method="post" action="ceplan-gerap-ii.php">
          <input name="numero" type="text" class="campo" id="numero" value="<? echo "$totsysop"; ?>" size="2" maxlength="2">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input name="Submit" type="submit" class="botao" value="Proximo &gt;&gt; ">
        <script>document.form1.numero.focus()</script>
      <input type="hidden" name="ultperiodo" value='<? echo "$ult_periodo"; ?>'>
      <input type="hidden" name="ultnumseq" value='<? echo "$ultnumseqa"; ?>'>
      <input type="hidden" name="proxperiodo" value='<? echo "$mesini"; ?>'>
      <input type="hidden" name="prox_descricao" value='<? echo "$prox_descricao"; ?>'>
      </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><br>
</p>
</body>
</html>

