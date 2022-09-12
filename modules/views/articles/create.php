<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = 'Новость';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">
  <h1><?= Html::encode($this->title) ?></h1>
  <div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title" style="display:inline-block">Форма добавления</h3>
	  <div class="btn-group pull-right">
	    <button type="submit" form="news-form" data-toggle="tooltip" title="Сохранить" class="btn btn-success btn-sm"><span class="hiden-xs">Сохраниь </span> <i class="fa fa-save"></i></button>
	  </div>
	</div>
    <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
  </div>
</div>