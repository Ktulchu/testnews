<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SearchUser */
/* @var $dataProvider yii\data\ActiveDataProvider */		
$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title" style="display:inline-block">Список пользователи</h3>
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
				'email:email',
				[
					'attribute'=>'status',
					'content'=>function($data){
						return $data->statusName[$data->status];
					},
					'filter' => User::getStatusName()
				],
				[
					'attribute'=>'role',
					'content'=>function($data){
						return $data->roleName[$data->role];
					},
					'filter' => User::getRoleName()
				],
				'created_at:datetime',
				[
					'class' => 'yii\grid\ActionColumn',
					'header'=>'Действия',
					'headerOptions' => ['width' => '130'],
					'template' => '{view} {update} {delete}',
					'buttons' => [
						'view' => function ($url,$model) {	
							return Html::a( '<span class="fa fa-eye"></span>', $url, ['class' => 'btn btn-success btn-sm']);
						},
						'update' => function ($url,$model) {
							return Html::a('<span class="fa fa-pencil"></span>', $url, ['class' => 'btn btn-primary btn-sm']);
						},
						'delete' => function ($url,$model,$key) {
							return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id, 'role' => $model->role], ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => 'Действие не обратимо. Вы уверены?']);
						},
					],
				],
			],
		]); ?>
	
	</div>
  </div>

</div>
