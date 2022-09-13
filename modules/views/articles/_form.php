<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\editors\Summernote;
use kartik\select2\Select2;
use kartik\file\FileInput;
use app\components\Image;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">
  <?php $form = ActiveForm::begin(['id' => 'news-form']); ?>
	<div class="row">
	  <div class="col-md-8">
		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'announcement')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'content')->widget(Summernote::class, [
			'useKrajeePresets' => true,
		]); ?>
	  </div>
	  <div class="col-md-4">
	    <?= $form->field($model, 'status')->dropDownList($model->statusName) ?>
		<?= $form->field($model, 'category_id')->widget(Select2::classname(), [
			'data' => $model->categoryList,
			'options' => ['placeholder' => 'Родительская категория'],
			'pluginOptions' => [
				'allowClear' => true
			],			
		]); ?> 
		<?= $form->field($model, 'seourl')->textInput(['maxlength' => true]) ?>
		<?
			if(substr($model->image, 0, 4) == "http") {
			   $source = $model->image;
			} else {
			   $source = Image::resize($model->image, 213, 160);
			}
		?>
		<?= $form->field($model, 'image')->widget(FileInput::classname(), [
			'options' => ['accept' => 'image/*'],
			'pluginOptions' => [
				'showUpload' => false,
				'showDrag' => false,
				'initialPreview' => Html::img($source, ['alt' => $model->image, 'width' => 213]),
				'layoutTemplates' => [
                    'footer' => '',
                ],
				
			],
		]); ?>
		<div class="hidden d-none">
		  <?= $form->field($model, 'delimg')->textInput() ?>
		</div>
	  </div>
	</div>
  <?php ActiveForm::end(); ?>
</div>
<?php
$src = <<< JS
  $('#articleform-title').on('change', function() {
    if (confirm("Изменить поле SEOURL?")) {
	  $.ajax({
	    url: '/admin/category/translate',
	    data: {data : $(this).val()},
	    dataType: 'json',
	    success: function(json) {		
		  $('#articleform-seourl').val(json);
	    }
	  });
    }
  });
  $(document).on('click', '.fileinput-remove', function(){
	  $('#articleform-delimg').val('Y'); 
  });
JS;
$this->registerJs($src, yii\web\View::POS_READY);
?>