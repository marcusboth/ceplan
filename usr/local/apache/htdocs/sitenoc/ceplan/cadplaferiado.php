<table width='100%' border='0' class='centraliza'>
        <tr> 

         <td> <table width='100%' border='0' bgcolor='#00FFCC' class='linha'>
              <tr> 
                <td width='6%' class='linha'><? echo "$diax"; ?></td>
                <td width='6%' class='linha'><? echo "$dia_s"; ?></td>
                <td width='21%'> 
                <table width='100%' border='0' class='centraliza'>
                    <tr class='linha'> 

      <?                    
      if($madrugaa == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='maferiado$i' value='$tot_i;$numseq;maferiado;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;maferiado;$madrugaa;$dia'>";
         $faltapreencher++; $tot_i++;
        }
      else
        {
         if($destaque == $madrugaa)
          echo "<td width='50' class='linhadestaque'>$madrugaa</td><input type='hidden' name='marcado$tot_i' value='$tot_i;maferiado;$madrugaa;$dia'>";
        else
          echo "<td width='50'>$madrugaa</td><input type='hidden' name='marcado$tot_i' value='$tot_i;maferiado;$madrugaa;$dia'>";
        $tot_i++;
        }
         
       //ainda nao existe duplo durante a madrugdada, deixar isto abaixo
         echo "<td>&nbsp;</td>";
       ?>                      
                      
                    </tr>
                  </table></td>
                <td width='21%' class='linha'> <table width='100%' border='0' class='centraliza'>
                    <tr class='linha'> 

      <?
      if($manhaa == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='mhferiado$i' value='$tot_i;$numseq;mhferiado;$dia'></td>
                <input type='hidden' name='marcado$tot_i' value='$tot_i;mhferiado;$manhaa;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $manhaa)
          echo "<td width='50' class='linhadestaque'><b>$manhaa</b></td><input type='hidden' name='marcado$tot_i' value='$tot_i;mhferiado;$manhaa;$dia'>";
         else
          echo "<td width='50'>$manhaa</td><input type='hidden' name='marcado$tot_i' value='$tot_i;mhferiado;$manhaa;$dia'>";
         $tot_i++;
        }

      if($manhab == "preencher")
        {
         echo "<td width='50'><input type='checkbox' name='miferiado$i' value='$tot_i;$numseq;miferiado;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;miferiado;$manhab;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $manhab)
          echo "<td width='50' class='linhadestaque'>$manhab</font></td><input type='hidden' name='marcado$tot_i' value='$tot_i;miferiado;$manhab;$dia'>";
         else
          echo "<td width='50'>$manhab</td><input type='hidden' name='marcado$tot_i' value='$tot_i;miferiado;$manhab;$dia'>";
         $tot_i++;
        }
       ?>                      
                      
                    </tr>
                  </table></td>
                <td width='21%' class='linha'><table width='100%' border='0' class='centraliza'>
                    <tr class='linha'> 
                    
      <?
      if($tardea == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='taferiado$i' value='$tot_i;$numseq;taferiado;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;taferiado;$tardea;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $tardea)
          echo "<td width='50' class='linhadestaque'>$tardea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;taferiado;$tardea;$dia'>";
         else
          echo "<td width='50'>$tardea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;taferiado;$tardea;$dia'>";
         $tot_i++;
        }

      if($tardeb == "preencher")
        {
         echo "<td width='50'><input type='checkbox' name='tbferiado$i' value='$tot_i;$numseq;tbferiado;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;tbferiado;$tardeb;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $tardeb)
          echo "<td width='50' class='linhadestaque'>$tardeb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;tbferiado;$tardeb;$dia'>";
         else
          echo "<td width='50'>$tardeb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;tbferiado;$tardeb;$dia'>";
         $tot_i++;
        }
       ?>
         
                    </tr>  
                  </table></td>
                <td width='21%' class='linha'><table width='100%' border='0' class='centraliza'>
                    <tr class='linha'> 

      <?                    
      if($noitea == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='naferiado$i' value='$tot_i;$numseq;naferiado;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;naferiado;$noitea;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $noitea)
          echo "<td width='50' class='linhadestaque'>$noitea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;naferiado;$noitea;$dia'>";
         else
          echo "<td width='50'>$noitea</td><input type='hidden' name='marcado$tot_i' value='$tot_i;naferiado;$noitea;$dia'>";
         $tot_i++;
        }
         
      if($noiteb == "preencher")  
        {
         echo "<td width='50'><input type='checkbox' name='nbferiado$i' value='$tot_i;$numseq;nbferiado;$dia'></td>
               <input type='hidden' name='marcado$tot_i' value='$tot_i;nbferiado;$noiteb;$dia'>";
         $faltapreencher++;  $tot_i++;
        }
      else
        {
         if($destaque == $noiteb)
          echo "<td width='50' class='linhadestaque'>$noiteb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;nbferiado;$noiteb;$dia'>";
         else
          echo "<td width='50'>$noiteb</td><input type='hidden' name='marcado$tot_i' value='$tot_i;nbferiado;$noiteb;$dia'>";
         $tot_i++;
        }
       ?>
                      
                    </tr>
                  </table></td>
                <td width='3%' class='linha'>&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>

