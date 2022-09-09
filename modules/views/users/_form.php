<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
  <?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
	  <div class="row">
	    <div class="col-md-4">
	      <?= $form->field($model, 'username')->textInput() ?>
		  <?= $form->field($model, 'email')->textInput() ?>
	    </div>
	    <div class="col-md-4">
	      <?= $form->field($model, 'status')->dropDownList($model->statusName) ?>
		  <?= $form->field($model, 'role')->dropDownList($model->roleName);?>
	    </div>
		<div class="col-md-4">
		  <?= $form->field($model, (isset($model->id)) ? 'passwordnew' : 'password')->textInput(); ?>
		</div>
	  </div>
    <?php ActiveForm::end(); ?>
</div>
