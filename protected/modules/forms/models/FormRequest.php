<?php

/**
 * This is the model class for table "form_requests".
 *
 * The followings are the available columns in table 'form_requests':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $subject
 * @property string $custom
 * @property string $utm
 * @property string $created_ip
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property ClubItems $club
 */
class FormRequest extends BaseActiveRecord
{
	public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'form_requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(
				'name, created_ip',
				'length',
				'max' => 300,
			),
			array(
				'email',
				'length',
				'max' => 200,
			),
            array(
                'subject',
                'length',
                'max' => 500,
            ),
			array(
				'phone',
				'length',
				'max' => 100,
			),
			array(
				'subject, created_datetime, utm, custom',
				'safe',
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array(
				'id, name, phone, subject, utm, created_ip, created_datetime',
				'safe',
				'on' => 'search'
			),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Fio',
			'phone' => 'Phone',
			'subject' => 'Description',
			'utm' => 'System Info',
            'custom' => 'Custom',
			'created_ip' => 'Created Ip',
			'created_datetime' => 'Created Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->fio, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('subject', $this->subject, true);
		$criteria->compare('utm', $this->system_info, true);
		$criteria->compare('created_ip', $this->created_ip, true);
		$criteria->compare('created_datetime', $this->created_datetime, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 50),
			'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
	}

	public function parseJson($string)
	{
	$result = '';

		if (CHelper::isJson($string)) {
			$array = json_decode($string, TRUE);

			if (count($array)) foreach ($array as $key => $value) {
				$result .= '<b>' . $key . '</b>' . ': ' . $value . '<br>';
			}
		} else {
			$result = $string;
		}
		return $result;
	}

	public function addRequestInAmoCrm($contact, $deal, $deal_note)
	{
		$result = Yii::app()->amocrm->ping();

        if ($result) {

            // $contact =  array(
            //     'person_name' => 'Фамилия Имя3',
            //     'contact_data' => array(
            //         'phone_numbers' => array(
            //             array('number' => '+7 499 891-01-11'),
            //             array('location' => 'Other')
            //         ),
            //         'email_addresses' => array(
            //             array('address' => 'mail@mail.ru'),
            //             array('location' => 'Other')
            //         ),
            //     ),
            // );

            $add_contact_result = Yii::app()->amocrm->addContact($contact);

            if (!empty($add_contact_result)) {

                $deal['linked_contact'] = $add_contact_result;

                // $deal = array(
                //     'name' => 'Заявка с сайта',
                //     // 'status_id' => 'ID статуса сделки',
                //     'linked_contact' => $add_contact_result,
                // );

                $add_deal_result = Yii::app()->amocrm->addDeal($deal);

                if (!empty($add_deal_result['result'])) {

                    $add_deal_note_result = Yii::app()->amocrm->addDealNote($add_deal_result['result'], $deal_note);
                }


            }
        }
	}

}
