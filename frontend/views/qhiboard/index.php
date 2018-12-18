<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\QhiboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QHI Board';
//$this->params['breadcrumbs'][] = $this->title;

function semana_do_ano($dia,$mes,$ano){

$var=intval( date('z', mktime(0,0,0,$mes,$dia,$ano) ) / 7 ) + 1;

return $var;
}

$week = semana_do_ano(date('d'),date('m'),date('Y'));
$month = date('m');
$M = strtoupper(date('M'));
$year = date('Y');
$Y = date('y');
$LY = $Y-1;

$connection = Yii::$app->getDb();

      


            $start_date = "01-".$month."-".$year;
            $start_time = strtotime($start_date);

            $end_time = strtotime("+1 month", $start_time);

            for($i=$start_time; $i<$end_time; $i+=86400)
            {
               $list[] = date('Y-m-d-D', $i);
            }

            $week_total = array();
            foreach ($list as $data) {
                //print_r(substr($data,-3));
              //echo $data; // 2018-12-01-Sat
                if(!(substr($data,-3) == 'Sun' || substr($data,-3) == 'Sat')){
                    //$htm = $htm . '<th>'. substr($data, -6,-4) .'</th>';
                    $n = semana_do_ano(substr($data, -6,-4),substr($data, -9, -7),substr($data, 0, 4));
                    $lastday = substr($data,-6,-4);
                    array_push($week_total,$n);
                }
                
            }
            $key = array_search(53, $week_total);
              if($key!==false){
                  unset($week_total[$key]);
              }
              
              $week_total = array_unique($week_total);
              $htm = '<table href="#" id="week-table" style="height: 400px"class="table table-striped table-bordered table-condensed table-hover">
              <thead>
        <tr style="text-align: center;">
         <th style="vertical-align: middle; text-align: center;" colspan="3" rowspan="2">KPI</th>

         ';
              $htm = $htm.'<th style="vertical-align: middle; text-align: center;" rowspan="2" >' . $M .'';

              $htm = $htm.'\''. $LY .' <br> Result</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >'.$M.'\''.$Y.' <br> Target</th>
         <th style="vertical-align: middle; text-align: center;" colspan="7" >'.$M.'\''.$Y.'\' Result</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >Target</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >Result</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >Achievement</th>
        </tr>
        ';

        foreach ($week_total as $key) {
          $htm = $htm.'<td style="vertical-align: middle; text-align: center;"width="70px"> <b>W'.$key.'</td>';
        }

        $htm = $htm.'

         <td style="vertical-align: middle; text-align: center;"> <b>Acc. </td>
         <td style="vertical-align: middle; text-align: center;"> <b>YOY</td> <!--  ((17\' - 18\')/17\')*100-->
        </tr>
        </thead>
        <tbody>
        <tr style="text-align: center;">
         <td rowspan="6" style="vertical-align: middle" bgcolor="#e0e0e0">Market</td>
         <td rowspan="3" style="vertical-align: middle" bgcolor="#e0e0e0" title="Failure Field Rate">FFR </td>
         <td>Acc. SVC</td>
         <td class="lp"><b>
';

$FFR1 = array();
$FFR2 = array();
$FFR3 = array();
$FCR1 = array();
$FCR2 = array();
$FCR3 = array();
$PRR1 = array();
$PRR2 = array();
$PRR3 = array();
$TLDR1 = array();
$TLDR2 = array();
$TLDR3 = array();
$IFRR1 = array();
$IFRR2 = array();
$IFRR3 = array();

foreach ($week_total as $key) {


  $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM ffr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $accsvc = $perk['accsvc'];
        $waccs = $perk['waccs'];
        $rate = $perk['rate'];
        array_push($FFR1,$accsvc);
        array_push($FFR2,$waccs);
        array_push($FFR3,$rate);
        break;
      }

  $command = $connection->createCommand("SELECT ppq, prodquant, ppm FROM prr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $ppq = $perk['ppq'];
        $tpq = $perk['prodquant'];
        $ppm = $perk['ppm'];
        array_push($PRR1,$ppq);
        array_push($PRR2,$tpq);
        array_push($PRR3,$ppm);
        break;
      }

      $command = $connection->createCommand("SELECT defect, tpq, ppm FROM tldr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $def = $perk['defect'];
        $tpq = $perk['tpq'];
        $ppm = $perk['ppm'];
        array_push($TLDR1,$def);
        array_push($TLDR2,$tpq);
        array_push($TLDR3,$ppm);
        break;
      }

      $command = $connection->createCommand("SELECT rework, tpq, ppm FROM ifrr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $rew = $perk['rework'];
        $tpq = $perk['tpq'];
        $ppm = $perk['ppm'];
        array_push($IFRR1,$rew);
        array_push($IFRR2,$tpq);
        array_push($IFRR3,$ppm);
        break;
      }
}



  $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM ffr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $accsvc = $perk['accsvc'];
        $waccsFFR = $perk['waccs'];
        $rateFFR = $perk['rate'];
        break;
      }

  $command = $connection->createCommand("SELECT failcost, sales, rate FROM fcr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $fc = $perk['accsvc'];
        $waccsFCR = $perk['waccs'];
        $rateFCR = $perk['rate'];
        break;
      }
  $command = $connection->createCommand("SELECT ppq, prodquant, ppm FROM prr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $ppq = $perk['ppq'];
        $tpqPRR= $perk['prodquant'];
        $ppmPRR = $perk['ppm'];
        break;
      }

  $command = $connection->createCommand("SELECT defect, tpq, ppm FROM tldr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $def = $perk['defect'];
        $tpqTLDR = $perk['tpq'];
        $ppmTLDR = $perk['ppm'];
        break;
      }
  $command = $connection->createCommand("SELECT rework, tpq, ppm FROM ifrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $rew = $perk['rework'];
        $tpqIFRR = $perk['tpq'];
        $ppmIFRR = $perk['ppm'];
        break;
      }


      $htm = $htm.''.$accsvc.'</td>
         <td class="ao"><b></td>';
      $restam = sizeof($week_total);
      echo $restam;
      foreach ($FFR1 as $key){
        $htm = $htm.'<td class="week">'.$key.'</td>';
        $restam--;
      }

      for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="week"></td>';
      }
      
      $htm = $htm.'
         <td class="ap">0 </td>
         
         <td class="impr" style="color: green; vertical-align:middle">x% </td>
        </tr>
        <tr style="text-align: center;" class="FFR">
         <td>W. Acc. Sales</td>
         <td class="lp"><b>'.$waccs.'</td>
         <td class="ao"><b></td>';

      foreach ($FFR2 as $key) {
        $htm = $htm.'<td class="week">'.$key.'</td>';
      }

      for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="week"></td>';
      }

      $htm = $htm.'
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
         <td bgColor="#e0e0e0" class="week" ></td>
         <td bgColor="#e0e0e0" class="week" ></td>
         <td bgColor="#e0e0e0" class="ap">0</td>
         <td bgColor="#e0e0e0" class="impr" style="color: green; vertical-align:middle"> x%  </td>
         <td bgColor="#e0e0e0" class="patt">35</td>
         <td bgColor="#e0e0e0" class="pts" >35 </td>
         <td bgColor="#e0e0e0" class="prctg">0% </td>
        </tr>
        <tr style="text-align: center;">
         <td rowspan="3" style="vertical-align: middle"title="Failure Cost Rate" bgcolor="#e0e0e0">FCR </td>
         <td>Failure cost</td>
         <td class="lp"><b>63.5</td>
         <td class="ao"><b>60.4</td>
         <td class="week">13.0</td>
         <td class="week">14.6</td>
         <td class="week">14.0</td>
         <td class="week"></td>
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
         <td class="week"></td><!-- 900.1-->
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
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">1.74</td>
         <td class="impr" style="color: green; vertical-align:middle"> x% </td>
         <td class="patt">20</td>
         <td class="pts" ">4 </td>
         <td class="prctg">0% </td>
        </tr>
        <tr style="text-align: center;">
         <td rowspan="9" style="vertical-align: middle" bgColor="#e0e0e0">Production</td>
         <td rowspan="3" style="vertical-align: middle" bgColor="#e0e0e0" title="Parts Return Rate">PRR</td>
         <td>Poor parts quantity</td>
         <td class="lp"><b>

      </table>';
/*
            $htm = $htm.'</tr></thead><tbody>';

            $items = array('Item1 MWO IQC6','Item2 RAC IQC6','Item4 MWO IQC6','Item5 RAC IQC6','Item6 MWO IQC6','Item7 RAC IQC6','Item8 MWO IQC6','Item9 RAC IQC6','Item1 MWO IQC10','Item2 RAC IQC11');
            foreach ($items as $key) {
                $htm = $htm . '<tr><td>' . $key . '</td>';
                foreach ($dias_total as $dia) {
                    $htm = $htm .'
                        <td>
                            <div class="radio">
                                <label>
                                  <input type="radio" name="radios_'. $key .'" id="radio_"' . $key.'_'. $dia .'" value="'. $dia .'" >
                                </label>
                            </div>
                        </td>
                    ';
                }
                $htm = $htm . '</tr>';
            }
            $htm = $htm.'</tbody>';
*/

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
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% ↓</b>"
                  impr[i].bgColor = "#32f032";
                  impr[i].style = "color: black; vertical-align:middle";
                }else if (result >= -10){
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% ↑ </b>"
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black; vertical-align:middle";
                }else{
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% ↑ </b>";
                  impr[i].bgColor = "#f00f0f";
                  impr[i].style = "color: white; vertical-align:middle";
                }
              }
            }else{
              for (var i = lp.length - 1; i >= 0; i--) {
                if(result >= 10){
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% ↓</b>"
                  impr[i].bgColor = "#f00f0f";
                  impr[i].style = "color: white; vertical-align:middle"; 
                }else if (result >= 0){
                  impr[i].innerHTML = "<b>" + result.toFixed(0) + "% ↑ </b>";
                  impr[i].bgColor = "yellow";
                  impr[i].style = "color: black; vertical-align:middle";
                }else{
                  impr[i].innerHTML = "<b>" + result.toFixed(0)*-1 + "% ↑ </b>";
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
                url:'http://localhost/QSmart/frontend/views/qhiboard/monthlytable.php',
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
                url:'http://localhost/QSmart/frontend/views/qhiboard/weeklytable.php',
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
        <?php echo $htm;?>
       <table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-bordered table-condensed table-hover">
       <thead>
        <tr style="text-align: center;">
         <th style="vertical-align: middle; text-align: center;" colspan="3" rowspan="2">KPI</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >DEC'17 <br> Result</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >DEC'18 <br> Target</th>
         <th style="vertical-align: middle; text-align: center;" colspan="7" >DEC'18 Result</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >Target</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >Result</th>
         <th style="vertical-align: middle; text-align: center;" rowspan="2" >Achievement</th>
        </tr>
        <tr style="text-align: center; vertical-align: middle;">
         <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W48</td>
         <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W49</td>
         <td style="vertical-align: middle; text-align: centerlt;"width="70px"> <b>W50</td>
         <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W51</td>
         <td style="vertical-align: middle; text-align: center;"width="70px"> <b>W52</td>
         <td style="vertical-align: middle; text-align: center;"> <b>Acc. </td>
         <td style="vertical-align: middle; text-align: center;"> <b>YOY</td> <!--  ((17' - 18')/17')*100-->
        </tr>
       </thead>
       <tbody>
        <tr style="text-align: center;">
         <td rowspan="6" style="vertical-align: middle" bgcolor="#e0e0e0">Market</td>
         <td rowspan="3" style="vertical-align: middle" bgcolor="#e0e0e0" title="Failure Field Rate">FFR </td>
         <td>Acc. SVC</td>
         <td class="lp"><b>2447</td>
         <td class="ao"><b></td>
         <td class="week">2191 </td>
         <td class="week">2229 </td>
         <td class="week">2280 </td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">0 </td>
         <td class="impr" style="color: green; vertical-align:middle">x% </td>
        </tr>
        <tr style="text-align: center;" class="FFR">
         <td>W. A. Sales</td>
         <td class="lp"><b>142440  </td>
         <td class="ao"><b></td>
         <td class="week">160874  </td>
         <td class="week">160888  </td>
         <td class="week">161305  </td>
         <td class="week"></td>
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
         <td bgColor="#e0e0e0" class="week" ></td>
         <td bgColor="#e0e0e0" class="week" ></td>
         <td bgColor="#e0e0e0" class="ap">0</td>
         <td bgColor="#e0e0e0" class="impr" style="color: green; vertical-align:middle"> x%  </td>
         <td bgColor="#e0e0e0" class="patt">35</td>
         <td bgColor="#e0e0e0" class="pts" >35 </td>
         <td bgColor="#e0e0e0" class="prctg">0% </td>
        </tr>
        <tr style="text-align: center;">
         <td rowspan="3" style="vertical-align: middle"title="Failure Cost Rate" bgcolor="#e0e0e0">FCR </td>
         <td>Failure cost</td>
         <td class="lp"><b>63.5</td>
         <td class="ao"><b>60.4</td>
         <td class="week">13.0</td>
         <td class="week">14.6</td>
         <td class="week">14.0</td>
         <td class="week"></td>
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
         <td class="week"></td><!-- 900.1-->
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
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">1.74</td>
         <td class="impr" style="color: green; vertical-align:middle"> x% </td>
         <td class="patt">20</td>
         <td class="pts" ">4 </td>
         <td class="prctg">0% </td>
        </tr>
        <tr style="text-align: center;">
         <td rowspan="9" style="vertical-align: middle" bgColor="#e0e0e0">Production</td>
         <td rowspan="3" style="vertical-align: middle" bgColor="#e0e0e0" title="Parts Return Rate">PRR</td>
         <td>Poor parts quantity</td>
         <td class="lp"><b>52</td>
         <td class="ao"><b></td>
         <td class="week">24</td>
         <td class="week">12</td>
         <td class="week">3</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">31</td>
         <td class="impr" style="color: green; vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center;">
         <td>Production quantity</td>
         <td class="lp"><b>62688</td>
         <td class="ao"><b></td>
         <td class="week">23164</td>
         <td class="week">14606</td>
         <td class="week">10557</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">40174</td>
         <td class="impr" style="color: green; vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center;" bgColor="#e0e0e0">
         <td bgColor="#e0e0e0" >PPM </td>
         <td bgColor="#e0e0e0" class="lp"><b>830</td>
         <td bgColor="#e0e0e0" class="ao"><b>454</td>
         <td bgColor="#e0e0e0" class="week">1036</td>
         <td bgColor="#e0e0e0" class="week">821</td>
         <td bgColor="#e0e0e0" class="week">310</td>
         <td bgColor="#e0e0e0" class="week"></td>
         <td bgColor="#e0e0e0" class="week"></td>
         <td bgColor="#e0e0e0" class="ap">772</td>
         <td bgColor="#e0e0e0" class="impr" style="color: red; vertical-align:middle"> x%  </td>
         <td bgColor="#e0e0e0" class="patt">15</td>
         <td bgColor="#e0e0e0" class="pts">15</td>
         <td bgColor="#e0e0e0" class="prctg">0%</td>
        </tr>
        <tr style="text-align: center;">
        <td rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate"bgColor="#e0e0e0">TLDR</td>
         <td>Defect quantity</td>
         <td class="lp"><b>131</td>
         <td class="ao"><b></td>
         <td class="week">11</td>
         <td class="week">7</td>
         <td class="week">21</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">62</td>
         <td class="impr" style="color: green; vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center;">
         <td>Total production quantity</td>
         <td class="lp"><b>31688</td>
         <td class="ao"><b></td>
         <td class="week">10005</td>
         <td class="week">7456</td>
         <td class="week">4296</td>
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
         <td class="patt">15</td>
         <td class="pts">12</td>
         <td class="prctg">0%</td>
        </tr>
        <tr style="text-align: center">
        <td rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Rework Rate" bgColor="#e0e0e0">IFRR </td>
        <td>Rework quantity</td>
         <td class="lp"><b>70</td>
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
         <td class="lp"><b>31668</td>
         <td class="ao"><b></td>
         <td class="week">10005</td>
         <td class="week">7456</td>
         <td class="week">4296</td>
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
          <td bgColor="#e0e0e0"class="patt">15</td>
          <td bgColor="#e0e0e0"class="pts">15</td>
          <td bgColor="#e0e0e0"class="prctg">100%</td>
        </tr>
        
       </tbody>
      </table>
  
      </div>
    </div> 
</div>