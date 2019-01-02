<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\QhiboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QHI Board';
//$this->params['breadcrumbs'][] = $this->title;

$connection = Yii::$app->getDb();


function semana_do_ano($dia,$mes,$ano){

        $var=intval( date('z', mktime(0,0,0,$mes,$dia,$ano) ) / 7 ) + 1;

        return $var;
        }

        function impr1($lp, $ap){
            if ($lp == 0){
              if ($ap == 0){
                $var = 0;
              }else{
                $var = -100;
              }
            }else{
              $var = round(($lp-$ap)/$lp*100);
            }
            if ($var > 0){
                $var = '<td class="impr" bgColor = "#32f032" style="color: black; vertical-align:middle"><b>'.$var.'% ↓';
            }else if ($var >= -10){
                $var = $var*(-1);
                $var = '<td class="impr" bgColor = "yellow" style="color: black; vertical-align:middle"><b>'.$var.'% ↑';
            }else{
                $var = $var*(-1);
                $var = '<td class="impr" bgColor = "f00f0f" style="color: white; vertical-align:middle"><b>'.$var.'% ↑';
            }
            return $var;
        }

        function impr2($lp, $ap){
            $var = round(($lp-$ap)/$lp*100);
            if ($var >= 10){
                $var = '<td class="impr" bgColor = "#f00f0f" style="color: white; vertical-align:middle"><b>'.$var.'% ↓';
            }else if ($var >= 0){
                $var = $var*(-1);
                $var = '<td class="impr" bgColor = "yellow" style="color: black; vertical-align:middle"><b>'.$var.'% ↑';
            }else{
                $var = $var*(-1);
                $var = '<td class="impr" bgColor = "#32f032" style="color: black; vertical-align:middle"><b>'.$var.'% ↑';
            }
            return $var;
        }

        function impr3($lp, $ap){
            $var = round(($lp-$ap)/$lp*100);
            if ($var >= 10){
                $var = '<td class="impr" bgColor = "#f00f0f" style="color: white; vertical-align:middle"><b>'.$var.'% ↓';
            }else if ($var > 0){
                $var = $var*(-1);
                $var = '<td class="impr" bgColor = "yellow" style="color: black; vertical-align:middle"><b>'.$var.'% ↑';
            }else{
                $var = $var*(-1);
                $var = '<td class="impr" bgColor = "#32f032" style="color: black; vertical-align:middle"><b>'.$var.'% ↑';
            }
            return $var;
        }


        $week = semana_do_ano(date('d'),date('m'),date('Y'));
        $month = date('m');
        $M = strtoupper(date('M'));
        $year = date('Y');
        $Y = date('y');
        $ly = $Y-1;
        $LY = $year - 1;


              


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
                            if ($n < 10){
                              $n = '0'.$n.'';
                            }
                            array_push($week_total,$n);
                        }
                        
                    }
                    $key = array_search(53, $week_total);
                      if($key!==false){
                          unset($week_total[$key]);
                      }
                      
                      $week_total = array_unique($week_total);
                      

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


          $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM bd_lg.ffr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
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

              $command = $connection->createCommand("SELECT failcost, sales, rate FROM bd_lg.fcr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $fc = $perk['failcost'];
                $sales = $perk['sales'];
                $rate = $perk['rate'];
                array_push($FCR1,$fc);
                array_push($FCR2,$sales);
                array_push($FCR3,$rate);
                break;
              }

          $command = $connection->createCommand("SELECT ppq, prodquant, ppm FROM bd_lg.prr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
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

              $command = $connection->createCommand("SELECT defect, tpq, ppm FROM bd_lg.tldr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

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

              $command = $connection->createCommand("SELECT rework, tpq, ppm FROM bd_lg.ifrr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

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

          $command = $connection->createCommand("SELECT * FROM bd_lg.ffr_acc WHERE `month` = ".$month." AND `year` = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $accsvc = $perk['accsvc'];
                $waccs = $perk['waccs'];
                $rateFFR = $perk['rate'];
                break;
              }       
        /*
          $command = $connection->createCommand("SELECT failcost, sales, rate FROM fcr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $fc = $perk['failcost'];
                $sales = $perk['sales'];
                $rateFCR = $perk['rate'];
                break;
              }
              */
          $command = $connection->createCommand("SELECT ppq, prodquant, ppm FROM bd_lg.prr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ppq = $perk['ppq'];
                $tpqPRR= $perk['prodquant'];
                $ppmPRR = $perk['ppm'];
                break;
              }

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM bd_lg.tldr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $def = $perk['defect'];
                $tpqTLDR = $perk['tpq'];
                $ppmTLDR = $perk['ppm'];
                break;
              }
          $command = $connection->createCommand("SELECT rework, tpq, ppm FROM bd_lg.ifrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $rew = $perk['rework'];
                $tpqIFRR = $perk['tpq'];
                $ppmIFRR = $perk['ppm'];
                break;
              }

          $command = $connection->createCommand("SELECT result FROM bd_lg.qhi_results WHERE rate = 'FFR' ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ptsFFR = $perk['result'];
                break;
              }
            $command = $connection->createCommand("SELECT result FROM bd_lg.qhi_results WHERE rate = 'FCR' ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ptsFCR = $perk['result'];
                break;
              }
            $command = $connection->createCommand("SELECT result FROM bd_lg.qhi_results WHERE rate = 'PRR' ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ptsPRR = $perk['result'];
                break;
              }
            $command = $connection->createCommand("SELECT result FROM bd_lg.qhi_results WHERE rate = 'TLDR' ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ptsTLDR = $perk['result'];
                break;
            }

            $command = $connection->createCommand("SELECT result FROM bd_lg.qhi_results WHERE rate = 'IFRR' ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ptsIFRR = $perk['result'];
                break;
            }


        $colspan = sizeof($week_total)+2;
        $htm = '<table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-condensed table-hover">
                      <thead>
                <tr style="text-align: center; font-size:110%;">
                 <th style="vertical-align: middle; text-align: center;" colspan="3" rowspan="2">KPI</th>

                 ';
                      $htm = $htm.'<th style="vertical-align: middle; text-align: center;" rowspan="2" >' . $M .'';

                      $htm = $htm.'\''. $ly .' <br> Result</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan="2" >'.$M.'\''.$Y.' <br> Target</th>
                 <th style="vertical-align: middle; text-align: center;" colspan="'.$colspan.'" >'.$M.'\''.$Y.'\' Result</th>
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
                 <td style="vertical-align: middle; text-align: center;"> <b>YOY</td>
                </tr>
                </thead>
                <tbody>
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="6" style="vertical-align: middle" bgcolor="#e0e0e0">Market</td>
                 <td rowspan="3" style="vertical-align: middle" bgcolor="#e0e0e0" title="Failure Field Rate">FFR </td>
                 <td>Acc. SVC</td>
                 <td class="lp">';

              $htm = $htm.'<b>'.$accsvc.'</td>
                 <td class="ao"><b></td>';
              $restam = sizeof($week_total);
              foreach ($FFR1 as $key){
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $Acc = $key;
                $restam--;
              }

              $yoy = impr1($accsvc,$Acc);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }
              
              $htm = $htm.'
                 <td class="ap"><b>'.$Acc.'</td>
                 
                 '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;" class="FFR">
                 <td>W. Acc. Sales</td>
                 <td class="lp"><b>'.$waccs.'</td>
                 <td class="ao"><b></td>';
              foreach ($FFR2 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $Acc=$key;
              }
              $yoy = impr2($waccs,$Acc);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }


              $htm = $htm.'
                 <td class="ap"><b>'.$Acc.'</td>
                 '.$yoy.'
                </tr>
                <tr  bgColor="#e0e0e0" style="text-align: center; font-size:110%;">
                 <td bgColor="#e0e0e0">Rate</td>
                 <td bgColor="#e0e0e0" class="lp"><b>'.$rateFFR.'</td>
                 <td bgColor="#e0e0e0" class="ao"><b>1,90</td>';
                 
              foreach ($FFR3 as $key) {
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week">'.$key.'</td>';
                $Acc=$key;
              }
              $yoy = impr1($rateFFR,$Acc);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week"></td>';
              }
              $p = ($ptsFFR/35)*100;
              $htm = $htm.'
                 <td bgColor="#e0e0e0" class="ap"><b>'.$Acc.'</td>
                 '.$yoy.'
                 <td bgColor="#e0e0e0" class="patt">35</td>
                 <td bgColor="#e0e0e0" class="pts" >'.$ptsFFR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';
        // AQUI COMEÇA O FCR
                $fc = 63.5;
                $sales = 14528;
                $rateFCR = 0.44;
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="3" style="vertical-align: middle"title="Failure Cost Rate" bgcolor="#e0e0e0">FCR </td>
                 <td>Failure Cost</td>
                 <td class="lp"><b>'.$fc.'</td>
                 <td class="ao"><b>60,4</td>
                 ';

              $restam = sizeof($week_total);
              $soma = 0;
              foreach ($FCR1 as $key) {
                $htm = $htm.'<td class="week">'.$key."</td>";
                $restam--;
                $soma += $key;
              }

              $yoy = impr1($fc,$soma);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $htm = $htm.'
                 <td class="ap"><b>'.$soma.'</td>
                 '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td>Sales</td>
                 <td class="lp"><b>'.$sales.'</td>
                 <td class="ao"><b>13802</td>';
                 $soma1 = 0;
              foreach ($FCR2 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $soma1 += $key;
              }
              
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $yoy = impr2($sales,$soma1);
                 $htm = $htm.'
                 <td class="ap"><b>'.$soma1.'</td>
                 '.$yoy.'
                </tr>
                <tr bgcolor="#e0e0e0" style="text-align: center; font-size:110%;">
                 <td >Rate </td>
                 <td class="lp"><b>'.$rateFCR.'</td>
                 <td class="ao"><b>0.44</td>';
              foreach ($FCR3 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
              }
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }
              $soma = round($soma/$soma1*100,2);
              $yoy = impr1($rateFCR,$soma);

                $p = ($ptsFCR/20)*100;
                $htm = $htm.'
                 <td class="ap"><b>'.$soma.'</td>
                 '.$yoy.'
                 <td class="patt">20</td>
                 <td class="pts" ">'.$ptsFCR.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="9" style="vertical-align: middle" bgColor="#e0e0e0">Production</td>
                 <td rowspan="3" style="vertical-align: middle" bgColor="#e0e0e0" title="Parts Return Rate">PRR</td>
                 <td>Defect Quantity</td>
                 <td class="lp"><b>'.$ppq.'</td>

                 <td class="ao"><b></td>';

              $restam = sizeof($week_total);
              $soma = 0;
                foreach ($PRR1 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $restam--;
                    $soma += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }
                $yoy = impr1($ppq,$soma);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td>Production Quantity</td>
                 <td class="lp">';

                 $htm = $htm.'<b>'.$tpqPRR.'</td>
                 <td class="ao"><b></td>';
                 $soma1 = 0;
                 foreach ($PRR2 as $key) {
                   $htm = $htm.'<td class="week">'.$key.'</td>';
                    $soma1 += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }
                $yoy = impr2($tpqPRR,$soma1);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma1.'</td>
                     '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;" bgColor="#e0e0e0">
                 <td bgColor="#e0e0e0" >PPM</td>
                 <td bgColor="#e0e0e0" class="lp"><b>'.$ppmPRR.'</td>
                 <td bgColor="#e0e0e0" class="ao"><b>454</td>';

                 $soma = round(($soma/$soma1)*1000000);
                 foreach ($PRR3 as $key) {
                   $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                $yoy = impr1($ppmPRR,$soma);
                $p = ($ptsPRR/15)*100;
                $htm = $htm.'
                     <td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     '.$yoy.'

                 <td bgColor="#e0e0e0" class="patt">15</td>
                 <td bgColor="#e0e0e0" class="pts">'.$ptsPRR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';
                
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                <td rowspan="3" style="text-align: center; font-size:110%; vertical-align: middle" title="Total Line Defect Rate"bgColor="#e0e0e0">TLDR</td>
                 <td>Defect Quantity</td>
                 <td class="lp"><b>'.$def.'</td>
                 <td class="ao"><b></td>';
                 $soma = 0;
                 $restam = sizeof($week_total);
                 foreach ($TLDR1 as $key) {
                   $htm = $htm.'<td class="week">'.$key.'</td>';
                   $restam--;
                    $soma += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }
                $yoy = impr1($def,$soma);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td>Production Quantity</td>
                 <td class="lp"><b>'.$tpqTLDR.'</td>
                 <td class="ao"><b></td>';
                 $soma1 = 0;

                 foreach ($TLDR2 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $soma1 += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }
                $yoy = impr2($tpqTLDR,$soma1);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma1.'</td>
                     '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;" bgColor="#e0e0e0">
                  <td>PPM</td>
                 <td class="lp"><b>'.$ppmTLDR.'</td>
                 <td class="ao"><b>4200</td>';
                 $soma = round(($soma/$soma1)*1000000);

                 foreach ($TLDR3 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }
                $yoy = impr1($ppmTLDR,$soma);
                $p = ($ptsTLDR/15)*100;
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     '.$yoy.'
                 <td class="patt">15</td>
                 <td class="pts">'.$ptsTLDR.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';

        // IFRR começa aqui
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%">
                <td rowspan="3" style="text-align: center; font-size:110%; vertical-align: middle" title="Intern Failure Rework Rate" bgColor="#e0e0e0">IFRR </td>
                <td>Rework Quantity</td>
                 <td class="lp"><b>'.$rew.'</td>
                 <td class="ao"><b></td>';
                 $soma = 0;
                 $restam = sizeof($week_total);
                 foreach ($IFRR1 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $restam--;
                    $soma+=$key;
                 }

                 for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                 }

                 
                $yoy = impr1($rew,$soma);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;">
                  <td>Production Quantity</td>
                 <td class="lp"><b>'.$tpqIFRR.'</td>
                 <td class="ao"><b></td>';
                 $soma1 = 0;
                 foreach ($IFRR2 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $soma1+=$key;
                 }

                 for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                 }

                $yoy = impr2($tpqIFRR,$soma1);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma1.'</td>
                     '.$yoy.'
                </tr>
                <tr bgColor="#e0e0e0" style="text-align: center; font-size:110%;">
                  <td bgColor="#e0e0e0">PPM</td>
                  <td bgColor="#e0e0e0"class="lp"><b>'.$ppmIFRR.'</td>
                  <td bgColor="#e0e0e0" class="ao"><b>2,45</td>';
                 $soma = round(($soma/$soma1)*1000000);
                  
                 foreach ($IFRR3 as $key) {
                    $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                 }

                 for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                 }
                 $colspan = 2+$colspan-1;
                 
                $yoy = impr1($ppmIFRR,$soma);
                $somarates = $ptsFFR+$ptsFCR+$ptsPRR+$ptsTLDR+$ptsIFRR;
                $htm = $htm.'
                     <td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     '.$yoy.'
                  <td bgColor="#e0e0e0"class="patt">15</td>
                  <td bgColor="#e0e0e0"class="pts">'.$ptsIFRR.'</td>
                  <td bgColor="#e0e0e0"class="prctg">'.$p.'%</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td bgColor="#e0e0e0"colspan = 3>Total</td>
                <td bgColor="#e0e0e0"colspan = '.$colspan.'></td>
                <td></td>
                <td class="patt">100</td>
                <td class="pts">'.$somarates.'</td>
                <td class="prctg">'.$somarates.'%</td>
                </tr>
               </tbody>';
              
              $htm = $htm.'</table>';

$script = <<< JS

  $(document).ready(function(){
    window.location.href='#weekly-table';
        var wtable = $('#weekly-table');
    /*
        var j = 0;
        var ly = [];
        var py = [];
        var rs = [];
        
        var j = 0;
        var ptsv = [], pattv = [];
        wtable.find('tbody tr').each(function(){
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
                      if (j < 6){var result = (ly[k]/py[k])*100;
                        if(tembold){td2[i].innerHTML = "<b>" + result.toFixed(2);}
                        else{td2[i].innerHTML = result.toFixed(2);}
                      
                      }
                      else{
                        var result = (ly[k]/py[k])*1000000;
                        if(tembold){td2[i].innerHTML = "<b>" + result.toFixed(0);}
                      else{td2[i].innerHTML = result.toFixed(0);}
                      
                      }
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
                if (j < 6){
                  ap[i].innerHTML = "<b>" + soma.toFixed(1);
                }else{
                  ap[i].innerHTML = "<b>" + soma.toFixed(0);
                }
                if (j % 3 == 0){
                  ap1 = soma.toFixed(1);
                }else if (j % 3 == 1){ 
                  ap2 = soma.toFixed(1);
                }else{
                  if (j < 6){ ap[i].innerHTML = "<b>" + (ap1/ap2*100).toFixed(2);}
                  else{ ap[i].innerHTML = "<b>" + (ap1/ap2*1000000).toFixed(0);}
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
*/
          wtable.find('tbody tr td').each(function(){
            if(!isNaN($(this).text())){
                var num = $(this).text();
                var numero = num.split('.');
                if (numero.length > 1){
                  numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
                  var num = numero.join(',');
                }else{
                  var num = num.split('').reverse().join('').split(/(\d{3})/).filter(Boolean)
    .join('.').split('').reverse().join('');
                 }

                $(this).text(num);
  
          }
          });

          
          wtable.find('tbody tr').each(function(){
            var td = $(this).find('td');
                var i = 0;

                while (i < td.length){
                  var str = td[i].innerHTML;
                  if(td[i].className == 'lp' || td[i].className == 'ap' || td[i].className == 'ao'){
                      td[i].innerHTML = "<b>"+str;
                  }
                  i++;
                }
          });

          $('#showmonth').click(function(){
            $.ajax({
                url:'?r=qhiboard/month',
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
                url:'?r=qhiboard/week',
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
if ($lastday = date('d')){
  $command = $connection->createCommand("SELECT rework, tpq, ppm FROM bd_lg.ifrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
      $result = $command->queryAll();
      foreach ($result as $perk) {
        $rew = $perk['rework'];
        $tpqIFRR = $perk['tpq'];
        $ppmIFRR = $perk['ppm'];
        break;
      }
}
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
$this->registerCss("

th, td{
  text-align:center;
  vertical-align:middle;
  font-size:110%;
}  
  ");


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
        <!--
       <table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-bordered table-condensed table-hover">
       <thead>
        <tr style="text-align: center; ">
         <th style="vertical-align: middle; text-align: center; " colspan="3" rowspan="2">KPI</th>
         <th style="vertical-align: middle; text-align: center; " rowspan="2" >DEC'17 <br> Result</th>
         <th style="vertical-align: middle; text-align: center; " rowspan="2" >DEC'18 <br> Target</th>
         <th style="vertical-align: middle; text-align: center; " colspan="7" >DEC'18 Result</th>
         <th style="vertical-align: middle; text-align: center; " rowspan="2" >Target</th>
         <th style="vertical-align: middle; text-align: center; " rowspan="2" >Result</th>
         <th style="vertical-align: middle; text-align: center; " rowspan="2" >Achievement</th>
        </tr>
        <tr style="text-align: center;  vertical-align: middle;">
         <td style="vertical-align: middle; text-align: center; "width="70px"> <b>W48</td>
         <td style="vertical-align: middle; text-align: center; "width="70px"> <b>W49</td>
         <td style="vertical-align: middle; text-align: centerlt;"width="70px"> <b>W50</td>
         <td style="vertical-align: middle; text-align: center; "width="70px"> <b>W51</td>
         <td style="vertical-align: middle; text-align: center; "width="70px"> <b>W52</td>
         <td style="vertical-align: middle; text-align: center; "> <b>Acc. </td>
         <td style="vertical-align: middle; text-align: center; "> <b>YOY</td>
        </tr>
       </thead>
       <tbody>
        <tr style="text-align: center; ">
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
         <td class="impr" style="vertical-align:middle">x% </td>
        </tr>
        <tr style="text-align: center; " class="FFR">
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
        <tr  bgColor="#e0e0e0" style="text-align: center; ">
         <td bgColor="#e0e0e0">Rate </td>
         <td bgColor="#e0e0e0" class="lp"><b>1.97</td>
         <td bgColor="#e0e0e0" class="ao"><b>1.90</td>
         <td bgColor="#e0e0e0" class="week" >1.36</td>
         <td bgColor="#e0e0e0" class="week" >1.39</td>
         <td bgColor="#e0e0e0" class="week" >1.41</td>
         <td bgColor="#e0e0e0" class="week" ></td>
         <td bgColor="#e0e0e0" class="week" ></td>
         <td bgColor="#e0e0e0" class="ap">0</td>
         <td bgColor="#e0e0e0" class="impr" style="vertical-align:middle"> x%  </td>
         <td bgColor="#e0e0e0" class="patt">35</td>
         <td bgColor="#e0e0e0" class="pts" >35 </td>
         <td bgColor="#e0e0e0" class="prctg">0% </td>
        </tr>
        <tr style="text-align: center; ">
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
         <td class="impr" style="vertical-align:middle"> x%  </td>
        </tr>
        <tr style="text-align: center; ">
         <td>Sales</td>
         <td class="lp"><b>14528.7</td>
         <td class="ao"><b>13802.3</td>
         <td class="week">235.2</td>
         <td class="week">1437.0</td>
         <td class="week">408.0</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">2980.3</td>
         <td class="impr" style="vertical-align:middle"> 298%  </td>
        </tr>
        <tr bgcolor="#e0e0e0" style="text-align: center; ">
         <td >Rate </td> 
         <td class="lp"><b>0.44</td>
         <td class="ao"><b>0.44</td>
         <td class="week">5.53</td>
         <td class="week">1.02</td>
         <td class="week">3.43</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">1.74</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
         <td class="patt">20</td>
         <td class="pts" ">4 </td>
         <td class="prctg">0% </td>
        </tr>
        <tr style="text-align: center; ">
         <td rowspan="9" style="vertical-align: middle" bgColor="#e0e0e0">Production</td>
         <td rowspan="3" style="vertical-align: middle" bgColor="#e0e0e0" title="Parts Return Rate">PRR</td>
         <td>Poor parts Quantity</td>
         <td class="lp"><b>52</td>
         <td class="ao"><b></td>
         <td class="week">24</td>
         <td class="week">12</td>
         <td class="week">3</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">31</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center; ">
         <td>Production Quantity</td>
         <td class="lp"><b>62688</td>
         <td class="ao"><b></td>
         <td class="week">23164</td>
         <td class="week">14606</td>
         <td class="week">10557</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">40174</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center; " bgColor="#e0e0e0">
         <td bgColor="#e0e0e0" >PPM </td>
         <td bgColor="#e0e0e0" class="lp"><b>830</td>
         <td bgColor="#e0e0e0" class="ao"><b>454</td>
         <td bgColor="#e0e0e0" class="week">1036</td>
         <td bgColor="#e0e0e0" class="week">821</td>
         <td bgColor="#e0e0e0" class="week">310</td>
         <td bgColor="#e0e0e0" class="week"></td>
         <td bgColor="#e0e0e0" class="week"></td>
         <td bgColor="#e0e0e0" class="ap">772</td>
         <td bgColor="#e0e0e0" class="impr" style="vertical-align:middle"> x%  </td>
         <td bgColor="#e0e0e0" class="patt">15</td>
         <td bgColor="#e0e0e0" class="pts">15</td>
         <td bgColor="#e0e0e0" class="prctg">0%</td>
        </tr>
        <tr style="text-align: center; ">
        <td rowspan="3" style="text-align: center;  vertical-align: middle" title="Total Line Defect Rate"bgColor="#e0e0e0">TLDR</td>
         <td>Defect Quantity</td>
         <td class="lp"><b>131</td>
         <td class="ao"><b></td>
         <td class="week">11</td>
         <td class="week">7</td>
         <td class="week">21</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">62</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center; ">
         <td>Production Quantity</td>
         <td class="lp"><b>31688</td>
         <td class="ao"><b></td>
         <td class="week">10005</td>
         <td class="week">7456</td>
         <td class="week">4296</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">24629</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center; " bgColor="#e0e0e0">
          <td>PPM</td> 
         <td class="lp"><b>3729</td>
         <td class="ao"><b>4200</td>
         <td class="week">5201</td>
         <td class="week">1477</td>
         <td class="week">2537</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">24629</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
         <td class="patt">15</td>
         <td class="pts">12</td>
         <td class="prctg">0%</td>
        </tr>
        <tr style="text-align: center">
        <td rowspan="3" style="text-align: center;  vertical-align: middle" title="Intern Failure Rework Rate" bgColor="#e0e0e0">IFRR </td>
        <td>Rework Quantity</td>
         <td class="lp"><b>70</td>
         <td class="ao"><b></td>
         <td class="week">0</td>
         <td class="week">0</td>
         <td class="week">0</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">31</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
        </tr>
        <tr style="text-align: center; ">
          <td>Production Quantity</td>
         <td class="lp"><b>31668</td>
         <td class="ao"><b></td>
         <td class="week">10005</td>
         <td class="week">7456</td>
         <td class="week">4296</td>
         <td class="week"></td>
         <td class="week"></td>
         <td class="ap">31</td>
         <td class="impr" style="vertical-align:middle"> x% </td>
        </tr>
        <tr bgColor="#e0e0e0" style="text-align: center; ">
          <td bgColor="#e0e0e0">PPM</td>
          <td bgColor="#e0e0e0"class="lp"><b>0</td>
          <td bgColor="#e0e0e0" class="ao"><b></td>
          <td bgColor="#e0e0e0"class="week">0</td>
          <td bgColor="#e0e0e0"class="week">0</td>
          <td bgColor="#e0e0e0"class="week">0</td>
          <td bgColor="#e0e0e0"class="week"></td>
          <td bgColor="#e0e0e0"class="week"></td>
          <td bgColor="#e0e0e0"class="ap">31</td>
          <td bgColor="#e0e0e0"class="impr" style="vertical-align:middle"> x% </td>
          <td bgColor="#e0e0e0"class="patt">15</td>
          <td bgColor="#e0e0e0"class="pts">15</td>
          <td bgColor="#e0e0e0"class="prctg">100%</td>
        </tr>
        
       </tbody>
      </table>
  -->
      </div>
    </div> 
</div>
