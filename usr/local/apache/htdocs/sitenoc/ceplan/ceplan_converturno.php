<?
function verificarturno($escolha)
 {
  list($seq,$numseq,$turnoescolhido,$dia)=split(";",$escolha);
  switch ($turnoescolhido)
   {
    case "ma":
              $turno="madrugada";
              break;
    case "mb":
              $turno="madrugada";
              break;
    case "mh":
              $turno="manha";
              break;
    case "mi":
              $turno="manha";
              break;
    case "ta":
              $turno="tarde";
              break;
    case "tb":
              $turno="tarde";
              break;
    case "na":
              $turno="noite";
              break;
    case "nb":
              $turno="noite";
              break;
    case "maferiado":
                     $turno="madrugada";
                     break;
    case "mbferiado":
                     $turno="madrugada";
                     break;
    case "mhferiado":
                     $turno="manha";
                     break;
    case "miferiado":
                     $turno="manha";
                     break;
    case "taferiado":
                     $turno="tarde";
                     break;
    case "tbferiado":
                     $turno="tarde";
                     break;
    case "naferiado":
                     $turno="noite";
                     break;

    case "nbferiado":
                     $turno="noite";
                     break;
   }
   $turno.=";$dia";
  // $numseq.=";$turno";
  // $seq.=";$numseq";
   $seq.=";$turno";
   $turno=$seq;
   //echo "Turno Marcado: $turno<BR>\n";
  return($turno);
 }

function verificarturno_envmail($escolha)
 {
  list($seq,$numseq,$turnoescolhido,$dia)=split(";",$escolha);
  switch ($turnoescolhido)
   {
    case "ma":
              $turno="Madrugada 1h as 7hs";
              break;
    case "mb":
              $turno="Madrugada 1h as 7hs B";
              break;
    case "mh":
              $turno="Manha 7hs as 13hs ";
              break;
    case "mi":
              $turno="Manha 7hs as 13hs B";
              break;
    case "ta":
              $turno="Tarde 13hs as 19hs ";
              break;
    case "tb":
              $turno="Tarde 13hs as 19hs B";
              break;
    case "na":
              $turno="Noite 19h a 1h ";
              break;
    case "nb":
              $turno="Noite 19h a 1h B";
              break;
    case "maferiado":
                     $turno="Madrugada 1h as 7hs (feriado)";
                     break;
    case "mbferiado":
                     $turno="madrugada 1h as 7hs (feriado) B";
                     break;
    case "mhferiado":
                     $turno="Manha 7hs as 13hs (feriado)";
                     break;
    case "miferiado":
                     $turno="Matutino 10hs as 16hs (feriado) ";
                     break;
    case "taferiado":
                     $turno="Tarde 13hs as 19hs (feriado)";
                     break;
    case "tbferiado":
                     $turno="Vespertino 16hs as 22hs (feriado) ";
                     break;
    case "naferiado":
                     $turno="Noite 19hs as 1h (feriado)";
                     break;

    case "nbferiado":
                     $turno="Noite  19hs as 1h (feriado) B";
                     break;
   }
   $turno.="- $dia";
  return($turno);
 }

?>
