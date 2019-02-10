<?

Function traduz_semana($english_day)
{
switch($english_day)
{
    case "Mon":
        $portuguese_day = "Seg";
        break;
    case "Tue":
        $portuguese_day = "Ter";
        break;
    case "Wed":
        $portuguese_day = "Qua";
        break;
    case "Thu":
        $portuguese_day = "Qui";
        break; 
    case "Fri":
        $portuguese_day = "Sex";
        break;
    case "Sat":
        $portuguese_day = "Sab";
        break;
    case "Sun":
        $portuguese_day = "Dom";
        break;
}
return ($portuguese_day);
}

?>
