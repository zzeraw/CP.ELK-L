<?php

$this->pageTitle = Yii::app()->name . ' - ' . 'Создать блок';

$this->breadcrumbs = array(
    'Блоки' => array('index'),
    'Создать блок',
);

$this->menu = array(
    array(
        'label' => 'Список блоков',
        'icon' => 'list',
        'url' => array('index')
    ),
);
?>

<h1>Создать блок</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>