<?php

use app\models\Article;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

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
					return '<img class="img-thumbnail" src="'. $data->image .'" width="100%" alt="">';
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
            //'article',
            //'created_at',
            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Article $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
	</div>
  </div>
</div>