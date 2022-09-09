<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">
	<?php $form = ActiveForm::begin(['id' => 'category-form']); ?>
		<div class="row">
			<div class="col-md-6">
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'seourl')->textInput(['maxlength' => true]) ?>
			</div>
			<div class="col-md-6">
				<?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
					'data' => $model->parentsList,
					'options' => ['placeholder' => 'Родительская категория'],
					'pluginOptions' => [
						'allowClear' => true
					],			
				]); ?>
				<?= $form->field($model, 'status')->dropDownList($model->statusName) ?>
			</div>
		</div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$src = <<< JS
  $('#category-name').on('change', function() {
    if (confirm("Изменить поле SEOURL?")) {
	  $.ajax({
	    url: '/admin/category/translate',
	    data: {data : $(this).val()},
	    dataType: 'json',
	    success: function(json) {		
		  $('#category-seourl').val(json);
	    }
	  });
    }
  });
JS;
$this->registerJs($src, yii\web\View::POS_READY);
?>
