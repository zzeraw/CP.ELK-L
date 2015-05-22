<?php

$this->pageTitle = Yii::app()->name . ' - ' . 'Создать страницу';

$this->breadcrumbs = array(
    'Страницы' => array('index'),
	'Создать новую',
);

$this->menu = array(
    array(
        'label' => 'Список страниц',
        'icon' => 'list',
        'url' => array('index')
    ),
);
?>

<h1>Создать страницу</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>