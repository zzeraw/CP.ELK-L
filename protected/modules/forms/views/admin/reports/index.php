<?php
/* @var $this PageController */
/* @var $model Page */

$this->pageTitle = Yii::app()->name . ' - ' . 'Список заявок';

$this->breadcrumbs = array(
    'Заявки' => array('index'),
    'Список заявок',
);


?>

<h1>Список заявок</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'form-request-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'table table-striped',
    'selectableRows' => 0,
    'columns' => array(
        'id',
        'created_datetime',
        'fio',
        'phone',
        'email',
        array(
            'name' => 'description',
            'type' => 'html',
            'value' => '$data->parseJson($data->description)',
        ),
        array(
            'name' => 'system_info',
            'type' => 'html',
            'value' => '$data->parseJson($data->system_info)',
        ),
    ),
)); ?>
