<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\statusrohsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'StatusRoHS';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  $(document).ready(function(){

         

  });

  /*google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Plan', 'Result'],
          ['2014', 1000, 400],
          ['2015', 1170, 460],
          ['2016', 660, 1120],
          ['2017', 1030, 540],
           ['2014', 1000, 400],
          ['2015', 1170, 460],
          ['2016', 660, 1120],
          ['2017', 1030, 540],
           ['2014', 1000, 400],
          ['2015', 1170, 460]
        ]);

        var options = {
          chart: {
            title: 'XRF Performance',
            subtitle: 'Plan and Result',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }*/

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
$this->registerJsFile('https://www.gstatic.com/charts/loader.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

</br>
<div class="statusrohs-index">
		<div class="box box-danger container">
	        <div class="box-header with-border">
			<br>
				<h1><?= Html::encode($this->title) ?></h1>
			</div>
			<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

			 <p>
				<?= Html::a('Create StatusRoHS', ['create'], ['class' => 'btn btn-success']) ?>
			</p> 

			<!-- <div id="columnchart_material" style="width: 100%; height: 300px;"></div>	 -->

			<?php echo GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					'month',
					/*[
						'attribute' => 'status',
						'contentOptions' => function ($model, $key, $index, $column) {
							return ['style' => 'color:' 
								. ($model->status == 'PENDING'?'#e6b800': ($model->status == 'APPROVED'?'green':'red'))];
						},
					],*/
					['class' => 'yii\grid\ActionColumn',                        
								'template' => '{view} {start} {stop} {edit} {delete} {barra}',                        
								'buttons' => [
									'view' => function($url,$model) {
											return Html::a(
												'<span class="fa fa-eye"></span>',
												['view', 'id' => $model->id], [
													'class' => 'btn btn-default',
													'title' => 'Visualizar Detalhes',
													'data-pjax' => '0',
												]
											);
									},
									'delete' => function($url,$model) {
											return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
												['delete', 'id' => $model->id], [
												'class' => 'btn btn-danger',
												'data' => [
													'confirm' => 'Are you sure you want to delete this item?',
													'method' => 'post',
												]]);
											
									},
									/*'barra' => function($url,$model) {
											return '<div class="progress">
													  <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
													</div>';
									},*/
								],
					],
				],
			]); ?>
		</div>
</div>
