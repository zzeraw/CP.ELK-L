<?php

$this->pageTitle = Yii::app()->name . ' - ' . 'Редактировать блок "' . $model->title . '"';

$this->breadcrumbs = array(
    'Блоки' => array('index'),
    '"' . $model->title . '"' => array('update', 'id'=>$model->id),
);

$this->menu = array(
    array(
        'label' => 'Список блоков',
        'icon'  => 'list',
        'url'   => array('index')
    ),
    array(
        'label' => 'Создать блок',
        'icon'  => 'plus',
        'url'   => array('create')
    ),
    array(
        'label' => ($model->active == 1) ? 'Выключить блок' : 'Включить блок',
        'icon'  => ($model->active == 1) ? 'icon-off' : 'icon-ok',
        'url'   => ($model->active == 1) ? array('turnOff', 'id' => $model->id) : array('turnOn', 'id' => $model->id)
    ),
);

?>

<h1>Редактировать блок "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>