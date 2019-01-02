<?php

namespace frontend\controllers;

use Yii;
use common\models\Qhiboard;
use common\models\QhiboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QhiboardController implements the CRUD actions for Qhiboard model.
 */
class QhiboardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Qhiboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QhiboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Qhiboard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Qhiboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Qhiboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Qhiboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Qhiboard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionWeek()
    {
        function semana_do_ano($dia,$mes,$ano){

        $var=intval( date('z', mktime(0,0,0,$mes,$dia,$ano) ) / 7 ) + 1;

        return $var;
        }

        function impr1($lp, $ap){
            $var = round(($lp-$ap)/$lp*100);
            if ($lp == 0){
              if ($ap == 0){
                $var = 0;
              }else{
                $var = -100;
              }
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
        $htm = '
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script type = "text/javascript">
        $(document).ready(function(){
          window.location.href=\'#weekly-table\';
        });
     </script>
        
        <table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-condensed table-hover">
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

              $htm = $htm.'<b>'. number_format($accsvc,0,".",".").'</td>
                 <td class="ao"><b></td>';
              $restam = sizeof($week_total);
              foreach ($FFR1 as $key){
                $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
                $Acc = $key;
                $restam--;
              }

              $yoy = impr1($accsvc,$Acc);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }
              
              $htm = $htm.'
                 <td class="ap"><b>'.number_format($Acc,0,".",".").'</td>
                 
                 '.$yoy.'
                </tr>
                <tr style="text-align: center; font-size:110%;" class="FFR">
                 <td>W. Acc. Sales</td>
                 <td class="lp"><b>'.number_format($waccs,0,".",".").'</td>
                 <td class="ao"><b></td>';
              foreach ($FFR2 as $key) {
                $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week">'.number_format($key,2,",",".").'</td>';
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
                 <td bgColor="#e0e0e0" class="pts" ">'.$ptsFFR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';
        // AQUI COMEÇA O FCR
                $fc = 63.5;
                $sales = 14528;
                $rateFCR = 0.44;
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="3" style="vertical-align: middle"title="Failure Cost Rate" bgcolor="#e0e0e0">FCR </td>
                 <td>Failure Cost</td>';
                 $htm = $htm.'<td class="lp"><b>'.number_format($fc,1,",",".").'</td>';
                 $htm = $htm.'
                 <td class="ao"><b>60,4</td>
                 ';

              $restam = sizeof($week_total);
              $soma = 0;
              foreach ($FCR1 as $key) {
                if(number_format($key,2,",",".")[-1] != 0){
                    $htm = $htm.'<td class="week">'.number_format($key,2,",",".").'</td>';
                }else{
                    $htm = $htm.'<td class="week">'.number_format($key,1,",",".").'</td>';
                }
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
                 <td class="lp"><b>'.number_format($sales,0,".",".").'</td>
                 <td class="ao"><b>13.802</td>';
                 $soma1 = 0;
              foreach ($FCR2 as $key) {
                $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                 <td class="ao"><b>0,44</td>';
              foreach ($FCR3 as $key) {

                if(number_format($key,2,",",".")[-1] != 0){
                    $htm = $htm.'<td class="week">'.number_format($key,2,",",".").'</td>';
                }else{
                    $htm = $htm.'<td class="week">'.number_format($key,1,",",".").'</td>';
                }

                
              }
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }
              $soma = round($soma/$soma1*100,2);
              $yoy = impr1($rateFCR,$soma);

                $p = ($ptsFCR/20)*100;
                $htm = $htm.'
                 <td class="ap"><b>'.number_format($soma,2,",",".").'</td>
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
                    $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                   $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                   $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.number_format($key,0,".",".").'</td>';
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
                 <td bgColor="#e0e0e0" class="pts" ">'.$ptsPRR.'</td>
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
                   $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                    $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                    $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                 <td class="pts" ">'.$ptsTLDR.'</td>
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
                    $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                    $htm = $htm.'<td class="week">'.number_format($key,0,".",".").'</td>';
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
                    $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.number_format($key,0,".",".").'</td>';
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
                 <td bgColor="#e0e0e0" class="pts" ">'.$ptsIFRR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
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
              return $htm;
    }

    public function actionMonth()
    {
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


        $year = date('Y');
        $Y = date('y');
        $ly = $Y-1;
        $LY = $year - 1;

        $connection = Yii::$app->getDb();

        $allmonths = [1,2,3,4,5,6,7,8,9,10,11,12];

        $FFRly = array();
        $FFRLY1 = 0;
        $FFRLY2 = 0;
        $FFRpy = array();
        $FFRPY1 = 0;
        $FFRPY2 = 0;
        $FCRly = array();
        $FCRLY1 = 0;
        $FCRLY2 = 0;
        $FCRpy = array();
        $FCRPY1 = 0;
        $FCRPY2 = 0;
        $PRRly = array();
        $PRRLY1 = 0;
        $PRRLY2 = 0;
        $PRRpy = array();
        $PRRPY1 = 0;
        $PRRPY2 = 0;
        $TLDRly = array();
        $TLDRLY1 = 0;
        $TLDRLY2 = 0;
        $TLDRpy = array();
        $TLDRPY1 = 0;
        $TLDRPY2 = 0;
        $IFRRly = array();
        $IFRRLY1 = 0;
        $IFRRLY2 = 0;
        $IFRRpy = array();
        $IFRRPY1 = 0;
        $IFRRPY2 = 0;
        
        foreach ($allmonths as $month) {
          $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM bd_lg.ffr_acc WHERE `month` = ".$month." AND `year` = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $FFRLY1 += $perk['accsvc'];
                $FFRLY2 += $perk['waccs'];
                array_push($FFRly, $perk['rate']);
                break;
              }
        /*
          $command = $connection->createCommand("SELECT failcost, sales, rate FROM bd_lg.fcr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $FCRLY1 += $perk['accsvc'];
                $FCRLY2 += $perk['waccs'];
                array_push($FCRly, $perk['rate']);
                break;
              }
              */
          $command = $connection->createCommand("SELECT ppq, prodquant, ppm FROM bd_lg.prr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $PRRLY1 += $perk['ppq'];
                $PRRLY2 += $perk['prodquant'];
                array_push($PRRly, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM bd_lg.tldr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $TLDRLY1 += $perk['defect'];
                $TLDRLY2 += $perk['tpq'];
                array_push($TLDRly, $perk['ppm']);
                break;
              }
          $command = $connection->createCommand("SELECT rework, tpq, ppm FROM bd_lg.ifrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $IFRRLY1 += $perk['rework'];
                $IFRRLY2 += $perk['tpq'];
                array_push($IFRRly, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM bd_lg.ffr_acc WHERE `month` = ".$month." AND `year` = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $FFRPY1 += $perk['accsvc'];
                $FFRPY2 += $perk['waccs'];
                array_push($FFRpy, $perk['rate']);
                break;
              }
        
          $command = $connection->createCommand("SELECT failcost, sales, rate FROM bd_lg.fcr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $FCRPY1 += $perk['accsvc'];
                $FCRPY2 += $perk['waccs'];
                array_push($FCRpy, $perk['rate']);
                break;
              }
              
          $command = $connection->createCommand("SELECT ppq, prodquant, ppm FROM bd_lg.prr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $PRRPY1 += $perk['ppq'];
                $PRRPY2 += $perk['prodquant'];
                array_push($PRRpy, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM bd_lg.tldr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $TLDRPY1 += $perk['defect'];
                $TLDRPY2 += $perk['tpq'];
                array_push($TLDRpy, $perk['ppm']);
                break;
              }
          $command = $connection->createCommand("SELECT rework, tpq, ppm FROM bd_lg.ifrr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $IFRRPY1 += $perk['rework'];
                $IFRRPY2 += $perk['tpq'];
                array_push($IFRRpy, $perk['ppm']);
                break;
              }
        }
      $htm = '

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
     <script type = "text/javascript">
        
        $(document).ready(function(){
          window.location.href=\'#monthly-table\';
        });
     </script>
    <table href="#" id = "monthly-table" class="table table-striped table-bordered table-condensed table-hover">
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
       <th width="80px" style="text-align: center;">Acc.</th>
      </tr>
     </thead>
     <tbody>
      <tr style="text-align: center;">
       <td rowspan="6" style="text-align: center; vertical-align: middle">Market</td>
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Field Rate">FFR </td>
       <td>\''.$ly.'</td>';
       $restam = 12;
       foreach ($FFRly as $key) {
         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

       $accly = $FFRLY1/$FFRLY2;
       $htm = $htm.'<td><b></td>';
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($FFRpy as $key) {
        $soma += $key;
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td>YOY</td>';
      for ($i=0; $i < sizeof($FFRpy); $i++) {
        $yoy = impr1($FFRly[$i],$FFRpy[$i]);
        $htm = $htm.''.$yoy.'';
      }

      $restam = sizeof($FFRly)-sizeof($FFRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td class="impr"></td>';
      }



       $htm = $htm.'
      </tr>
      <tr style="text-align: center;" >
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Cost Rate">FCR </td>
       <td>\''.$ly.'</td>';

       $restam = 12;
       foreach ($FCRly as $key) {
         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($FCRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td>YOY</td>';
      for ($i=0; $i < sizeof($FCRpy); $i++) {
        $yoy = impr1($FCRly[$i],$FCRpy[$i]);
        $htm = $htm.''.$yoy.'';
      }

      $restam = sizeof($FCRly)-sizeof($FCRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td class="impr"></td>';
      }


       $htm = $htm.'
      </tr>
      <tr style="text-align: center;" >
       <td rowspan="9" style="text-align: center; vertical-align: middle">Production</td>
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Parts Return Rate">PRR </td>
       <td>\''.$ly.'</td>';

       $restam = 12;
       foreach ($PRRly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($PRRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td>YOY</td>';
      for ($i=0; $i < sizeof($PRRpy); $i++) {
        $yoy = impr1($PRRly[$i],$PRRpy[$i]);
        $htm = $htm.''.$yoy.'';
      }

      $restam = sizeof($PRRly)-sizeof($PRRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td class="impr"></td>';
      }
          $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate">TLDR </td>
       <td>\''.$ly.'</td>';


       $restam = 12;
       foreach ($TLDRly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($TLDRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td>YOY</td>';
      for ($i=0; $i < sizeof($TLDRpy); $i++) {
        $yoy = impr1($TLDRly[$i],$TLDRpy[$i]);
        $htm = $htm.''.$yoy.'';
      }

      $restam = sizeof($TLDRly)-sizeof($TLDRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td class="impr"></td>';
      }

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
      <td rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Return Rate">IFRR </td>
       <td>\''.$ly.'</td>';


       $restam = 12;
       foreach ($IFRRly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($IFRRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td>YOY</td>';
      for ($i=0; $i < sizeof($IFRRpy); $i++) {
        $yoy = impr1($IFRRly[$i],$IFRRpy[$i]);
        $htm = $htm.''.$yoy.'';
      }

      $restam = sizeof($IFRRly)-sizeof($IFRRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td class="impr"></td>';
      }

       $htm = $htm.'
      </tr>
     </tbody>
    </table>';
    return $htm;
    }

    /**
     * Finds the Qhiboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Qhiboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Qhiboard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
