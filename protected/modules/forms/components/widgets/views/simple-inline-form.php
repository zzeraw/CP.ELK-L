<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => $form_widget_id,
    'action' => $form_model->setFormActionUrl(),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validationUrl' => $form_model->setFormValidationUrl($form_widget_id),
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'afterValidate' => $form_model->setFormAfterValidateScript($form_widget_id),
    ),
    'htmlOptions' => array(
        'class' => 'form-inline',
        'role' => 'form',
    ),
)); ?>

    <?php echo CHtml::hiddenField('email_subject' , $email_subject, array('id' => 'AjaxFormEmailSubjectHiddenInput' . $form_widget_id)); ?>
    <?php echo CHtml::hiddenField('form_item' , $form_item, array('id' => 'AjaxFormItemHiddenInput' . $form_widget_id)); ?>
    <?php echo CHtml::hiddenField('fields' , $fields, array('id' => 'AjaxFormFieldsHiddenInput' . $form_widget_id)); ?>


    <div class="form-group">
        <?=$form->textField(
            $form_model,
            'name',
            array(
                'class' => 'form-control',
                'placeholder' => (isset($html_options['name']['placeholder'])) ? $html_options['name']['placeholder'] : '',
                'type' => 'text',
            )
        );?>
        <?=$form->error($form_model, 'name');?>
    </div>
    <div class="form-group">
        <?=$form->textField(
            $form_model,
            'phone',
            array(
                'class' => 'form-control',
                'placeholder' => (isset($html_options['phone']['placeholder'])) ? $html_options['phone']['placeholder'] : '',
                'type' => 'phone',
            )
        );?>
        <?=$form->error($form_model, 'phone');?>
    </div>
    <div class="form-group">
        <?=$form->textField(
            $form_model,
            'email',
            array(
                'class' => 'form-control',
                'placeholder' => (isset($html_options['email']['placeholder'])) ? $html_options['email']['placeholder'] : '',
                'type' => 'email',
            )
        );?>
        <?=$form->error($form_model, 'email');?>
    </div>

    <button type="submit" class="<?=$form_button_class?>" id="" <?=$form_button_event?>>Отправить заявку</button>

<?php $this->endWidget(); ?>

<?php $this->render('_modalStatusWindows', array('form_widget_id' => $form_widget_id)); ?>