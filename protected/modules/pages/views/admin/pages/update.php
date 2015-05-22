<?php

$this->pageTitle = Yii::app()->name . ' - ' . 'Редактировать страницу "' . $model->title . '"';

$this->breadcrumbs = array(
    'Страницы' => array('index'),
    '"' . $model->title . '"' => array('update', 'id'=>$model->id),
);

$this->menu = array(
    array(
        'label' => 'Список страниц',
        'icon' => 'list',
        'url' => array('index')
    ),
    array(
        'label' => 'Создать страницу',
        'icon' => 'plus',
        'url' => array('create')
    ),
    array(
        'label' => ($model->active == 1) ? 'Выключить страницу' : 'Включить страницу',
        'icon' => ($model->active == 1) ? 'icon-off' : 'icon-ok',
        'url' => ($model->active == 1) ? array('turnOff', 'id' => $model->id) : array('turnOn', 'id' => $model->id)
    ),

    array(
        'label' => 'Удалить страницу',
        'icon' => 'remove',
        'url' => array('delete', 'id' => $model->id),
        'htmlOptions' => array(
            'confirm' => 'Вы действительно хотите удалить эту страницу (' . $model->title . ')?'
        ),
    ),
);

?>

<h1>Редактировать страницу "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
