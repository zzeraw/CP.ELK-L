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
        'class' => $form_class,
        'role' => 'form',
    ),
)); ?>


    <?php echo CHtml::hiddenField('email_subject' , $email_subject, array('id' => 'AjaxFormEmailSubjectHiddenInput' . $form_widget_id)); ?>
    <?php echo CHtml::hiddenField('form_item' , $form_item, array('id' => 'AjaxFormItemHiddenInput' . $form_widget_id)); ?>
    <?php echo CHtml::hiddenField('fields' , $fields, array('id' => 'AjaxFormFieldsHiddenInput' . $form_widget_id)); ?>


    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <?=$form->labelEx(
                    $form_model,
                    'name'
                );?>
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
                <?=$form->labelEx(
                    $form_model,
                    'phone'
                );?>
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
                <?=$form->labelEx(
                    $form_model,
                    'email'
                );?>
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
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <?=$form->labelEx(
                    $form_model,
                    'comment'
                );?>
                <?=$form->textArea(
                    $form_model,
                    'comment',
                    array(
                        'class' => 'form-control',
                        'placeholder' => (isset($html_options['comment']['placeholder'])) ? $html_options['comment']['placeholder'] : '',
                    )
                );?>
                <?=$form->error($form_model, 'comment');?>
            </div>

            <button type="submit" class="btn btn-danger btn-lg btn-submit" id="" <?=$form_button_event?>>Отправить заявку</button>
        </div>
    </div>

<?php $this->endWidget(); ?>

<?php $this->render('_modalStatusWindows', array('form_widget_id' => $form_widget_id)); ?>