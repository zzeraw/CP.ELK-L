<?php

/**
 * This is the model class for table "blocks".
 *
 * The followings are the available columns in table 'blocks':
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $body
 * @property string $created_ip
 * @property string $created_datetime
 * @property integer $created_user
 * @property string $created_username
 * @property string $modified_ip
 * @property string $modified_datetime
 * @property integer $modified_user
 * @property string $modified_username
 * @property integer $active
 */
class Block extends BaseActiveRecord
{
	public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors(){
        return array(
            'BSystemInfoBehavior' => array(
                'class' => 'BSystemInfoBehavior',
            ),
        );
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blocks';
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
				'alias, title',
				'required',
			),
			array(
				'created_user, modified_user, active',
				'numerical',
				'integerOnly' => true,
			),
			array(
				'alias, created_username',
				'length',
				'max' => 200,
			),
			array(
				'title, created_ip, modified_ip, modified_username',
				'length',
				'max' => 300,
			),
			array(
				'title, alias, body',
				'safe',
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array(
				'id, alias, title, body, created_ip, created_datetime, created_user, created_username, modified_ip, modified_datetime, modified_user, modified_username, active',
				'safe',
				'on' => 'search',
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
			'alias' => 'Alias',
			'title' => 'Title',
			'body' => 'Body',
			'created_ip' => 'Created Ip',
			'created_datetime' => 'Created Date',
			'created_user' => 'Created User',
			'created_username' => 'Created Username',
			'modified_ip' => 'Modified Ip',
			'modified_datetime' => 'Modified Date',
			'modified_user' => 'Modified User',
			'modified_username' => 'Modified Username',
			'active' => 'Active',
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
		$criteria->compare('alias', $this->alias, true);
		$criteria->compare('title' ,$this->title, true);
		$criteria->compare('body', $this->body, true);
		$criteria->compare('created_ip', $this->created_ip, true);
		$criteria->compare('created_datetime', $this->created_datetime, true);
		$criteria->compare('created_user', $this->created_user);
		$criteria->compare('created_username', $this->created_username, true);
		$criteria->compare('modified_ip', $this->modified_ip, true);
		$criteria->compare('modified_datetime', $this->modified_datetime, true);
		$criteria->compare('modified_user', $this->modified_user);
		$criteria->compare('modified_username', $this->modified_username, true);
		$criteria->compare('active', $this->active);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 50),
			'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
        ));
	}

	public function findCommonLastModifiedDate()
    {
        return Yii::app()->db->createCommand("SELECT MAX(`modified_datetime`) FROM {{" . $this->tableName() . "}} WHERE `alias` = 'header' OR `alias` = 'footer'")->queryScalar();
    }
}
