<?
function convertemes($mes)
 {
  switch ($mes)
   {
    case "Janeiro":
              $mes="1";
              break;
    case "Fevereiro":
              $mes="2";
              break;
    case "Marco":
              $mes="3";
              break;
    case "Abril":
              $mes="4";
              break;
    case "Maio":
              $mes="5";
              break;
    case "Junho":
              $mes="6";
              break;
    case "Julho":
              $mes="7";
              break;
    case "Agosto":
              $mes="8";
              break;
    case "Setembro":
              $mes="9";
              break;
    case "Outubro":
              $mes="10";
              break;
    case "Novembro":
              $mes="11";
              break;
    case "Dezembro":
              $mes="12";
              break;
 }
  return($mes);
}

function convertemes_br($mes)
 {
  switch ($mes)
   {
    case "01":
              $mes="Janeiro";
              break;
    case "02":
              $mes="Fevereiro";
              break;
    case "03":
              $mes="Marco";
              break;
    case "04":
              $mes="Abril";
              break;
    case "05":
              $mes="Maio";
              break;
    case "06":
              $mes="Junho";
              break;
    case "07":
              $mes="Julho";
              break;
    case "08":
              $mes="Agosto";
              break;
    case "09":
              $mes="Setembro";
              break;
    case "10":
              $mes="Outubro";
              break;
    case "11":
              $mes="Novembro";
              break;
    case "12":
              $mes="Dezembro";
              break;
 }
  return($mes);
}

function trocames_br($mes)
 {
  switch ($mes)
   {
    case "1":
              $mes="Janeiro";
              break;
    case "2":
              $mes="Fevereiro";
              break;
    case "3":
              $mes="Marco";
              break;
    case "4":
              $mes="Abril";
              break;
    case "5":
              $mes="Maio";
              break;
    case "6":
              $mes="Junho";
              break;
    case "7":
              $mes="Julho";
              break;
    case "8":
              $mes="Agosto";
              break;
    case "9":
              $mes="Setembro";
              break;
    case "10":
              $mes="Outubro";
              break;
    case "11":
              $mes="Novembro";
              break;
    case "12":
              $mes="Dezembro";
              break;
 }
  return($mes);
}

function convertedia_sem($dia_sem)
 {
  switch ($dia_sem)
   {
    case "Mon":
              $dia_sem="Segunda";
              break;
    case "Tue":
              $dia_sem="Terca";
              break;
    case "Wed":
              $dia_sem="Quarta";
              break;
    case "Thu":
              $dia_sem="Quinta";
              break;
    case "Fri":
              $dia_sem="Sexta";
              break;
  }
  return($dia_sem);
}

?>
