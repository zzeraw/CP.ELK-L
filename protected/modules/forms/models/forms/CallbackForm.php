<?php

class CallbackForm extends BaseFormModel
{
    public $fio;
    public $phone;
    public $comment;

    public $email_subject = 'С сайта www.nku.biz поступила заявка на обратный звонок';

    public function rules()
    {
        return array(
            array(
                'fio, phone',
                'required',
            ),
            array(
                'fio',
                'length',
                'max' => 100,
            ),
            array(
                'phone',
                'length',
                'max' => 20,
            ),
            array(
                'comment',
                'length',
                'max' => 500,
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'fio' => 'Ф.И.О.',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
        );
    }

    public function send()
    {
        $from = Yii::app()->params['fromEmail'];
        $email = Yii::app()->params['managerEmail'];

        $subject = $this->email_subject;

        $message = $this->email_subject . '<br><br>';

        $message .= $this->getAttributeLabel('fio') . ': ' . $this->fio . '<br>';
        $message .= $this->getAttributeLabel('phone') . ': ' . $this->phone . '<br>';

        $message .= '<br>';

        $message .= $this->getAttributeLabel('comment') . ': ' . $this->comment . '<br>';

        $db = new FormRequest;

        $db->fio = $this->fio;
        $db->phone = $this->phone;
        $db->description = json_encode(array('subject' => $this->email_subject, 'comment' => $this->comment));
        $db->system_info = Yii::app()->session['utm_session'];

        if ($db->save()) {
            $contact =  array(
                'person_name' => $this->fio,
                'contact_data' => array(
                    'phone_numbers' => array(
                        array('number' => $this->phone),
                        array('location' => 'Other')
                    ),
                ),
            );

            $deal = array(
                'name' => $this->email_subject . ' (' . date('Y-m-d H:i:s') . ')',
                'status_id' => '8310890',
                'linked_contact' => $add_contact_result,
            );

            $deal_note = $db->parseJson($db->description) . '; ' . $db->system_info;

            $db->addRequestInAmoCrm($contact, $deal, $deal_note);
        }

        return SendMail::sendEmail($from, $email, $subject, $message);
    }

}