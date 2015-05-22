<?php

class OrderForm extends BaseFormModel
{
    public $fio;
    public $phone;
    public $email;
    public $item;
    public $comment;

    public $files;

    public function rules()
    {
        return array(
            array(
                'fio, phone, email',
                'required',
            ),
            array(
                'email',
                'email',
            ),
            array(
                'fio, email',
                'length',
                'max' => 100,
            ),
            array(
                'phone',
                'length',
                'max' => 20,
            ),
            array(
                'item',
                'length',
                'max' => 400,
            ),
            array(
                'comment',
                'length',
                'max' => 500,
            ),
            array(
                'files', 'safe',
            ),
            // array(
            //     'file',
            //     'file',
            //     'types' => 'pdf, zip, rar, xls, xlsx, doc, docx, txt, jpg, odt, ods, odp',
            //     'maxSize' => 5 * 1024 * 1024,
            //     'allowEmpty' => true,
            // ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'fio' => 'Ф.И.О.',
            'phone' => 'Телефон',
            'email' => 'Email',
            'item' => 'Группа каталога',
            'comment' => 'Комментарий',
            'files' => 'Файлы',
        );
    }

    public function send()
    {
        $from = Yii::app()->params['fromEmail'];
        $email = Yii::app()->params['managerEmail'];

        $subject = $this->email_subject;

        $message = $this->email_subject . '<br><br>';

        $message .= $this->item . '<br>';

        $message .= $this->getAttributeLabel('fio') . ': ' . $this->fio . '<br>';
        $message .= $this->getAttributeLabel('phone') . ': ' . $this->phone . '<br>';
        $message .= $this->getAttributeLabel('email') . ': ' . $this->email . '<br>';

        $message .= '<br>';

        $message .= $this->getAttributeLabel('comment') . ': ' . $this->comment . '<br>';

        if (!empty($this->files)) {

            $message .= 'ПЕРЕД ОТКРЫТИЕМ ПРОВЕРЯЙТЕ ФАЙЛЫ АНТИВИРУСОМ!!! <br>';

            $message .= $this->getAttributeLabel('files') . ': ';

            $files = explode(';', $this->files);
            foreach ($files as $file) {
                $message .= 'http://nku.biz/uploads/users_uploads/' . $file . ' <br>';
            }
        }

        $message .= '<br>';

        $db = new FormRequest;

        $db->fio = $this->fio;
        $db->phone = $this->phone;
        $db->email = $this->email;
        $db->description = json_encode(
            array(
                'subject' => $this->email_subject,
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
                'name' => $this->email_subject . '. ' . $this->item . ' (' . date('Y-m-d H:i:s') . ')',
                'status_id' => '8310890',
                'linked_contact' => $add_contact_result,
            );

            $deal_note = $db->parseJson($db->description) . '; ' . $db->system_info;

            $db->addRequestInAmoCrm($contact, $deal, $deal_note);
        }

        return SendMail::sendEmail($from, $email, $subject, $message);
    }

    public function setFieldValue($field_name, $values_array)
    {
        if (isset($values_array[$field_name])) {
            return $values_array[$field_name];
        }
    }

}