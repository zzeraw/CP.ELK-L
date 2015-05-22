<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    // 'id' => $form_widget_id,
    // 'action' => $form_model->setFormActionUrl(get_class($form_model), $form_model->email_subject),
    // 'enableAjaxValidation' => true,
    // 'enableClientValidation' => true,
    'clientOptions' => array(
        // 'validationUrl' => $form_model->setFormValidationUrl($form_widget_id, get_class($form_model)),
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        // 'afterValidate' => $form_model->setFormAfterValidateScript($form_widget_id),
    ),
    'htmlOptions' => array(
        // 'class' => $form_class,
        'role' => 'form',
    ),
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

    <?php echo $form->errorSummary($form_model); ?>

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
                    'placeholder' => 'Введите Ф.И.О.',
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
                    'placeholder' => 'Введите номер телефона',
                    'type' => 'phone',
                )
            );?>
            <?=$form->error($form_model, 'phone');?>
        </div>
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
                    'placeholder' => 'Введите комментарий',
                )
            );?>
            <?=$form->error($form_model, 'comment');?>
        </div>

    <div class="buttons">
        <?php echo CHtml::submitButton('Сохранить', array('class' => 'btn btn-primary')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

