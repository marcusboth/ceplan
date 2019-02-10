<?
// CEPLAN 2.0 - NOC 2004
// 

include ('mbcfg.inc');

switch ($HTTP_SERVER_VARS[PHP_AUTH_USER]) 
 {
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
  case "a.rosito":
              $sysoplogado="Rosito";
              break;
  case "limam":
              $sysoplogado="Lima";
              break;
  case "fmello":
              $sysoplogado="Mello";
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
   case "lucio.mdl":
               $sysoplogado="Lucio";
               break;
   case "thiagomelo":
               $sysoplogado="Thiago";
               break;
   case "longarai":
               $sysoplogado="Longarai";
               break;
   case "rodrigo.ferreira":
               $sysoplogado="Rodrigo";
               break;
   case "morotiwolmer":
               $sysoplogado="Moroti";
	       break;
   case "rroitman";
	       $sysoplogado="Roitman";
               break;


 }

$moderador="Both";
// ---
// moderador eh aquele pode incluir trocas pessoas dos plantoes, administrar feriado, 
// preencher em nome de outro sysop e administrar a abertura de plantoes.
// ---


?>
