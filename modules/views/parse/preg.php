<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */	
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\modules\models\ParsePregmatch $model */

$this->title = 'Парсинг Preg Match';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title" style="display:inline-block">Форма получения</h3>
	  <div class="btn-group pull-right">
		<a class="btn btn-sm btn-primary" href="?type=rbk">Заполнить для rbc.ru</a>
		<button type="submit" form="parse-form" data-toggle="tooltip" title="Получить" class="btn btn-success btn-sm">Получить</button>
	  </div>
	</div>
	<div class="panel-body">
	  
	  <?php $form = ActiveForm::begin(['id' => 'parse-form']); ?>
	    <div class="row">
		  <div class="col-sm-6">
			<?= $form->field($model, 'url') ?>
		  </div>
		  <div class="col-sm-6">
			<?= $form->field($model, 'grabmain')->dropDownList($model->grabmainlist) ?>
		  </div>
		</div>
		<div class="row">
		  <div class="col-md-4">
		    <legend>Страница списка</legend>
			<div class="row">
			  <div class="col-sm-4">
			    <?= $form->field($model, 'parentteg')->dropDownList($model->elementlist) ?>
			  </div>
			  <div class="col-sm-4">
			    <?= $form->field($model, 'parenttipe')->dropDownList($model->typelist) ?>
			  </div>
			  <div class="col-sm-4">
				<?= $form->field($model, 'parent') ?>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-4">
			    <?= $form->field($model, 'itemteg')->dropDownList($model->elementlist) ?>
			  </div>
			  <div class="col-sm-4">
			    <?= $form->field($model, 'itemtipe')->dropDownList($model->typelist) ?>
			  </div>
			  <div class="col-sm-4">
				<?= $form->field($model, 'item') ?>
			  </div>
			</div>
			<div id="home" class="d-none hidden">
			  <h3 class="text-center">Главная новость</h3>
			  <div class="row">
			    <div class="col-sm-4">
			      <?= $form->field($model, 'hometeg')->dropDownList($model->elementlist) ?>
			    </div>
			    <div class="col-sm-4">
			      <?= $form->field($model, 'hometipe')->dropDownList($model->typelist) ?>
			    </div>
			    <div class="col-sm-4">
				  <?= $form->field($model, 'home') ?>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-sm-4">
			      <?= $form->field($model, 'homeidteg')->dropDownList($model->elementlist) ?>
			    </div>
			    <div class="col-sm-4">
			      <?= $form->field($model, 'homeidtipe')->dropDownList($model->typelist) ?>
			    </div>
			    <div class="col-sm-4">
				  <?= $form->field($model, 'homeid') ?>
			    </div>
			  </div>
			  *Возвращает аттрибут data-id;
			</div>
		  </div>
		  <div class="col-md-8">
		    <legend>Детальнвя страница</legend>
			<div class="row">
			  <div class="col-sm-4">
				<?= $form->field($model, 'titleteg')->dropDownList($model->elementlist) ?>
			  </div>
			  <div class="col-sm-4">
			    <?= $form->field($model, 'titletipe')->dropDownList($model->typelist) ?>
			  </div>
			  <div class="col-sm-4">
				<?= $form->field($model, 'title') ?>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-4">
				<?= $form->field($model, 'categoryteg')->dropDownList($model->elementlist) ?>
			  </div>
			  <div class="col-sm-4">
			    <?= $form->field($model, 'categorytipe')->dropDownList($model->typelist) ?>
			  </div>
			  <div class="col-sm-4">
				<?= $form->field($model, 'category') ?>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-4">
				<?= $form->field($model, 'imageteg')->dropDownList($model->elementlist) ?>
			  </div>
			  <div class="col-sm-4">
			    <?= $form->field($model, 'imagetipe')->dropDownList($model->typelist) ?>
			  </div>
			  <div class="col-sm-4">
				<?= $form->field($model, 'image') ?>
			  </div>
			</div>
			<div class="row">
			  <div class="col-sm-4">
				<?= $form->field($model, 'articleteg')->dropDownList($model->elementlist) ?>
			  </div>
			  <div class="col-sm-4">
			    <?= $form->field($model, 'articletipe')->dropDownList($model->typelist) ?>
			  </div>
			  <div class="col-sm-4">
				<?= $form->field($model, 'article') ?>
			  </div>
			</div>
			
		  </div>
		</div>
	  <?php ActiveForm::end(); ?>
	</div>
  </div>
</div>
<?php
$index = <<< JS
	$('#parsepregmatch-grabmain').on('change', function(){
		home();
	})
	home();
	function home()
	{
		if($('#parsepregmatch-grabmain').val() == 1) {
			$('#home').removeClass('d-none hidden');
		} else {
			$('#home').addClass('d-none hidden');
		}
	}
JS;
$this->registerJs($index, yii\web\View::POS_READY);
?>