<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Image;
use yii\bootstrap4\ActiveForm;
$this->title =  $model->title;
if(substr($model->image, 0, 4) == "http") {
   $source = $model->image;
} else {
   $source = Image::resize($model->image,670,466);
}
?>
<div class="container">
  <h1 class="h1 text-center pb-5"><?php echo $model->title;?></h1>
</div>
<div class="row">
	<div class="col-lg-8">
		<p class="w-100"><?= date('d.m.Y H:i:s', $model->updated_at);?> <a style="float:right" href="<?= Url::to($model->category->alias->url);?>"><?= $model->category->name;?></a></p>
		<img class="w-100 pb-5" src="<?= $source; ?>" alt="<?php echo $model->title;?>"/>
		<?= $model->content; ?>
	</div>
	<div class="col-lg-4">
		<?php $form = ActiveForm::begin(['id' => 'coment-form']); ?>
			<?= $form->field($coment, 'user')->textInput(['maxlength' => true]) ?>
			<?= $form->field($coment, 'coment')->textarea(['rows' => 3, 'cols' => 7]); ?>
			<?= Html::submitButton('Коментировать', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
		<?php ActiveForm::end(); ?>
		<? if($model->coments) : ?>
			<div class="mt-5">
				<h4>Последние коментарии</h4>
				<? foreach($model->coments as $user_coment) : ?>
					<div class="coment pb-5">
						<?= $user_coment->coment; ?>
						<div class="pt-3">
						<?= $user_coment->user; ?>
						<span style="float:right"><?= date('d.m.Y H:i', $user_coment->created_at); ?></span>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	
</div>