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

        // $result = $db->save();
        if ($db->save()) {
            $contact = array();
            $contact['main_user_id'] = '501759';

            if (isset($db->name)) {
                $contact['person_name'] = $db->name;
            }
            if (isset($db->phone)) {
                $contact['contact_data']['phone_numbers'] = array(
                    array('number' => $db->phone),
                    array('location' => 'Other')
                );
            }
            if (isset($db->email)) {
                $contact['contact_data']['email_addresses'] = array(
                    array('address' => $db->email),
                    array('location' => 'Other')
                );
            }

            $deal = array(
                'name' => $email_subject . ' (' . date('Y-m-d H:i:s') . ')',
                'status_id' => '8310890',
                'linked_contact' => '',
                'main_user_id' => $contact['main_user_id'],
            );

            $deal_note = $db->parseJson($db->custom);


            $db->addRequestInAmoCrm($contact, $deal, $deal_note);
        }

        return SendMail::sendEmail($from, $email, $subject, $message);
    }

}