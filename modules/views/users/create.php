<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Новый пользователь';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
  <h1><?= Html::encode($this->title) ?></h1>
  <div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title" style="display:inline-block">Список пользователи</h3>
	  <div class="btn-group pull-right">
	    <button type="submit" form="user-form" data-toggle="tooltip" title="Сохранить" class="btn btn-success btn-sm"><span class="hiden-xs">Сохраниь </span> <i class="fa fa-save"></i></button>
	  </div>
	</div>
    <div class="panel-body">
	  <div class="col">
        <?= $this->render('_form', [
          'model' => $model,
        ]) ?>
	  </div>
    </div>
  </div>
</div>
