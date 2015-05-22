<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

    <?php $this->widget('LoadBlockWidget', array('alias' => 'header')); ?>

    <?php echo $content; ?>

    <?php $this->widget('LoadBlockWidget', array('alias' => 'footer')); ?>

<?php $this->endContent(); ?>