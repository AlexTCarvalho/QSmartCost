<?php
$html = '

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script type = "text/javascript">
        var j = 0;
          var ly = [];
          var py = [];
          var rs = [];
          var mtable = $(\'#monthly-table\');
            mtable.find(\'tbody tr\').each(function(){
              if (j % 3 == 0){ ly = [];}
              if (j % 3 == 1){ py = [];}
              var lastyear = $(this).find(\'.ly\').each(function(){
                ly.push($(this).text());
              });
              var presentyear = $(this).find(\'.py\').each(function(){
                py.push($(this).text());
              });
              //alert(ly);
              var tam = ly.length;
              var linhaIMPR = $(this).find(\'.impr\');
              if( linhaIMPR.length != 0){
                  for (var i=0;i<linhaIMPR.length;i++){
                    var rslt = ((ly[i]-py[i])/ly[i])*100;
                    if (py[i].length > 0){
                      if (ly[i] == 0){
                        if (py[i] == 0){
                          rslt = 0;
                        }else{
                          rslt = -100;
                        }
                      }  
                    }else{
                      rslt = NaN;
                    }
                    
                    if (rslt >= 0){
                      linhaIMPR[i].innerHTML = "<b>" + rslt.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downblack.svg\" alt=\"Logo\" /> </b>";
                      linhaIMPR[i].bgColor = "#32f032";
                      linhaIMPR[i].style = "color: black";
                    }else if (rslt >= -10){
                      linhaIMPR[i].innerHTML = "<b>" + rslt.toFixed(0)*(-1) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                      linhaIMPR[i].bgColor = "yellow";
                      linhaIMPR[i].style = "color: black";
                    }else if (rslt < -10){
                      linhaIMPR[i].innerHTML = "<b>" + rslt.toFixed(0)*(-1) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/upwhite.svg\" alt=\"Logo\" /> </b>";
                      linhaIMPR[i].bgColor = "#f00f0f";
                      linhaIMPR[i].style = "color: white";
                    }else{
                      linhaIMPR[i].innerHTML = \'\';
                    }
                  }
              }
              j++;
            });
     </script>
    <table id = "monthly-table" class="table table-striped table-bordered table-condensed table-hover">
     <thead>
      <tr style="text-align: center;">
       <th colspan="3" style="text-align: center; vertical-align: middle;">KPI</th>
       <th width="80px" style="text-align: center;">Jan</th>
       <th width="80px" style="text-align: center;">Feb</th>
       <th width="80px" style="text-align: center;">Mar</th>
       <th width="80px" style="text-align: center;">Apr</th>
       <th width="80px" style="text-align: center;">May</th>
       <th width="80px" style="text-align: center;">Jun</th>
       <th width="80px" style="text-align: center;">Jul</th>
       <th width="80px" style="text-align: center;">Aug</th>
       <th width="80px" style="text-align: center;">Sep</th>
       <th width="80px" style="text-align: center;">Oct</th>
       <th width="80px" style="text-align: center;">Nov</th>
       <th width="80px" style="text-align: center;">Dec</th>
      </tr>
     </thead>
     <tbody>
      <tr style="text-align: center;">
       <td rowspan="6" style="text-align: center; vertical-align: middle" bgColor="#e0e0e0" >Market</td>
       <td rowspan="3" style="text-align: center; vertical-align: middle" bgColor="#e0e0e0" title="Failure Field Rate">FFR </td>
       <td>\'17</td>
       <td class="ly">2.62</td> <!-- ly = last year-->
       <td class="ly">2.31</td>
       <td class="ly">2.18</td>
       <td class="ly">2.29</td>
       <td class="ly">2.48</td>
       <td class="ly">2.42</td>
       <td class="ly">2.23</td>
       <td class="ly">2.12</td>
       <td class="ly">2.07</td>
       <td class="ly">1.97</td>
       <td class="ly">1.80</td>
       <td class="ly">1.72</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py">1.67</td> <!-- py = present year-->
       <td class="py">1.56</td>
       <td class="py">1.50</td>
       <td class="py">1.52</td>
       <td class="py">1.48</td>
       <td class="py">1.47</td>
       <td class="py">1.48</td>
       <td class="py">1.44</td>
       <td class="py">1.44</td>
       <td class="py">1.39</td>
       <td class="py"></td>
       <td class="py"></td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0" >
       <td bgColor="#e0e0e0" >YOY</td> <!-- ((17\' - 18\')/17\')*100 -->
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
        
      </tr>
      <tr style="text-align: center;" >
       <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Cost Rate">FCR </td>
       <td>\'17</td>
       <td class="ly">1.01</td>
       <td class="ly">1.22</td>
       <td class="ly">1.45</td>
       <td class="ly">1.56</td>
       <td class="ly">1.60</td>
       <td class="ly">1.57</td>
       <td class="ly">1.49</td>
       <td class="ly">1.40</td>
       <td class="ly">1.28</td>
       <td class="ly">1.14</td>
       <td class="ly">1.06</td>
       <td class="ly">1.04</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py">0.76</td>
       <td class="py">0.87</td>
       <td class="py">0.95</td>
       <td class="py">1.21</td>
       <td class="py">1.33</td>
       <td class="py">1.24</td>
       <td class="py">1.18</td>
       <td class="py">1.13</td>
       <td class="py">1.09</td>
       <td class="py">1.05</td>
       <td class="py"></td>
       <td class="py"></td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0" >
       <td bgColor="#e0e0e0" >YOY</td> <!-- ((17\' - 18\')/17\')*100 -->
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
      </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0" rowspan="9" style="text-align: center; vertical-align: middle">Production</td>
       <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Parts Retun Rate">PRR </td>
       <td>\'17</td>
       <td class="ly">0</td>
       <td class="ly">23</td>
       <td class="ly">333</td>
       <td class="ly">401</td>
       <td class="ly">773</td>
       <td class="ly">544</td>
       <td class="ly">324</td>
       <td class="ly">755</td>
       <td class="ly">465</td>
       <td class="ly">766</td>
       <td class="ly">769</td>
       <td class="ly">830</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py">728</td>
       <td class="py">679</td>
       <td class="py">473</td>
       <td class="py">312</td>
       <td class="py">500</td>
       <td class="py">0</td>
       <td class="py">29</td>
       <td class="py">420</td>
       <td class="py">429</td>
       <td class="py">486</td>
       <td class="py">289</td>
       <td class="py"></td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0" >
       <td bgColor="#e0e0e0" >YOY</td> <!-- ((17\' - 18\')/17\')*100 -->
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
      </tr>
      <tr style="text-align: center;">
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate">TLDR </td>
       <td>\'17</td>
       <td class="ly">3648</td>
       <td class="ly">3523</td>
       <td class="ly">2825</td>
       <td class="ly">3044</td>
       <td class="ly">5746</td>
       <td class="ly">6977</td>
       <td class="ly">5292</td>
       <td class="ly">3891</td>
       <td class="ly">5420</td>
       <td class="ly">3825</td>
       <td class="ly">4688</td>
       <td class="ly">2840</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py">2210</td>
       <td class="py">1867</td>
       <td class="py">2978</td>
       <td class="py">1919</td>
       <td class="py">3487</td>
       <td class="py">0</td>
       <td class="py">1054</td>
       <td class="py">3695</td>
       <td class="py">4771</td>
       <td class="py">2290</td>
       <td class="py">2728</td>
       <td class="py"></td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0" >
       <td bgColor="#e0e0e0" >YOY</td> <!-- ((17\' - 18\')/17\')*100 -->
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
      </tr>
      <tr style="text-align: center;">
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Return Rate">IFRR </td>
       <td>\'17</td>
       <td class="ly">5627</td>
       <td class="ly">0</td>
       <td class="ly">3121</td>
       <td class="ly">2470</td>
       <td class="ly">31758</td>
       <td class="ly">493</td>
       <td class="ly">27955</td>
       <td class="ly">2162</td>
       <td class="ly">1449</td>
       <td class="ly">8563</td>
       <td class="ly">0</td>
       <td class="ly">2209</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py">0</td>
       <td class="py">0</td>
       <td class="py">6603</td>
       <td class="py">0</td>
       <td class="py">8112</td>
       <td class="py">0</td>
       <td class="py">0</td>
       <td class="py">0</td>
       <td class="py">4649</td>
       <td class="py">0</td>
       <td class="py">0</td>
       <td class="py"></td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0" >
       <td bgColor="#e0e0e0" >YOY</td> <!-- ((17\' - 18\')/17\')*100 -->
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
       <td class="impr" bgColor="#e0e0e0" ></td>
      </tr>
     </tbody>
    </table>';

    echo $html;

    ?>