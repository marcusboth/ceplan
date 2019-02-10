<?

$mes=$HTTP_POST_VARS['mes'];
$ano=$HTTP_POST_VARS['ano'];
//$mes=Agosto;
//$ano=2004;

if(empty($mes))
 {
  echo "Variavel mes esta vazia<BR>";
  exit;
 }
if(empty($ano))
 {
  echo "Variavel ano esta vazia<BR>";
  exit;
 }

$x=0;

 include ('mbcfg.inc');
 $conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
 $db = mysql_select_db($imp_banco);
 $sql = "SELECT numseq FROM escala_ch where mes='$mes' and ano='$ano' order by numseq;";
 $resultado = mysql_query($sql)
 or die ("Não foi possível realizar a consulta ao banco de dados");
 while ($linha=mysql_fetch_array($resultado)) 
 {
  $numseq=$linha["numseq"];

  $madrugaa="$numseq-;-madrugaa";
  $madrugaa=$HTTP_POST_VARS[$madrugaa];
  $madrugaa_ch="$numseq-;-madrugaa_ch";
  $madrugaa_ch=$HTTP_POST_VARS[$madrugaa_ch];
  //echo "$madrugaa ..................... $madrugaa_ch<BR>";
  if("$madrugaa" != "$madrugaa_ch")
   {
    $original[$x]="$madrugaa";
    $gravatroca[$x]="$numseq-;-madrugaa-;-$madrugaa_ch";
    $x++;
   }


  $madrugab="$numseq-;-madrugab";
  $madrugab=$HTTP_POST_VARS[$madrugab];
  $madrugab_ch="$numseq-;-madrugab_ch";
  $madrugab_ch=$HTTP_POST_VARS[$madrugab_ch];
  //echo "$madrugab ..................... $madrugab_ch<BR>";
  if("$madrugab" != "$madrugab_ch")
   { 
    $original[$x]="$madrugab";
    $gravatroca[$x]="$numseq-;-madrugab-;-$madrugab_ch";
    $x++;
   }


  $manhaa="$numseq-;-manhaa";
  $manhaa=$HTTP_POST_VARS[$manhaa];
  $manhaa_ch="$numseq-;-manhaa_ch";
  $manhaa_ch=$HTTP_POST_VARS[$manhaa_ch];
  //echo "$manhaa ..................... $manhaa_ch<BR>";
  if("$manhaa" != "$manhaa_ch")
   {
    $original[$x]="$manhaa";
    $gravatroca[$x]="$numseq-;-manhaa-;-$manhaa_ch";
    $x++;
   }


  $manhab="$numseq-;-manhab";
  $manhab=$HTTP_POST_VARS[$manhab];
  $manhab_ch="$numseq-;-manhab_ch";
  $manhab_ch=$HTTP_POST_VARS[$manhab_ch];
  //echo "$manhab ..................... $manhab_ch<BR>";
  if("$manhab" != "$manhab_ch")
   {
    $original[$x]="$manhab";
    $gravatroca[$x]="$numseq-;-manhab-;-$manhab_ch";
    $x++;
   }


  $manhac="$numseq-;-manhac";
  $manhac=$HTTP_POST_VARS[$manhac];
  $manhac_ch="$numseq-;-manhac_ch";
  $manhac_ch=$HTTP_POST_VARS[$manhac_ch];
  //echo "$manhac ..................... $manhac_ch<BR>";
  if("$manhac" != "$manhac_ch")
   {
    $original[$x]="$manhac";
    $gravatroca[$x]="$numseq-;-manhac-;-$manhac_ch";
    $x++;
   }


  $matutino="$numseq-;-matutino";
  $matutino=$HTTP_POST_VARS[$matutino];
  $matutino_ch="$numseq-;-matutino_ch";
  $matutino_ch=$HTTP_POST_VARS[$matutino_ch];
  //echo "$matutino ..................... $matutino_ch<BR>";
  if("$matutino" != "$matutino_ch")
   {
    $original[$x]="$matutino";
    $gravatroca[$x]="$numseq-;-matutino-;-$matutino_ch";
    $x++;
   }


  $tardea="$numseq-;-tardea";
  $tardea=$HTTP_POST_VARS[$tardea];
  $tardea_ch="$numseq-;-tardea_ch";
  $tardea_ch=$HTTP_POST_VARS[$tardea_ch];
  //echo "$tardea ..................... $tardea_ch<BR>";
  if("$tardea" != "$tardea_ch")
   {
    $original[$x]="$tardea";
    $gravatroca[$x]="$numseq-;-tardea-;-$tardea_ch";
    $x++;
   }

  $tardeb="$numseq-;-tardeb";
  $tardeb=$HTTP_POST_VARS[$tardeb];
  $tardeb_ch="$numseq-;-tardeb_ch";
  $tardeb_ch=$HTTP_POST_VARS[$tardeb_ch];
  //echo "$tardeb ..................... $tardeb_ch<BR>";
  if("$tardeb" != "$tardeb_ch")
   {
    $original[$x]="$tardeb";
    $gravatroca[$x]="$numseq-;-tardeb-;-$tardeb_ch";
    $x++;
   }

  $tardec="$numseq-;-tardec";
  $tardec=$HTTP_POST_VARS[$tardec];
  $tardec_ch="$numseq-;-tardec_ch";
  $tardec_ch=$HTTP_POST_VARS[$tardec_ch];
  //echo "$tardec ..................... $tardec_ch<BR>";
  if("$tardec" != "$tardec_ch")
   {
    $original[$x]="$tardec";
    $gravatroca[$x]="$numseq-;-tardec-;-$tardec_ch";
    $x++;
   }

  $tarded="$numseq-;-tarded";
  $tarded=$HTTP_POST_VARS[$tarded];
  $tarded_ch="$numseq-;-tarded_ch";
  $tarded_ch=$HTTP_POST_VARS[$tarded_ch];
  //echo "$tarded ..................... $tarded_ch<BR>";
  if("$tarded" != "$tarded_ch")
   {
    $original[$x]="$tarded";
    $gravatroca[$x]="$numseq-;-tarded-;-$tarded_ch";
    $x++;
   }

  $vespertino="$numseq-;-vespertino";
  $vespertino=$HTTP_POST_VARS[$vespertino];
  $vespertino_ch="$numseq-;-vespertino_ch";
  $vespertino_ch=$HTTP_POST_VARS[$vespertino_ch];
  //echo "$vespertino ..................... $vespertino_ch<BR>";
  if("$vespertino" != "$vespertino_ch")
   {
    $original[$x]="$vespertino";
    $gravatroca[$x]="$numseq-;-vespertino-;-$vespertino_ch";
    $x++;
   }

  $noitea="$numseq-;-noitea";
  $noitea=$HTTP_POST_VARS[$noitea];
  $noitea_ch="$numseq-;-noitea_ch";
  $noitea_ch=$HTTP_POST_VARS[$noitea_ch];
  //echo "$noitea ..................... $noitea_ch<BR>";
  if("$noitea" != "$noitea_ch")
   {
    $original[$x]="$noitea";
    $gravatroca[$x]="$numseq-;-noitea-;-$noitea_ch";
    $x++;
   }


  $noiteb="$numseq-;-noiteb";
  $noiteb=$HTTP_POST_VARS[$noiteb];
  $noiteb_ch="$numseq-;-noiteb_ch";
  $noiteb_ch=$HTTP_POST_VARS[$noiteb_ch];
  //echo "$noiteb ..................... $noiteb_ch<BR>";
  if("$noiteb" != "$noiteb_ch")
   {
    $original[$x]="$noiteb";
    $gravatroca[$x]="$numseq-;-noiteb-;-$noiteb_ch";
    $x++;
   }

  $noitec="$numseq-;-noitec";
  $noitec=$HTTP_POST_VARS[$noitec];
  $noitec_ch="$numseq-;-noitec_ch";
  $noitec_ch=$HTTP_POST_VARS[$noitec_ch];
  //echo "$noitec ..................... $noitec_ch<BR>";
  if("$noitec" != "$noitec_ch")
   {
    $original[$x]="$noitec";
    $gravatroca[$x]="$numseq-;-noitec-;-$noitec_ch";
    $x++;
   }


 }

$conexao = mysql_connect("$imp_hostname","$imp_user","$imp_pass");
$db = mysql_select_db($imp_banco);

$numseq_ch="";$turno="";$sysop_ch=""; $email=""; $mailheaders=""; $subject=""; $texto="";
for($i=0;$i<$x;$i++)
 {
  $texto=""; $mailheaders="";
  //echo "Trocas: Sai: $original[$i]   Entra: $gravatroca[$i]<BR>";
  list($numseq_ch,$turno,$sysop_ch)=split("-;-",$gravatroca[$i]);
  $sqlconsulta="SELECT dia,dia_sem from escala_ch where numseq='$numseq_ch'";
  $resultadoconsulta = mysql_query($sqlconsulta)
   or die ("Erro ao consultar base");
  while ($linhaconsulta=mysql_fetch_array($resultadoconsulta))
   {
    $dia    =$linhaconsulta["dia"];
    $dia_sem=$linhaconsulta["dia_sem"];
   }

  $sysopauth=$HTTP_SERVER_VARS[PHP_AUTH_USER];
  $email="trr_river@terra.com.br";
  $mailheaders="From: ".$sysopauth ."<$email>\n";
  $mailheaders.="Reply-To: ."<"$email>\n";
  $mailheaders.="Content-transfer-encoding: 7BIT\n";
  //$mailheaders.="References: <trrceplan@terra.com.br>\n";
  $mailheaders.="Return-Path: <$email>\n";
  //$mailheaders.="Message-id: <trrceplan@terra.com.br>\n";
  $mailheaders.="IP: "."<$REMOTE_ADDR>\n";
  $mailheaders.="X-mailer: XServer\n";
  $mailheaders.="MIME-version: 1.0\n";
  $mailheaders.="Comments: [TrocaHorario]\n";
  $subject="[TrocaHorario]$original[$i] <--> $sysop_ch - $turno ($dia_sem) $dia/$mes/$ano";
  $texto.="$sysopauth efetuou a seguinte troca: \n";
  $texto.="Sai $original[$i] e entra $sysop_ch no turno $turno no dia $dia/$mes/$ano ($dia_sem).\n";
  $texto.="\n";
  $texto.="http://aquario.terra.com.br/ceplan/trocas.php\n";
  $texto.="--[ceplan v1.1]--\n";
  mail("trr_river@terra.com.br", $subject, $texto, $mailheaders);

  echo " <BR>";
  echo "$original[$i] <> $sysop_ch - $turno - $dia/$dia_sem<BR>";
  echo "$sysopauth realizou a seguinte troca: $original[$i] <> $sysop_ch [$turno] no dia $dia/$dia_sem<BR>";
  echo " <BR>";

  $sql ="UPDATE escala_ch SET $turno='$sysop_ch' where mes='$mes' and ano='$ano' and numseq='$numseq_ch'";
  $resultado = mysql_query($sql)
   or die ("Falha ao atualizar tabela");
 }

 echo "<br>Foi enviado um email para lista trr_river@terra.com.br notificando a troca.<BR>";

?>

