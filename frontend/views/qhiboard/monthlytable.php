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
       <td rowspan="6" style="text-align: center; vertical-align: middle">Market</td>
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Field Rate">FFR </td>
       <td>\'17</td>
       <td class="ly"><b>2.62</td> <!-- ly = last year-->
       <td class="ly"><b>2.31</td>
       <td class="ly"><b>2.18</td>
       <td class="ly"><b>2.29</td>
       <td class="ly"><b>2.48</td>
       <td class="ly"><b>2.42</td>
       <td class="ly"><b>2.23</td>
       <td class="ly"><b>2.12</td>
       <td class="ly"><b>2.07</td>
       <td class="ly"><b>1.97</td>
       <td class="ly"><b>1.80</td>
       <td class="ly"><b>1.72</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py"><b>1.67</td> <!-- py = present year-->
       <td class="py"><b>1.56</td>
       <td class="py"><b>1.50</td>
       <td class="py"><b>1.52</td>
       <td class="py"><b>1.48</td>
       <td class="py"><b>1.47</td>
       <td class="py"><b>1.48</td>
       <td class="py"><b>1.44</td>
       <td class="py"><b>1.44</td>
       <td class="py"><b>1.39</td>
       <td class="py"><b></td>
       <td class="py"><b></td>
      </tr>
      <tr style="text-align: center;">
       <td>Improvement</td> <!-- ((17\' - 18\')/17\')*100 -->
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
        
      </tr>
      <tr style="text-align: center;" >
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Cost Rate">FCR </td>
       <td>\'17</td>
       <td class="ly"><b>1.01</td>
       <td class="ly"><b>1.22</td>
       <td class="ly"><b>1.45</td>
       <td class="ly"><b>1.56</td>
       <td class="ly"><b>1.60</td>
       <td class="ly"><b>1.57</td>
       <td class="ly"><b>1.49</td>
       <td class="ly"><b>1.40</td>
       <td class="ly"><b>1.28</td>
       <td class="ly"><b>1.14</td>
       <td class="ly"><b>1.06</td>
       <td class="ly"><b>1.04</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py"><b>0.76</td>
       <td class="py"><b>0.87</td>
       <td class="py"><b>0.95</td>
       <td class="py"><b>1.21</td>
       <td class="py"><b>1.33</td>
       <td class="py"><b>1.24</td>
       <td class="py"><b>1.18</td>
       <td class="py"><b>1.13</td>
       <td class="py"><b>1.09</td>
       <td class="py"><b>1.05</td>
       <td class="py"><b></td>
       <td class="py"><b></td>
      </tr>
      <tr style="text-align: center;">
       <td>Improvement</td> <!-- (1 - 18\'/17\')*100 -->
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
      </tr>
      <tr style="text-align: center;">
       <td rowspan="9" style="text-align: center; vertical-align: middle">Production</td>
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Parts Retun Rate">PRR </td>
       <td>\'17</td>
       <td class="ly"><b>0</td>
       <td class="ly"><b>10</td>
       <td class="ly"><b>91</td>
       <td class="ly"><b>140</td>
       <td class="ly"><b>259</td>
       <td class="ly"><b>295</td>
       <td class="ly"><b>299</td>
       <td class="ly"><b>379</td>
       <td class="ly"><b>395</td>
       <td class="ly"><b>453</td>
       <td class="ly"><b>494</td>
       <td class="ly"><b>531</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py"><b>728</td>
       <td class="py"><b>712</td>
       <td class="py"><b>636</td>
       <td class="py"><b>579</td>
       <td class="py"><b>567</td>
       <td class="py"><b>564</td>
       <td class="py"><b>501</td>
       <td class="py"><b>486</td>
       <td class="py"><b>479</td>
       <td class="py"><b>482</td>
       <td class="py"><b></td>
       <td class="py"><b></td>
      </tr>
      <tr style="text-align: center;">
          <td>Improvement</td> <!-- (1 - 18\'/17\')*100 -->
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
       <td class="impr"></td>
      </tr>
      <tr style="text-align: center;">
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate">TLDR </td>
       <td>\'17</td>
       <td class="ly"><b>3648</td>
       <td class="ly"><b>3597</td>
       <td class="ly"><b>3322</td>
       <td class="ly"><b>140</td>
       <td class="ly"><b>259</td>
       <td class="ly"><b>295</td>
       <td class="ly"><b>299</td>
       <td class="ly"><b>379</td>
       <td class="ly"><b>395</td>
       <td class="ly"><b>453</td>
       <td class="ly"><b>494</td>
       <td class="ly"><b>531</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py"><b>2210</td>
       <td class="py"><b>2051</td>
       <td class="py"><b>2322</td>
       <td class="py"><b>2277</td>
       <td class="py"><b>567</td>
       <td class="py"><b>564</td>
       <td class="py"><b>501</td>
       <td class="py"><b>486</td>
       <td class="py"><b>479</td>
       <td class="py"><b>482</td>
       <td class="py"><b></td>
       <td class="py"><b></td>
      </tr>
      <tr style="text-align: center;">
          <td>Improvement</td> <!-- (1 - 18\'/17\')*100 -->
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
          <td class="impr"></td>
      </tr>
      <tr style="text-align: center;">
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Return Rate">IFRR </td>
       <td>\'17</td>
       <td class="ly"><b>0.56</td>
       <td class="ly"><b>0.0</td>
       <td class="ly"><b>0.31</td>
       <td class="ly"><b>0.24</td>
       <td class="ly"><b>2.87</td>
       <td class="ly"><b>0.34</td>
       <td class="ly"><b>2.72</td>
       <td class="ly"><b>0.22</td>
       <td class="ly"><b>0.14</td>
       <td class="ly"><b>0.85</td>
       <td class="ly"><b>0.00</td>
       <td class="ly"><b>0.22</td>
      </tr>
      <tr style="text-align: center;">
       <td>\'18</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>1.57</td>
       <td class="py"><b>0.80</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b>0.0</td>
       <td class="py"><b></td>
       <td class="py"><b></td>
      </tr>
      <tr style="text-align: center;">
        <td>Improvement</td> <!-- (1 - 18\'/17\')*100 -->
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
        <td class="impr"></td>
      </tr>
     </tbody>
    </table>';

    echo $html;

    ?>