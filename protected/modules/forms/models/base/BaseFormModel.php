<?php

class BaseFormModel extends CFormModel
{
    public $email_subject = 'С сайта www.nku.biz поступила заявка';

    public function setFormValidationUrl($form_widget_id, $model_name)
    {
        return Yii::app()->createUrl("forms/ajax/formValidation", array('widget_id' => $form_widget_id, 'model_name' => $model_name));
    }

    public function setFormActionUrl($model_name, $email_subject)
    {
        return Yii::app()->createUrl('forms/ajax/sendFormToEmail', array('model_name' => $model_name, 'subject' => $email_subject));
    }

    public function setFormAfterValidateScript($form_widget_id)
    {
        return "js: function(form, data, hasError) {

                    if ( !hasError ) {

                        var myTime = new Date();

                        var ajaxData = $( form ).serializeArray();
                        ajaxData.push({name: 'clientDatetime', value: myTime.toUTCString()});

                        $.ajax( {
                            type: 'POST',
                            url: form[0].action,
                            data: ajaxData,
                            dataType: 'json',
                            success: function( response ) {

                                $( '#modalSuccess" . $form_widget_id . " .message' ).html( response.message );

                                form[0].reset();

                                $.fancybox({
                                    closeBtn: true,
                                    href: '#modalSuccess" . $form_widget_id . "',
                                    type: 'inline'
                                });

                                setTimeout( function() {
                                    $.fancybox.close();
                                }, 3000000);

                            },
                            error: function( jqXHR, textStatus, errorThrown ) {
                                $( '#modalError" . $form_widget_id . " .message' ).html( jqXHR.responseText );

                                form[0].reset();

                                $.fancybox({
                                    closeBtn: true,
                                    href: '#modalError" . $form_widget_id . "',
                                    type: 'inline'
                                });

                                setTimeout( function() {
                                    $.fancybox.close({
                                        href: '#modalError" . $form_widget_id . "'
                                    });
                                }, 3000);
                            }
                        } );
                    }

                    return false;

                }";
    }
}

?>