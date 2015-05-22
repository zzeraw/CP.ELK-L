<?php

class AjaxFormModel extends DynamicFormModel
{
    public function setFormValidationUrl($form_widget_id)
    {
        return Yii::app()->createUrl("forms/ajax/formValidation", array('widget_id' => $form_widget_id));
    }

    public function setFormActionUrl()
    {
        return Yii::app()->createUrl('forms/ajax/sendFormToEmail');
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

                                //form[0].reset();

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

    public function setFieldValue($field_name, $values_array)
    {
        if (isset($values_array[$field_name])) {
            return $values_array[$field_name];
        }
    }

    public function send($attributes, $fields, $form_item, $email_subject)
    {
        $from = Yii::app()->params['fromEmail'];
        $email = Yii::app()->params['managerEmail'];

        $subject = $email_subject;

        $message = $email_subject . '<br><br>';
        $message .= $form_item . '<br>';

        foreach ($fields as $name => $label) {
            if (isset($attributes[$name])) {
                $message .= $label . ': ' . $attributes[$name] . '<br>';
            }
        }

        $db = new FormRequest;
        $custom = '';
        foreach ($fields as $name => $label) {
            if ( ($name == 'name') && (isset($attributes[$name])) ) {
                $db->name = $attributes[$name];
            } elseif ( ($name == 'phone') && (isset($attributes[$name])) ) {
                $db->phone = $attributes[$name];
            } elseif ( ($name == 'email') && (isset($attributes[$name])) ) {
                $db->email = $attributes[$name];
            } else {
                if (isset($attributes[$name])) {
                    $custom .= $label . ': ' . $attributes[$name] . '; ';
                }
            }
        }
        $db->custom = $custom;
        $db->subject = $email_subject;

        $db->created_ip = Yii::app()->request->getUserHostAddress() . ' ' . Yii::app()->request->getUserAgent();
        $db->created_datetime = date('Y-m-d H:i:s');

        $result = $db->save();

        return SendMail::sendEmail($from, $email, $subject, $message);
    }

    public function send1()
    {
        $email_subject = 123;

        $from = Yii::app()->params['fromEmail'];
        $email = Yii::app()->params['managerEmail'];

        $subject = $email_subject;

        $message = $email_subject . '<br><br>';

        $message .= $this->item . '<br>';

        $message .= $this->getAttributeLabel('fio') . ': ' . $this->fio . '<br>';
        $message .= $this->getAttributeLabel('phone') . ': ' . $this->phone . '<br>';
        $message .= $this->getAttributeLabel('email') . ': ' . $this->email . '<br>';

        $message .= '<br>';

        $message .= $this->getAttributeLabel('comment') . ': ' . $this->comment . '<br>';

        $message .= '<br>';

        $db = new FormRequest;

        $db->fio = $this->fio;
        $db->phone = $this->phone;
        $db->email = $this->email;
        $db->description = json_encode(
            array(
                'subject' => $email_subject,
                'item' => $this->item,
                'comment' => $this->comment,
            )
        );
        $db->system_info = Yii::app()->session['utm_session'];

        if ($db->save()) {
            $contact =  array(
                'person_name' => $this->fio,
                'contact_data' => array(
                    'phone_numbers' => array(
                        array('number' => $this->phone),
                        array('location' => 'Other')
                    ),
                    'email_addresses' => array(
                        array('address' => $this->email),
                        array('location' => 'Other')
                    ),
                ),
            );

            $deal = array(
                'name' => $email_subject . '. ' . $this->item . ' (' . date('Y-m-d H:i:s') . ')',
                'status_id' => '8310890',
                'linked_contact' => $add_contact_result,
            );

            $deal_note = $db->parseJson($db->description) . '; ' . $db->system_info;

            $db->addRequestInAmoCrm($contact, $deal, $deal_note);
        }

        return SendMail::sendEmail($from, $email, $subject, $message);
    }

}