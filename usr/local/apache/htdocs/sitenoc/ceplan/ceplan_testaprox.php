<?

// Funcao para testar se o proximo sysop pode marcar o plantao que esta vago, com status de 'preencher'.
// Testa somente o proximo sysop (sysop_1)
//
// ----------------------------------------------

$trueorfalse="FALSE";
$temp_seq=""; $temp_turno=""; $temp_plantaomarcado=""; $temp_dia="";

for($x=0;$x<$todos;$x++)
 {
  list($temp_seq[$x],$temp_turno[$x],$temp_plantaomarcado[$x],$temp_dia[$x])=split(";",$marcado_temp0[$x]);
  //echo "$temp_seq[$x] $temp_turno[$x],$temp_plantaomarcado[$x],$temp_dia[$x] aaaaaaaaaaaaaa <BR>";
  $temferiado=ereg("feriado",$temp_turno[$x]); 
  if(($temp_plantaomarcado[$x] == "preencher") AND (!$temferiado))
   {
    $preenchido_temp1="$x;9ID_TEMP9;$temp_turno[$x];$temp_dia[$x];$sysop_1";
    $marcado_temp0[$x]="$x;$temp_turno[$x];$sysop_1;$temp_dia[$x]";
    $posx=$x+1;
    $antx=$x-1; 
    $mesmodia_a=ereg($sysop_1,$marcado_temp0[$antx]);
    $mesmodia_p=ereg($sysop_1,$marcado_temp0[$posx]);
    // testa se nao esta sendo preenchido o mesmo turno.

    if(  ( ($temp_turno[$x] == mh) AND ($mesmodia_p) ) OR ( ($temp_turno[$x] == mi) AND ($mesmodia_a) )  )
     {
      //echo "Erro: Turno/Dia/Horario igual.<BR>";
      $trueorfalse="TRUE";
     }
    if(  ( ($temp_turno[$x] == ta) AND ($mesmodia_p) ) OR ( ($temp_turno[$x] == tb) AND ($mesmodia_a) )  )
     {
      //echo "Erro: Turno/Dia/Horario igual.<BR>";
      $trueorfalse="TRUE";
     }
    if(  ( ($temp_turno[$x] == na) AND ($mesmodia_p) ) OR ( ($temp_turno[$x] == nb) AND ($mesmodia_a) )  )
     {
      //echo "Erro: Turno/Dia/Horario igual.<BR>";
      $trueorfalse="TRUE";
     }

     // alimenta a variavel que sera usada para gravar no banco.
     $preenchido_temp_db[$i_preenchido_tmp]="$x;9ID_TEMP9;$temp_turno[$x];$temp_dia[$x];$sysop_1";
     $i_preenchido_tmp++;

     $x=$todos; // se achar um 'preencher' jah interrompe o for
   }
 } // fim do teste pra ver se o proximo sysop pode marcar o proximo plantao vago, com status de 'preencher'.

 if($trueorfalse == "TRUE")
  {
   $mesg="Restara para o proximo sysop $sysop_1 o plantao jah marcado por ele. - verifique.";
   $permitido="";
   chamaerro($mesg,$permitido);
   exit;
  }
?>
