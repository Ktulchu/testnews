<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\models\SearchCategory $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <h1><?= Html::encode($this->title) ?></h1>
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title" style="display:inline-block">Список категорий</h3>
	  <div class="btn-group pull-right">
		<?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
	  </div>
	</div>
	<div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'layout'=>"{items}\n{pager}\n{summary}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
			[
				'attribute'=>'parent_id',
				'label'=>'Родительская категория',
				'format'=>'text', 
				'content'=>function($data){
					return ($data->parent_id) ? $data->getParentName() : '<span class="text-danger">Не задано</span>';
				},
				'filter' => Category::getParentsList()
			],  
            'seourl',
            [
				'attribute'=>'status',
				'content'=>function($data){
					return $data->statusName[$data->status];
				},
				'filter' => Category::getStatusName()
			],
            'created_at:datetime',
            //'updated_at',
             [
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Действия',
				'headerOptions' => ['width' => '130'],
				'template' => '{status} {update} {delete}',
				'buttons' => [
					'status' => function ($url,$model) {	
						$status = ($model['status'] == 10) ? '<span class="fa fa-eye"></span>' : '<span class="fa fa-eye-slash"></span>';
						$class = ($model['status'] == 10) ? '' : ' btn-disabled';
						return Html::a( $status, 'javascript:void(0)', ['class' => 'btn btn-success btn-sm status'.$class, 'id' =>'js-'.$model->id, 'data-id' => $model->id]);
					},
					'update' => function ($url,$model) {
						return Html::a('<span class="fa fa-pencil"></span>', Url::to(['update', 'id' => $model->id, 'page' => Yii::$app->request->get('page')]), ['class' => 'btn btn-primary btn-sm']);
					},
					'delete' => function ($url,$model,$key) {
						return Html::a('<span class="fa fa-trash"></span>', $url, ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => 'Действие не обратимо. Вы уверены?']);
					},
				],
			],
        ],
    ]); ?>
	</div>
  </div>
</div>
<?php
$index = <<< JS
$(document).on('click', '.status', function(){
	var id = $(this).data("id");
	$("#massage").html('');
	$.ajax({
		url: '/admin/category/status',
		data: {id:id},
		type: 'get',
		dataType: 'json',
		success: function(json) {
			$('#js-' + id).html(json['icon']);
			if($('#js-' + id).hasClass("btn-disabled"))
			{
				$('#js-' + id).removeClass("btn-disabled");
			}
			$('#js-' + id).addClass(json['class']);
			$("#massage").html('<div class="alert alert-success"> ' + json['success'] + '</div>');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError);
		}
	});
});
JS;
$this->registerJs($index, yii\web\View::POS_READY);
?>