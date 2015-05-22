<?php

$this->pageTitle = Yii::app()->name . ' - ' . 'Список блоков';

$this->breadcrumbs=array(
    'Блоки' => array('index'),
    'Список блоков',
);

$this->menu = array(
    array(
        'label' => 'Добавить блок',
        'icon'  => 'plus',
        'url'   => array('create')
    ),
);

?>

<h1>Список блоков</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'blocks-grid',
    'dataProvider' => $model->search(),
    'selectableRows' => 0,
    'enablePagination' => false,
    'summaryText' => false,
    'itemsCssClass' => 'table table-striped',
    'columns' => array(
        array(
            'class' => 'DataColumn',
            'evaluateHtmlOptions' => true,
            'type' => 'html',
            'htmlOptions' => array(
                'class' => '($data->active == 1) ? "td-active" : "td-inactive"',
                'title' => '($data->active == 1) ? "Выключить" : "Включить"',
            ),
            'value' => 'CHtml::link(($data->active == 1) ? "<span class=\'glyphicon glyphicon-off\'></span>" : "<span class=\'glyphicon glyphicon-play\'></span>", array(($data->active == 1) ? "turnOff" : "turnOn", "id" => $data->id))',
        ),
        'id',
        array(
            'name' => 'title',
            'type' => 'html',
            'value' => 'CHtml::link(CHtml::encode($data->title), array("update", "id" => $data->id))',
        ),
        'alias',
    ),
)); ?>
