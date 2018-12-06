<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\QhiboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'H&A Weekly QHI (RAC)';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  $(document).ready(function(){
        //alert('teste');
          var j = 0;
          var ly = [];
          var py = [];
          var rs = [];
          var mtable = $('#monthly-table');
            mtable.find('tbody tr').each(function(){
              if (j % 3 == 0){ ly = [];}
              if (j % 3 == 1){ py = [];}
              var lastyear = $(this).find('.ly').each(function(){
                ly.push($(this).text());
              });
              var presentyear = $(this).find('.py').each(function(){
                py.push($(this).text());
              });
              //alert(ly);
              var tam = ly.length;
              var linhaIMPR = $(this).find('.impr');
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
                      linhaIMPR[i].innerHTML = "<b>" + rslt.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downwhite.svg\" alt=\"Logo\" /> </b>";
                      linhaIMPR[i].bgColor = "green";
                      linhaIMPR[i].style = "color: white";
                    }else if (rslt >= -10){
                      linhaIMPR[i].innerHTML = "<b>" + rslt.toFixed(0)*(-1) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                      linhaIMPR[i].bgColor = "yellow";
                      linhaIMPR[i].style = "color: black";
                    }else if (rslt < -10){
                      linhaIMPR[i].innerHTML = "<b>" + rslt.toFixed(0)*(-1) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/upwhite.svg\" alt=\"Logo\" /> </b>";
                      linhaIMPR[i].bgColor = "red";
                      linhaIMPR[i].style = "color: white";
                    }else{
                      linhaIMPR[i].innerHTML = '';
                    }
                  }
              }
              j++;
            });
          var wtable = $('#weekly-table');
          var j = 0;
          var ptsv = [], pattv = [];
          wtable.find('tbody tr').each(function(){
            /* PARTE TEMPORÁRIA DO CÓDIGO
            SE A ORDEM FOR FFR-FCR-PRR-TLDR-IFRR ENTÃO É DESSE JEITO
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
                /*
                console.log("Vetor ly:");
                  for (var i = 0; i < ly.length; i++) {
                    console.log(ly[i]);
                  }
                  console.log("Fim do vetor");
                console.log("Vetor py:");
                  for (var i = 0; i < py.length; i++) {
                    console.log(py[i]);
                  }
                  console.log("Fim do vetor");
                  */
                while (i < td2.length){
                  //if (td2[i].className != '' && td2[i].className != 'patt' && td2[i].className != 'pts' && td2[i].className != 'prctg'){
                  if($.isNumeric(td2[i].innerHTML) && td2[i].className != 'patt' && td2[i].className != 'pts' && td2[i].className != 'prctg'){
                    if (ly[k].length > 0 && py[k].length > 0){ 
                      if (j < 6){var result = (ly[k]/py[k])*100;}
                      else{var result = (ly[k]/py[k])*1000000;}
                      console.log(result);
                      td2[i].innerHTML = result.toFixed(2);
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
                console.log("Entrou aqui");
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
                console.log(soma.toFixed(1));
                console.log("Linha: " +j);
                if (j % 3 == 0){
                  ap1 = soma.toFixed(1);
                }else if (j % 3 == 1){ 
                  ap2 = soma.toFixed(1);
                }else{
                  console.log("AP1: "+ap1);
                  console.log("AP2: "+ap2);
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
                  circle[i].innerHTML = "<img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/circlegreen.svg\" alt=\"Logo\" />";
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downblack.svg\" alt=\"Logo\"/> </b>"
                  impr[i].bgColor = "green";
                  impr[i].style = "color: black";
                }else if (result >= -10){
                  circle[i].innerHTML = "<img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/circlegreen.svg\" alt=\"Logo\" />";
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\"/> </b>"
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black";
                }else{
                  circle[i].innerHTML = "<img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/circlered.svg\" alt=\"Logo\" />";
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/upwhite.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "red";
                  impr[i].style = "color: white";
                }
              }
            }else{
              for (var i = lp.length - 1; i >= 0; i--) {
                if(result >= 10){
                  circle[i].innerHTML = "<img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/circlered.svg\" alt=\"Logo\" />";
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/downwhite.svg\" alt=\"Logo\" /> </b>"
                  impr[i].bgColor = "red";
                  impr[i].style = "color: white"; 
                }else if (result >= 0){
                  circle[i].innerHTML = "<img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/circlegreen.svg\" alt=\"Logo\" />";
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black";
                }else{
                  circle[i].innerHTML = "<img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/circlegreen.svg\" alt=\"Logo\" />";
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% <img width=\"20px\" src=\"http://localhost/QSmart/frontend/web/img/uparrow.svg\" alt=\"Logo\" /> </b>";
                  impr[i].bgColor = "green";
                  impr[i].style = "color: black";
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
                console.log("somapts "+somapts);
                console.log("somapatt "+somapatt);
              }
              console.log(somapts);
              console.log(somapatt);
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

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>
<br>
<div class="qhiboard-month">

    <div class="box box-danger">
        <div class="box-header with-border">
        <br>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

      <form method="get" action="http://localhost/QSmart/frontend/web/index.php?r=qhiboard%2Findex" "><button type="submit" style="width:400">Tabela Semanal</button></form>
      <form method="get" action="./monthly-table.php"><button type="submit" style="width:200">Tabela Mensal</button></form>
    <!-- TABELA SEMANAL -->
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
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Field Rate">FFR </td>
       <td>'17</td>
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
       <td>'18</td>
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
       <td>Improvement</td> <!-- ((17' - 18')/17')*100 -->
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
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Cost Rate">FCR </td>
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
       <td>Improvement</td> <!-- (1 - 18'/17')*100 -->
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
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Parts Return Rate">PRR </td>
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
          <td>Improvement</td> <!-- (1 - 18'/17')*100 -->
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
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate">TLDR </td>
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
          <td>Improvement</td> <!-- (1 - 18'/17')*100 -->
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
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Rework Rate">IFRR </td>
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
        <td>Improvement</td> <!-- (1 - 18'/17')*100 -->
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

  </div> 
</div>
