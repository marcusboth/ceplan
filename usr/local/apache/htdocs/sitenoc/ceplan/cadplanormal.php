<table width='100%' border='0'>
        <tr> 
         <td> <table width='100%' border='0' class='linha'>

              <tr>  
                <td width='10' ><? echo "$diax"; ?></td>
                <td width='10' ><? echo "$dia_s"; ?></td>
                <td width='21%'> 
                <table width='100' border='0' bgcolor='#FFFFCC' class='centraliza'>
                    <tr class='linha'> 

      <? 
      if($madrugaa == "preencher")  
        {
         echo "<td width='50' class='linha'><input type='checkbox' name='ma$i' value='$tot_i;$numseq;ma;$dia'></td> 
               <input type='hidden' name='marcado$tot_i' value='$tot_i;ma;$madrugaa;$dia'>";
         $faltapreencher++; $tot_i++; 
        }
      else
        {
         if($destaque == $madrugaa)
          echo "<td width='50' class='linhadestaque'>$madrugaa</td><input type='hidden' name='marcado$tot_i' value='$tot_i;ma;$madrugaa;$dia'>";
        else
          echo "<td width='50'>$madrugaa</td><input type='hidden' name='marcado$tot_i' value='$tot_i;ma;$madrugaa;$dia'>";
        $tot_i++;
        }
         
       //ainda nao existe duplo durante a madrugdada, deixar isto abaixo
         echo "<td width='50'>&nbsp;</td>";
       ?>                      
                      
                    </tr>
                  </table></td>
                <td width='21%' class='linha'> <table width='100%' border='0' bgcolor='#FFCC99' class='centraliza'>
                    <tr class='linha'> 

      <?
      if($manhaa == "preencher")  
        {
         echo "<td width='50' class='linha'><input type='checkbox' name='mh$i' value='$tot_i;$numseq;mh;$dia'></td>
                <input type='hidden' name='marcado$tot_i' value='$tot_i;mh;$manhaa;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $manhaa)
          echo "<td width='50' class='linhadestaque'><b>$manhaa</b></td><input type='hidden' name='marcado$tot_i' value='$tot_i;mh;$manhaa;$dia'>";
         else
          echo "<td width='50'>$manhaa</td><input type='hidden' name='marcado$tot_i' value='$tot_i;mh;$manhaa;$dia'>";
         $tot_i++;
        }
                    
      if($manhab == "preencher")
        {
         echo "<td><input type='checkbox' name='mi$i' value='$tot_i;$numseq;mi;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;mi;$manhab;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $manhab)
          echo "<td width='50' class='linhadestaque'>$manhab</font></td><input type='hidden' name='marcado$tot_i' value='$tot_i;mi;$manhab;$dia'>";
         else
          echo "<td width='50'>$manhab</td><input type='hidden' name='marcado$tot_i' value='$tot_i;mi;$manhab;$dia'>";
         $tot_i++;
        }

       ?>                      
                      
                    </tr>
                  </table></td>
                <td width='21%' class='linha'><table width='100%' border='0' bgcolor='#99CCCC' class='centraliza'>
                    <tr class='linha'> 
                    
      <?
      if($tardea == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='ta$i' value='$tot_i;$numseq;ta;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;ta;$tardea;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $tardea)
          echo "<td width='50' class='linhadestaque'>$tardea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;ta;$tardea;$dia'>";
         else
          echo "<td width='50'>$tardea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;ta;$tardea;$dia'>";
         $tot_i++;
        }

      if($tardeb == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='tb$i' value='$tot_i;$numseq;tb;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;tb;$tardeb;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $tardeb)
          echo "<td width='50' class='linhadestaque'>$tardeb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;tb;$tardeb;$dia'>";
         else
          echo "<td width='50'>$tardeb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;tb;$tardeb;$dia'>";
         $tot_i++;
        }
       ?>
         
                    </tr>  
                  </table></td>
                <td width='21%' class='linha'><table width='100%' border='0' bgcolor='#CCFFFF' class='centraliza'>
                    <tr class='linha'> 

      <?                    
      if($noitea == "preencher")  
        {
         echo "<td><input type='checkbox' name='na$i' value='$tot_i;$numseq;na;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;na;$noitea;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $noitea)
          echo "<td width='50' class='linhadestaque'>$noitea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;na;$noitea;$dia'>";
         else
          echo "<td width='50'>$noitea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;na;$noitea;$dia'>";
         $tot_i++;
        }
         
      if($noiteb == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='nb$i' value='$tot_i;$numseq;nb;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;nb;$noiteb;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $noiteb)
          echo "<td width='50' class='linhadestaque'>$noiteb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;nb;$noiteb;$dia'>";
         else
          echo "<td width='50'>$noiteb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;nb;$noiteb;$dia'>";
         $tot_i++;
        }
       ?>
                      
                    </tr>
                  </table></td>
                <td width='3%' class='linha'></td>
              </tr>
            </table></td>
        </tr>
      </table>
      
