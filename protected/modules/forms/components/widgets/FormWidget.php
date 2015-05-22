<?php

/**
 *
 */
class FormWidget extends CWidget
{
    public $form_caption = '';
    public $form_description = 'Заполните эту форму, и наш специалист с вами свяжется';

    public $form_notice = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure exercitationem, aperiam, dolorem fugiat odio temporibus saepe eius distinctio, deleniti ab, consequuntur tempora praesentium facilis quae eos vero hic ex placeat?';
    public $form_class = 'default-form-class';
    public $form_item = 'Заполнена форма обратной связи';

    public $form_button_text = 'Отправить';
    public $form_button_class = 'btn btn-primary';

    public $button_text = 'Оставить заявку';
    public $button_class = 'btn btn-primary';
    public $button_icon = '';

    public $template_name = 'modal_default_form';

    public $fields = array();
    public $fields_default_values = array();

    public $email_subject = 'Поступила заявка с сайта';

    public function run()
    {
        $fields = json_decode($this->fields, true);

        // $fields = array(
        //     array(
        //         'type' => 'text',
        //         'name' => 'name',
        //         'label' => 'Ф.И.О.',
        //         'value' => '',
        //         'validation' => array(
        //             'required',
        //             'min:3',
        //             'max:300',
        //         ),
        //         'html' => array(
        //             'class' => 'form-control',
        //             'placeholder' => 'Пожалуйста, представьтесь',
        //         ),
        //     ),
        //     array(
        //         'type' => 'text',
        //         'name' => 'age',
        //         'label' => 'Возраст',
        //         'value' => '',
        //         'validation' => array(
        //             'required',
        //             'integer',
        //         ),
        //         'html' => array(
        //             'class' => 'form-control',
        //             'placeholder' => 'Ваш возраст',
        //         ),
        //     ),
        //     array(
        //         'type' => 'text',
        //         'name' => 'phone',
        //         'label' => 'Телефон',
        //         'value' => '',
        //         'validation' => array(
        //             'required',
        //             'min:3',
        //             'max:11',
        //         ),
        //         'html' => array(
        //             'class' => 'form-control',
        //             'placeholder' => 'Оставьте номер телефона',
        //         ),
        //     ),
        //     array(
        //         'type' => 'text',
        //         'name' => 'email',
        //         'label' => 'E-mail',
        //         'value' => '',
        //         'validation' => array(
        //             'required',
        //             'min:3',
        //             'max:100',
        //             'email',
        //         ),
        //         'html' => array(
        //             'class' => 'form-control',
        //             'placeholder' => 'Оставьте ваш E-mail',
        //         ),
        //     ),
        //     array(
        //         'type' => 'file',
        //         'name' => 'documents',
        //         'label' => 'Документация',
        //         'value' => '',
        //         'validation' => array(
        //             'min_size:1024',
        //             'max_size:' . (1024 * 5),
        //             'types:pdf,doc,docx',
        //         ),
        //         'html' => array(
        //             'class' => 'form-control',
        //             'placeholder' => 'Приложите файлы документации',
        //         ),
        //     ),
        //     array(
        //         'type' => 'textarea',
        //         'name' => 'comment',
        //         'label' => 'Комментарий',
        //         'value' => '',
        //         'validation' => array(

        //         ),
        //         'html' => array(
        //             'class' => 'form-control',
        //             'placeholder' => 'Укажите всю дополнительную информацию',
        //         ),
        //     ),
        // );

        $model = new AjaxFormModel;

        $prepare_rules = array();
        $html_options = array();

        foreach ($fields as $field) {

            if (isset($field['html'])) {
                $html_options[$field['name']] = $field['html'];
            }

            if ($field['type'] == 'file') {
                $file_rules[$field['name']] = array();
                foreach ($field['validation'] as $rule) {
                    // $file_rules = array();

                    if (substr($rule, 0, 6) == 'types:') {
                        $explode = explode(':', $rule);
                        if (isset($rule[1])) {
                            $file_rules[$field['name']]['types'] = $explode[1];
                        }
                    }
                    if (substr($rule, 0, 9) == 'max_size:') {
                        $explode = explode(':', $rule);
                        if (isset($rule[1])) {
                            $file_rules[$field['name']]['maxSize'] = $explode[1];
                        }
                    }
                    if (substr($rule, 0, 9) == 'min_size:') {
                        $explode = explode(':', $rule);
                        if (isset($rule[1])) {
                            $file_rules[$field['name']]['minSize'] = $explode[1];
                        }
                    }

                    if ($rule == 'required') {
                        $file_rules[$field['name']]['allowEmpty'] = false;
                    } else {
                        $file_rules[$field['name']]['allowEmpty'] = true;
                    }
                }

                $prepare_rules['file'] = $file_rules;
            } else {
                foreach ($field['validation'] as $rule) {
                    if ($rule == 'required') {
                        $prepare_rules['required'][] = $field['name'];
                    }
                    if ($rule == 'integer') {
                        $prepare_rules['integer'][] = $field['name'];
                    }
                    if ($rule == 'email') {
                        $prepare_rules['email'][] = $field['name'];
                    }
                    if (substr($rule, 0, 4) == 'min:') {
                        $explode = explode(':', $rule);
                        if (isset($rule[1])) {
                            $prepare_rules['length'][$field['name']]['min'] = $explode[1];
                        }
                    }
                    if (substr($rule, 0, 4) == 'max:') {
                        $explode = explode(':', $rule);
                        if (isset($rule[1])) {
                            $prepare_rules['length'][$field['name']]['max'] = $explode[1];
                        }
                    }
                }
            }
        }

        $rules = array();
        foreach ($prepare_rules as $validator => $rule) {
            if ($validator == 'required') {
                $rules[] = array(implode(',', $rule), 'required');
            }

            if ($validator == 'length') {
                foreach ($rule as $field_name => $length) {
                    $r = array($field_name, 'length');

                    if (isset($length['min'])) {
                        $r['min'] = $length['min'];
                    }
                    if (isset($length['max'])) {
                        $r['max'] = $length['max'];
                    }
                    $rules[] = $r;
                }
            }

            if ($validator == 'integer') {
                $rules[] = array(implode(',', $rule), 'numerical', 'integerOnly' => true);
            }

            if ($validator == 'email') {
                $rules[] = array(implode(',', $rule), 'email');
            }
        }

        $model->setDynamicFields($fields);
        $model->setDynamicRules($rules);

        $fields_array = $model->getFieldsArray($fields);

        if (isset($_POST['DynamicFormModel'])) {
            $model->attributes = $_POST['DynamicFormModel'];

            if ($model->validate()) {

            } else {
                var_dump($model->getErrors());
            }

        }

        $form_widget_id = $this->genegateWidgetId('FormWidget');

        // var_dump($html_options);

        $this->render(
            $this->template_name,
            array(
                'form_model' => $model,

                'form_caption' => $this->form_caption,
                'form_description' => $this->form_description,
                'form_notice' => $this->form_notice,
                'form_class' => $this->form_class,
                'form_item' => $this->form_item,
                'form_button_text' => $this->form_button_text,
                'form_button_class' => $this->form_button_class,
                'button_text' => $this->button_text,
                'button_class' => $this->button_class,
                'button_icon' => $this->button_icon,

                'fields_default_values' => $this->fields_default_values,

                'form_widget_id' => $form_widget_id,
                'email_subject' => $this->email_subject,
                'html_options' => $html_options,

                'fields' => json_encode($fields_array),
            )
        );
    }



    public function genegateWidgetId($string = '')
    {
        $widget_id = $string . md5(time() . rand(1, 9999999));

        return $widget_id;
    }

    protected function _parseFields($fields)
    {

    }

    protected function _parseRules($fields)
    {

    }

}