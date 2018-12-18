<?php
$html = '
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script type = "text/javascript">
        $(document).ready(function(){
          //alert(\'teste\');
          var j = 0;
          var ly = [];
          var py = [];
          var rs = [];

          var wtable = $(\'#weekly-table\');
          var j = 0;
          var ptsv = [], pattv = [];
          wtable.find(\'tbody tr\').each(function(){
            /*
            ORDEM: FFR-FCR-PRR-TLDR-IFRR
            */
            if (j % 3 == 0){ ly = [];}
            if (j % 3 == 1){ py = [];}
            var td = $(this).find(\'td\').each(function(){
              if (j % 3 == 0){
              
                if (!isNaN($(this).text())){
                  ly.push($(this).text());
                }
              }
              if (j % 3 == 1){
                if (!isNaN($(this).text())){
                  py.push($(this).text());
                }
              }
            });
            var td2 = $(this).find(\'td\');
              if (j % 3 == 2){
                var i = 0, k = 0;
                while (i < td2.length){
                  var tembold = false;
                  if(td2[i].innerHTML.indexOf("<b>") != -1){
                    tembold = true;
                  }
                  if($.isNumeric(td2[i].innerText) && td2[i].className != \'patt\' && td2[i].className != \'pts\' && td2[i].className != \'prctg\'){
                    console.log("ly: " + ly[k]);
                    console.log("py: " + py[k]);
                    console.log("innertext: " + td2[i].innerText);
                    if (ly[k].length > 0 && py[k].length > 0){ 
                      if (j < 6){var result = (ly[k]/py[k])*100;}
                      else{var result = (ly[k]/py[k])*1000000;}
                      if (tembold){ td2[i].innerHTML = "<b>"+result.toFixed(2);}
                      else{ td2[i].innerHTML = result.toFixed(2);}
                      k++;
                    }
                  }
                  i++;
                }
              }
            
            var week = $(this).find(\'.week\');
            var ap = $(this).find(\'.ap\');
            var vetaps = [0, 0];
            for (var i = ap.length - 1; i >= 0; i--) {
              /*
              if (j % 3 != 2){
                vetaps[j % 3] = ap[i].innerHTML;
              }else{
                var result = (vetaps[0]/vetaps[1])*100;
                ap[i].innerHTML = "<b>" + result.toFixed(2);
              }
              */
              if (j < 3){
                for (var k = 0;k < week.length; k++) {
                  if (week[k].innerHTML != \'\'){
                    ap[i].innerHTML = "<b>" + week[k].innerHTML;
                  }
                }
              }else{
                var soma = 0;
                for (var k = week.length - 1; k >= 0;k--){
                  if (week[k].innerHTML != \'\'){
                    soma= soma + parseFloat(week[k].innerHTML);
                  }
                  
                }
                ap[i].innerHTML = "<b>" + soma.toFixed(1);
                if (j % 3 == 0){
                  ap1 = soma.toFixed(1);
                }else if (j % 3 == 1){ 
                  ap2 = soma.toFixed(1);
                }else{
                  if (j < 6){ ap[i].innerHTML = "<b>" + (ap1/ap2*100).toFixed(2);}
                  else{ ap[i].innerHTML = "<b>" + (ap1/ap2*1000000).toFixed(2);}
                }
              }
            }
            // Feitos os resultados, vamos pras setinhas
            var lp = $(this).find(\'.lp\');
            var ap = $(this).find(\'.ap\');
            var result = (lp.text()-ap.text())/lp.text()*100;
            if (lp.text() == 0){
              if (ap.text() == 0){
                result = 0;
              }else{
                result = -100;
              }
            }
            var impr = $(this).find(\'.impr\');
            if (j % 3 != 1){
              for (var i = lp.length - 1; i >= 0; i--) {
                if(result >= 0){
                  
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downblack.svg\" alt=\"Logo\"/> </b>"
                  impr[i].bgColor = "#32f032";
                  impr[i].style = "color: black";
                }else if (result >= -10){
                  
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\"/> </b>"
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black";
                }else{
                  
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/upwhite.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "#f00f0f";
                  impr[i].style = "color: white";
                }
              }
            }else{
              for (var i = lp.length - 1; i >= 0; i--) {
                if(result >= 10){
                  
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downwhite.svg\" alt=\"Logo\" /> </b>"
                  impr[i].bgColor = "#f00f0f";
                  impr[i].style = "color: white"; 
                }else if (result >= 0){
                  
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black";
                }else{
                  
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "#32f032";
                  impr[i].style = "color: black";
                }
              }
            }
            var pts = $(this).find(\'.pts\');
            var prctg = $(this).find(\'.prctg\');
            var patt = $(this).find(\'.patt\');
            var result2 = (pts.text()/patt.text())*100;
            if (!isNaN(result2)){
              prctg[0].innerHTML = result2 + "%";
            }
            if (j < 15){
              if (pts.length > 0){
                ptsv.push(pts.text());
                pattv.push(patt.text());
              }
            }else{
              var somapts = 0, somapatt = 0;
              for (var i = 0; i < ptsv.length;i++) {
                somapts = somapts + parseFloat(ptsv[i]);
                somapatt = somapatt + parseFloat(pattv[i]);
              }
              for (var i = pts.length - 1; i >= 0; i--) {
                pts[i].innerHTML = "<b>" + somapts;
                patt[i].innerHTML = "<b>" + somapatt;
              }
              var result2 = (somapts/somapatt)*100;
              if (!isNaN(result2)){
                for (var i = prctg.length - 1; i >= 0; i--) {
                  prctg[i].innerHTML = "<b>" + result2 + "%";
                }
              }
            }
            
            j++;
          });

        });
       
  
     </script>

     <table id="weekly-table" style="height: 400px"class="table table-striped table-bordered table-condensed table-hover">
     <thead>
      <tr style="text-align: center;">
       <th style="vertical-align: middle; text-align: center;" colspan="3" rowspan="2">KPI</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >DEC\'17 <br> Performance</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >DEC\'18 <br> Objective</th>
       <th style="vertical-align: middle; text-align: center;" colspan="7" >DEC\'18 Performance</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >Score</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >Accomplishment</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >Pattern (Padrão)</th>
      </tr>
      <tr style="text-align: center; vertical-align: middle;">
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W48</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W49</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W50</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W51</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W52</td>
       <td style="vertical-align: middle; text-align: center;"> <b>Accumulate </td>
       <td style="vertical-align: middle; text-align: center;"width="100px"> <b>Improvement rate</td> <!--  ((17\' - 18\')/17\')*100-->
      </tr>
     </thead>
     <tbody>
      <tr style="text-align: center;">
       <td rowspan="6" style="vertical-align: middle" bgcolor="#e0e0e0">Market</td>
       <td rowspan="3" style="vertical-align: middle" bgcolor="#e0e0e0" title="Failure Field Rate">FFR </td>
       <td>Acc. SVC</td>
       <td class="lp"><b>2727</td>
       <td class="ao"><b></td>
       <td class="week">2191 </td>
       <td class="week">2229 </td>
       <td class="week">2280 </td>
       <td class="week">2352 </td>
       <td class="week"></td>
       <td class="ap">0 </td>
       <td class="impr" style="color: green; vertical-align:middle">x% </td>
      </tr>
      <tr style="text-align: center;" class="FFR">
       <td>W. A. Sales</td>
       <td class="lp"><b>138474  </td>
       <td class="ao"><b></td>
       <td class="week">160874  </td>
       <td class="week">160888  </td>
       <td class="week">161305  </td>
       <td class="week">161409  </td>
       <td class="week"></td>
       <td class="ap">0</td>
       <td class="impr" style="vertical-align:center;"></td>
      </tr>
      <tr  bgColor="#e0e0e0" style="text-align: center;">
       <td bgColor="#e0e0e0">Percentage </td> <!-- ((up/down)*100) -->
       <td bgColor="#e0e0e0" class="lp"><b>1.97</td>
       <td bgColor="#e0e0e0" class="ao"><b>1.90</td>
       <td bgColor="#e0e0e0" class="week" >1.36</td>
       <td bgColor="#e0e0e0" class="week" >1.39</td>
       <td bgColor="#e0e0e0" class="week" >1.41</td>
       <td bgColor="#e0e0e0" class="week" >1.46</td>
       <td bgColor="#e0e0e0" class="week" ></td>
       <td bgColor="#e0e0e0" class="ap">0</td>
       <td bgColor="#e0e0e0" class="impr" style="color: green; vertical-align:middle"> x%  </td>
       <td bgColor="#e0e0e0" class="pts" >35 </td>
       <td bgColor="#e0e0e0" class="prctg">0% </td>
       <td bgColor="#e0e0e0" class="patt">35</td>
      </tr>
      <tr style="text-align: center;">
       <td rowspan="3" style="vertical-align: middle"title="Failure Cost Rate" bgcolor="#e0e0e0">FCR </td>
       <td>Failure cost</td>
       <td class="lp"><b>63.5</td>
       <td class="ao"><b>60.4</td>
       <td class="week">13.0</td>
       <td class="week">14.6</td>
       <td class="week">14.0</td>
       <td class="week">10.3</td>
       <td class="week"></td>
       <td class="ap">51.9</td>
       <td class="impr" style="color: green; vertical-align:middle"> x%  </td>
      </tr>
      <tr style="text-align: center;">
       <td>Sales</td>
       <td class="lp"><b>14528.7</td>
       <td class="ao"><b>13802.3</td>
       <td class="week">235.2</td><!-- 235.2 -->
       <td class="week">1437.0</td><!--    1437.0  -->
       <td class="week">408.0</td><!-- 408.0-->
       <td class="week">900.1</td><!-- 900.1-->
       <td class="week"></td>
       <td class="ap">2980.3</td>
       <td class="impr" style="color: red; vertical-align:middle"> 298%  </td>
      </tr>
      <tr bgcolor="#e0e0e0" style="text-align: center;">
       <td >Percentage </td> <!-- ((up/down)*100) -->
       <td class="lp"><b>0.44</td>
       <td class="ao"><b>0.44</td>
       <td class="week">5.53</td>
       <td class="week">1.02</td>
       <td class="week">3.43</td>
       <td class="week">1.14</td>
       <td class="week"></td>
       <td class="ap">1.74</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
       <td class="pts" ">4 </td>
       <td class="prctg">0% </td>
       <td class="patt">20</td>
      </tr>
      <tr style="text-align: center;">
       <td rowspan="9" style="vertical-align: middle" bgColor="#e0e0e0">Production</td>
       <td rowspan="3" style="vertical-align: middle" bgColor="#e0e0e0" title="Parts Return Rate">PRR</td>
       <td>Poor parts quantity</td>
       <td class="lp"><b>54</td>
       <td class="ao"><b></td>
       <td class="week">24</td>
       <td class="week">12</td>
       <td class="week">1</td>
       <td class="week"></td>
       <td class="week"></td>
       <td class="ap">31</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;">
       <td>Production quantity</td>
       <td class="lp"><b>70511</td>
       <td class="ao"><b></td>
       <td class="week">23164</td>
       <td class="week">14606</td>
       <td class="week">2688</td>
       <td class="week"></td>
       <td class="week"></td>
       <td class="ap">40174</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0">
       <td bgColor="#e0e0e0" >Parts per million </td>
       <td bgColor="#e0e0e0" class="lp"><b>766</td>
       <td bgColor="#e0e0e0" class="ao"><b>454</td>
       <td bgColor="#e0e0e0" class="week">1036</td>
       <td bgColor="#e0e0e0" class="week">821</td>
       <td bgColor="#e0e0e0" class="week">372</td>
       <td bgColor="#e0e0e0" class="week"></td>
       <td bgColor="#e0e0e0" class="week"></td>
       <td bgColor="#e0e0e0" class="ap">772</td>
       <td bgColor="#e0e0e0" class="impr" style="color: red; vertical-align:middle"> x%  </td>
       <td bgColor="#e0e0e0" class="pts">3</td>
       <td bgColor="#e0e0e0" class="prctg">0%</td>
       <td bgColor="#e0e0e0" class="patt">15</td>
      </tr>
      <tr style="text-align: center;">
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate"bgColor="#e0e0e0">TLDR</td>
       <td>Defect quantity</td>
       <td class="lp"><b>131</td>
       <td class="ao"><b></td>
       <td class="week">11</td>
       <td class="week">7</td>
       <td class="week">25</td>
       <td class="week">19</td>
       <td class="week"></td>
       <td class="ap">62</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;">
       <td>Total production quantity</td>
       <td class="lp"><b>35034</td>
       <td class="ao"><b></td>
       <td class="week">2115</td>
       <td class="week">4738</td>
       <td class="week">9854</td>
       <td class="week">7922</td>
       <td class="week"></td>
       <td class="ap">24629</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0">
        <td>Parts per million</td> <!-- (1 - 18\'17\')*100 -->
       <td class="lp"><b>3729</td>
       <td class="ao"><b>4200</td>
       <td class="week">5201</td>
       <td class="week">1477</td>
       <td class="week">2537</td>
       <td class="week">2398</td>
       <td class="week"></td>
       <td class="ap">24629</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
       <td class="pts">12</td>
       <td class="prctg">0%</td>
       <td class="patt">15</td>
      </tr>
      <tr style="text-align: center">
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Rework Rate" bgColor="#e0e0e0">IFRR </td>
      <td>Rework quantity</td>
       <td class="lp"><b>35054</td>
       <td class="ao"><b></td>
       <td class="week">0</td>
       <td class="week">0</td>
       <td class="week">0</td>
       <td class="week"></td>
       <td class="week"></td>
       <td class="ap">31</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;">
        <td>Total production quantity</td>
       <td class="lp"><b>5000000</td>
       <td class="ao"><b></td>
       <td class="week">1000452</td>
       <td class="week">2621485</td>
       <td class="week">1717852</td>
       <td class="week">1155000</td>
       <td class="week"></td>
       <td class="ap">31</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr bgColor="#e0e0e0" style="text-align: center;">
        <td bgColor="#e0e0e0">Parts per million</td>
        <td bgColor="#e0e0e0"class="lp"><b>0</td>
        <td bgColor="#e0e0e0" class="ao"><b></td>
        <td bgColor="#e0e0e0"class="week">0</td>
        <td bgColor="#e0e0e0"class="week">0</td>
        <td bgColor="#e0e0e0"class="week">0</td>
        <td bgColor="#e0e0e0"class="week"></td>
        <td bgColor="#e0e0e0"class="week"></td>
        <td bgColor="#e0e0e0"class="ap">31</td>
        <td bgColor="#e0e0e0"class="impr" style="color: green; vertical-align:middle"> x% </td>
        <td bgColor="#e0e0e0"class="pts">15</td>
        <td bgColor="#e0e0e0"class="prctg">100%</td>
        <td bgColor="#e0e0e0"class="patt">15</td>
      </tr>
      
     </tbody>
    </table>';

    echo $html;

    ?>