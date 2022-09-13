<?php
use yii\helpers\Html;
use yii\helpers\Url;
function view_cat($array)
{
	echo '<ul>';
	foreach($array['chailds'] as $chaild)
	{
		echo '<li class="nav-item"><a class="nav-link"'. url::to($chaild['url']) .'">'. $chaild['name'] .'</a></li>';
		if(isset( $chaild['chailds'])) view_cat( $chaild );
	}
	echo '</ul>';
}
?>
<h2>Категории новостей</h2>
<ul class="nav">
	<?php foreach ($models as $model) : ?>
		<li class="nav-item"> 
			<a class="nav-link" href="<?php echo url::to($model['url']); ?>"><?php echo $model['name']; ?> </a>	
			<?php if(isset($model['chailds'])) : ?>
			
				<?= view_cat($model, $model['id']); ?>
				
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>


