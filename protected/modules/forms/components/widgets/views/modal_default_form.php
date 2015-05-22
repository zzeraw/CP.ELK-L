<a href="#modal<?=$form_widget_id?>" data-toggle="modal" data-target="#modal<?=$form_widget_id?>" class="<?=$button_class?>">
<?=(!empty($button_icon)) ? '<span class="' . $button_icon . '"></span> ' : '' ?><?=$button_text?>
</a>

<?php ob_start(); ?>

<div class="modal fade" id="modal<?=$form_widget_id?>" tabindex="-1" role="dialog" aria-labelledby="modal<?=$form_widget_id?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modal<?=$form_widget_id?>Label"><?=$form_caption?></h4>
        </div>

        <div class="modal-body">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => $form_widget_id,
                'action' => $form_model->setFormActionUrl(get_class($form_model), $email_subject),
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validationUrl' => $form_model->setFormValidationUrl($form_widget_id, get_class($form_model)),
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
                            'placeholder' => 'Введите номер телефона',
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
                            'placeholder' => 'Введите почту',
                            'type' => 'email',
                        )
                    );?>
                    <?=$form->error($form_model, 'email');?>
                </div>

                <?=$form->hiddenField(
                    $form_model,
                    'item',
                    array(
                        'class' => 'hidden-input-field',
                        'value' => $form_item,
                    )
                );?>

                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-group">
                            <?=CHtml::submitButton(
                                $form_button_text,
                                array(
                                    'id' => 'submit' . $form_widget_id,
                                    'class' => $form_button_class,
                                    'style' => 'width: 100%',
                                    'data-item' => '',
                                )
                            );?>
                        </div>
                    </div>
                    <div class="col-xs-8">
                        <p class="garanty">Гарантируем, что ваши данные не будут переданы 3-м лицам и не будут использоваться в СПАМ рассылках.</p>
                    </div>
                </div>

            <?php $this->endWidget(); ?>

        </div>


        </div>
    </div>
</div>


<?php $this->render('_modalStatusWindows', array('form_widget_id' => $form_widget_id)); ?>


<?php

Yii::app()->getController()->buffer[] = ob_get_contents();
ob_end_clean();

?>