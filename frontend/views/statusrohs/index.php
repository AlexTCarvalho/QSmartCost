<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\statusrohsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'StatusRoHS';
$this->params['breadcrumbs'][] = $this->title;
?>

</br>
<div class="statusrohs-index">

	<div class="box box-danger">
        <div class="box-header with-border">
		<br>
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
		<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

		<p>
			<?= Html::a('Create StatusRoHS', ['create'], ['class' => 'btn btn-success']) ?>
		</p>

		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

				'month',
				[
					'attribute' => 'status',
					'contentOptions' => function ($model, $key, $index, $column) {
						return ['style' => 'color:' 
							. ($model->status == 'PENDING'?'#e6b800': ($model->status == 'APPROVED'?'green':'red'))];
					},
				],
				['class' => 'yii\grid\ActionColumn',                        
							'template' => '{view} {start} {stop} {edit} {delete}',                        
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
							],
				],
			],
		]); ?>
	</div>
</div>
