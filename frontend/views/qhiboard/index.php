<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\QhiboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QHI Board';
//$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  $(document).ready(function(){
    window.location.href='#weekly-table';
        var j = 0;
        var ly = [];
        var py = [];
        var rs = [];
        
        var wtable = $('#weekly-table');
        var j = 0;
        var ptsv = [], pattv = [];
        wtable.find('tbody tr').each(function(){
            /* 
            ORDEM: FFR-FCR-PRR-TLDR-IFRR
            */
            if (j % 3 == 0){ ly = [];}
            if (j % 3 == 1){ py = [];}
            var td = $(this).find('td').each(function(){
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
            var td2 = $(this).find('td');
              if (j % 3 == 2){
                var i = 0, k = 0;
                
                while (i < td2.length){
                  var tembold = false;
                  if(td2[i].innerHTML.indexOf("<b>") != -1){
                    tembold = true;
                  }
                  if($.isNumeric(td2[i].innerText) && td2[i].className != 'patt' && td2[i].className != 'pts' && td2[i].className != 'prctg'){
                    if (ly[k].length > 0 && py[k].length > 0){ 
                      if (j < 6){var result = (ly[k]/py[k])*100;}
                      else{var result = (ly[k]/py[k])*1000000;}
                      if(tembold){td2[i].innerHTML = "<b>" + result.toFixed(2);}
                      else{td2[i].innerHTML = result.toFixed(2);}
                      k++;
                    }
                  }
                  i++;
                }
              }
            
            // COLUNA DOS FFR-FCR...
            // COLUNA DOS RESULTADOS
            var week = $(this).find('.week');
            var ap = $(this).find('.ap');
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
                  if (week[k].innerHTML != ''){
                    ap[i].innerHTML = "<b>" + week[k].innerHTML;
                  }
                }
              }else{
                var soma = 0;
                for (var k = week.length - 1; k >= 0;k--){
                  if (week[k].innerHTML != ''){
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
            var lp = $(this).find('.lp');
            var ap = $(this).find('.ap');
            var result = (lp.text()-ap.text())/lp.text()*100;
            if (lp.text() == 0){
              if (ap.text() == 0){
                result = 0;
              }else{
                result = -100;
              }
            }
            var circle = $(this).find('.circle');
            var impr = $(this).find('.impr');
            if (j % 3 != 1){
              for (var i = lp.length - 1; i >= 0; i--) {
                if(result >= 0){
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downblack.svg\" alt=\"Logo\"/> </b>"
                  impr[i].bgColor = "#32f032";
                  impr[i].style = "color: black; vertical-align:middle";
                }else if (result >= -10){
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\"/> </b>"
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black; vertical-align:middle";
                }else{
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/upwhite.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "#f00f0f";
                  impr[i].style = "color: white; vertical-align:middle";
                }
              }
            }else{
              for (var i = lp.length - 1; i >= 0; i--) {
                if(result >= 10){
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downwhite.svg\" alt=\"Logo\" /> </b>"
                  impr[i].bgColor = "#f00f0f";
                  impr[i].style = "color: white; vertical-align:middle"; 
                }else if (result >= 0){
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black; vertical-align:middle";
                }else{
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "#32f032";
                  impr[i].style = "color: black; vertical-align:middle";
                }
              }
            }
            var pts = $(this).find('.pts');
            var prctg = $(this).find('.prctg');
            var patt = $(this).find('.patt');
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

          $('#showmonth').click(function(){
            $.ajax({
                url:'http://localhost/monthlytable.php',
                type:'get',
                success:function(data){
                  $('#table').html(data);
                },
                error:function(xhr,ajaxOptions,throwError){
                    alert(throwError);
                }
            });
          });

          $('#showweek').click(function(){
            $.ajax({
                url:'http://localhost/weeklytable.php',
                type:'get',
                success:function(data){
                  $('#table').html(data);
                },
                error:function(xhr,ajaxOptions,throwError){
                    alert(throwError);
                }
            });
          });
    });

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>
<div class="qhiboard-index">

    <div class="box box-danger">
        <div class="box-header with-border">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        
      <button id = "showweek"  style="width:400">Tabela Semanal</button>
      <button id = "showmonth" style="width:200">Tabela Mensal</button>
    <!-- TABELA SEMANAL -->
     <div id = "table">
     <table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-bordered table-condensed table-hover">
     <thead>
      <tr style="text-align: center;">
       <th style="vertical-align: middle; text-align: center;" colspan="3" rowspan="2">KPI</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >DEC'17 <br> Result</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >DEC'18 <br> Target</th>
       <th style="vertical-align: middle; text-align: center;" colspan="7" >DEC'18 Result</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >Score</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >Accomplishment</th>
       <th style="vertical-align: middle; text-align: center;" rowspan="2" >Pattern (Padrão)</th>
      </tr>
      <tr style="text-align: center; vertical-align: middle;">
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W48</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W49</td>
       <td style="vertical-align: middle; text-align: centerlt;"width="70px"> <b>W50</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W51</td>
       <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W52</td>
       <td style="vertical-align: middle; text-align: center;"> <b>Accumulate </td>
       <td style="vertical-align: middle; text-align: center;"width="100px"> <b>Improvement rate</td> <!--  ((17' - 18')/17')*100-->
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
       <td bgColor="#e0e0e0">Rate </td> <!-- ((up/down)*100) -->
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
       <td >Rate </td> <!-- ((up/down)*100) -->
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
       <td bgColor="#e0e0e0" >PPM </td>
       <td bgColor="#e0e0e0" class="lp"><b>766</td>
       <td bgColor="#e0e0e0" class="ao"><b>454</td>
       <td bgColor="#e0e0e0" class="week">1036</td>
       <td bgColor="#e0e0e0" class="week">821</td>
       <td bgColor="#e0e0e0" class="week">372</td>
       <td bgColor="#e0e0e0" class="week"></td>
       <td bgColor="#e0e0e0" class="week"></td>
       <td bgColor="#e0e0e0" class="ap">772</td>
       <td bgColor="#e0e0e0" class="impr" style="color: red; vertical-align:middle"> x%  </td>
       <td bgColor="#e0e0e0" class="pts">15</td>
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
       <td class="week">10</td>
       <td class="week"></td>
       <td class="week"></td>
       <td class="ap">62</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;">
       <td>Total production quantity</td>
       <td class="lp"><b>35034</td>
       <td class="ao"><b></td>
       <td class="week">10005</td>
       <td class="week">7456</td>
       <td class="week">1862</td>
       <td class="week"></td>
       <td class="week"></td>
       <td class="ap">24629</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr style="text-align: center;" bgColor="#e0e0e0">
        <td>PPM</td> <!-- (1 - 18'/17')*100 -->
       <td class="lp"><b>3729</td>
       <td class="ao"><b>4200</td>
       <td class="week">5201</td>
       <td class="week">1477</td>
       <td class="week">2537</td>
       <td class="week"></td>
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
       <td class="lp"><b>0</td>
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
        <td>Total production quantityyyyyyyyyyy</td>
       <td class="lp"><b>35034</td>
       <td class="ao"><b></td>
       <td class="week">10005</td>
       <td class="week">7456</td>
       <td class="week">1862</td>
       <td class="week"></td>
       <td class="week"></td>
       <td class="ap">31</td>
       <td class="impr" style="color: green; vertical-align:middle"> x% </td>
      </tr>
      <tr bgColor="#e0e0e0" style="text-align: center;">
        <td bgColor="#e0e0e0">PPM</td>
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
    </table>
<!--
    <h1>H&A Weekly QHI Tabela Mensal</h1>
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
       <td rowspan="3" style="text-align: center; vertical-align: middle">FFR </td>
       <td>'17</td>
       <td class="ly"><b>2.62</td> <!-- ly = last year--
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
       <td>'18</td>
       <td class="py"><b>1.67</td> <!-- py = present year--
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
       <td>Improvement</td> <!-- ((17' - 18')/17')*100 --
       <td class="impr">Taxa </td>
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
       <td rowspan="3" style="text-align: center; vertical-align: middle">FCR </td>
       <td>'17</td>
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
       <td>'18</td>
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
       <td>Improvement</td> <!-- (1 - 18'/17')*100 --
       <td class="impr">Taxa </td>
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
       <td rowspan="3" style="text-align: center; vertical-align: middle">PRR </td>
       <td>'17</td>
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
       <td>'18</td>
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
          <td>Improvement</td> <!-- (1 - 18'/17')*100 --
       <td class="impr">Taxa </td>
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
      <td rowspan="3" style="text-align: center; vertical-align: middle">TLDR </td>
       <td>'17</td>
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
       <td>'18</td>
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
          <td>Improvement</td> <!-- (1 - 18'/17')*100 --
          <td class="impr">Taxa </td>
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
      <td rowspan="3" style="text-align: center; vertical-align: middle">IFRR </td>
       <td>'17</td>
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
       <td>'18</td>
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
        <td>Improvement</td> <!-- (1 - 18'/17')*100 --
        <td class="impr">Taxa </td>
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
          <td rowspan="3" style="text-align: center; vertical-align: middle">Issue</td>
          <td colspan="2" style="text-align: center";>Outside clinic (???)</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td></td>
          <td></td>
      </tr>
      <tr style="text-align: center;">
          <td colspan="2" style="text-align: center";>CEO Information Reporting </td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td></td>
          <td></td>
      </tr>
      <tr style="text-align: center;">
          <td colspan="2" style="text-align: center";>Sales corporation receipt inspection (???)</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td class="number">0</td>
          <td></td>
          <td></td>
      </tr>
     </tbody>
    </table>
-->
    </div>
  </div> 
</div>
