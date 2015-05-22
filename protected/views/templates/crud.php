<?php $this->beginContent('core.views.layouts.main'); ?>
<div class="container">

    <?php if (isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        )); ?>
    <?php endif?>

    <div class="row">
        <div class="col-xs-8">
            <div>

                <?php $this->widget('TbAlert', array(
                    'block' => true,
                    'fade' => true,
                    'closeText' => '&times;',
                )); ?>

                <?php echo $content; ?>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="crud-sidebar" id="sidebar">
            <?php
                if (count($this->menu)) {
                    array_unshift($this->menu, array('itemOptions' => array('class' => 'header-label')));
                    $this->widget('TbMenu', array(
                        'items'=> $this->menu,
                    ));
                }
            ?>
            </div><!-- sidebar -->
        </div>
    </div>
</div>
<?php $this->endContent(); ?>