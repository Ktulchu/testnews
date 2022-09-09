<?php

?>

<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <?php echo \cebe\gravatar\Gravatar::widget(
            [
                'email' => 'username@example.com',
                'options' => [
                    'alt' => 'username',
                ],
                'size' => 64,
            ]
        ); ?>
    </div>
    <div class="pull-left info">
        <p><?= Yii::$app->user->identity->username;?></p>

        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>


<?php

// prepare menu items, get all modules
$menuItems = [];

$favouriteMenuItems[] = ['label' => 'MAIN NAVIGATION', 'options' => ['class' => 'header']];


$menuItems[] = [
    'url' => ['/admin/category'],
    'icon' => 'cog',
    'label' => 'Категории',
];

$menuItems[] = [
    'url' => ['/admin/articles'],
    'icon' => 'cog',
    'label' => 'Статьи',
];

$menuItems[] = [
    'url' => ['/admin/users'],
    'icon' => 'cog',
    'label' => 'Пользователи',
];



echo dmstr\widgets\Menu::widget([
    'items' => \yii\helpers\ArrayHelper::merge($favouriteMenuItems, $menuItems),
]);
?>
