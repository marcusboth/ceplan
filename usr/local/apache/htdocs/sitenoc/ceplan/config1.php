<?
// Alteracao no controle de 0.5 - 28/7/2003.

include 'mbcfg.php';
$totalsysop="13";

switch ($HTTP_SERVER_VARS[PHP_AUTH_USER]) 
 {
  case "lucio.mdl":
              $sysoplogado="Lucio";
              break;
  case "thiagomelo":
              $sysoplogado="Thiago";
              break;
  case "exkg":
              $sysoplogado="Luciano";
              break;
  case "mbarriles":
              $sysoplogado="Fios";
              break;
  case "mboth":
              $sysoplogado="Both";
              break;
  case "eduardms":
              $sysoplogado="Eduardo";
              break;
  case "cluciano":
              $sysoplogado="Castro";
              break;
  case "a.rosito":
              $sysoplogado="Rosito";
              break;
  case "limam":
              $sysoplogado="Lima";
              break;
  case "fmello":
              $sysoplogado="Mello";
              break;
  case "longarai":
              $sysoplogado="Longarai";
              break;
  case "iperdomo":
              $sysoplogado="Igor";
              break;
  case "rsortica":
              $sysoplogado="Raoni";
              break;
  case "thatyr":
              $sysoplogado="Thaty";
              break;
 }

$mostramsglogado="<font face='Courier New' size=1>user: $sysoplogado &nbsp;&nbsp;ip:$HTTP_SERVER_VARS[REMOTE_ADDR]</font>";
// $mostramsglogado="<p><font face='Courier New' size=1>user: $sysoplogado &nbsp;&nbsp;ip:$HTTP_SERVER_VARS[REMOTE_ADDR]</font></p>";
$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);
$sql = "SELECT * FROM tabord WHERE periodo='$mesini' ORDER BY numseq";
$resultado = mysql_query($sql)
or die ("N�o foi poss�vel realizar a consulta ao banco de dados");

$flag="-99"; $devflag="99";
$comdevedor="NO";

while ($linha=mysql_fetch_array($resultado)) 
{
 $numseq   =$linha["numseq"];
 $periodo  =$linha["periodo"];
 $trimestre=$linha["trimestre"];
 $librod   =$linha["librod"];
 $sysop_ult    =$linha["sysop"];
 $nplant   =$linha["nplant"];
 $saldomes =$linha["saldomes"];
 $saltot   =$linha["saltot"];
 $qtferias =$linha["qtferias"];
 $ferias   =$linha["ferias"];

 //echo "NPLANT: $nplant SALDOmes: $saldomes SaldoTot: $saltot # $sysop_ult\n";
 if($qtferias == 0)
  {
   if(($nplant > 0.5) AND ($nplant > $flag))
    {
     $flag=$nplant;
     $parado_em=$sysop_ult;
     $permitido="1";
     if ($nplant >= 2)
      {
       $flag=$nplant;
       $parado_em=$sysop_ult;
       $permitido="2";
      }
     //echo "Libera $permitido plantao para o $sysop_ult<BR>\n";
    }

   if(($nplant <= 0.5) AND ($saldomes >= 0) AND ($saltot < 0))
    {
     //$comdevedor="true";
     $saldodevedor=($saldomes+$saltot);
     if($saldodevedor < $devflag)
      {
       $devflag=$saldodevedor;
       //echo "FLAG ficou com $saldodevedor<BR>\n";
       $parado_em=$sysop_ult;
       $permitido="1";
       //$comdevedor="true";
      }
      //echo "......Libera $permitido plantao para o $sysop_ult DEVEDOR<BR>\n";
      $comdevedor="OK";
    }    
  //echo "a $comdevedor<BR>\n";
  if($comdevedor == "NO")
   {
   if (($nplant <= 0.5) AND ($nplant > 0) AND ($saltot == 0))
    {
     //echo "Tem zerado $sysop_ult<BR>\n";
     //$devflag=$saldodevedor;
     //echo "FLAG ficou com $saldodevedor<BR>\n";
     $parado_em=$sysop_ult;
     $permitido="1";
     $comdevedor="OK";
    }
  if(($nplant <= 0.5) AND ($nplant > 0) AND ($saltot <= 3))
   {
    $devflag=$saldodevedor;
    //echo "FLAG ficou com $saldodevedor<BR>\n";
    $parado_em=$sysop_ult;
    $permitido="1";
    $comdevedor="OK";
   }
   }
  }
}
//echo "\n\n$paradoem - deve preencher $permitido<BR>\n";
$s = filectime("ctrlmarcacao.sys");
$ultalt = date("d/m/Y H:i", $s);
$paradoem="<p><font face='Courier New' size=2>O preenchimento dos plantoes estah parado no <b><font color='#FF0000'>$parado_em </b></font> desde $ultalt </p>";

$sysoplogado=$sysoplogado;

$moderador="";
// Moderador dos plantoes
$root="mboth";
if($HTTP_SERVER_VARS[PHP_AUTH_USER] == $$imp_user)
 $moderador="LIBERA";

?>
