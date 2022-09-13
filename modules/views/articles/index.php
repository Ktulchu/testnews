<?php

use app\models\Article;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\components\Image;
/** @var yii\web\View $this */
/** @var app\modules\models\SearchArticle $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
  <h1><?= Html::encode($this->title) ?></h1> 
  <div class="panel panel-default">
    <div class="panel-heading">
	  <h3 class="panel-title" style="display:inline-block">Список страниц</h3>
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
			[
				'attribute'=>'image',
				'label'=>'Изображение',
				'headerOptions' => ['width' => '60'],
				'contentOptions' =>['class' => 'table_class','style'=>'display:block; text-align:center'],
				'content'=>function($data){
					if(substr($data->image, 0, 4) == "http") {
					   $source = $data->image;
					} else {
					   $source = Image::resize($data->image,95,63);
					}
					return '<img class="img-thumbnail" src="'. $source .'" width="100%" alt="">';
				},
				'filter' =>''
			],
			[
				'attribute'=>'category_id',
				'content'=>function($data){
					return ($data->category_id) ? $data->category->name : '<span class="not-set">(не задано)</span>';
				},
				'filter' => Article::getCategoryList()
			],
            'title',
            'announcement',
            'updated_at:datetime',
			[
				'class' => 'yii\grid\ActionColumn',
				'header'=>'Действия',
				'headerOptions' => ['width' => '130'],
				'template' => '{update} {delete}',
				'buttons' => [
					'update' => function ($url,$model) {
						return Html::a('<span class="fa fa-pencil"></span>', $url, ['class' => 'btn btn-primary btn-sm']);
					},
					'delete' => function ($url,$model,$key) {
						return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data-method' => 'post', 'data-confirm' => 'Действие не обратимо. Вы уверены?']);
					},
				],
			],   
        ],
    ]); ?>
	</div>
  </div>
</div>