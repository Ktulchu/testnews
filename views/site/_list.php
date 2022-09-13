<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\Image;
use app\models\Alias;

if(substr($model->image, 0, 4) == "http") {
   $source = $model->image;
} else {
   $source = Image::resize($model->image,670,466);
}
?>

<div class="col-lg-4 col-md-4 col-sm-6 pb-5">
	<h4><?php echo $model->title;?></h4>	
	<a href="<?php echo Url::to($model->alias->url);?>">
	  <img class="w-100 r-12 anim fadeInLeft" src="<?= $source; ?>" alt="<?php echo $model->title;?>"/>
	</a>
	<p><?= $model->announcement; ?></p>
	<a class="btn btn-primary" href="<?= Url::to($model->alias->url);?>">Подробнее</a>
</div>
