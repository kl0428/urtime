<?php

/**
 * This is the model class for table "{{yhm_city}}".
 *
 * The followings are the available columns in table '{{yhm_city}}':
 * @property integer $class_id
 * @property integer $class_parent_id
 * @property string $class_name
 * @property integer $class_type
 */
class YhmCity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{yhm_city}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('class_parent_id, class_type', 'numerical', 'integerOnly'=>true),
			array('class_name', 'length', 'max'=>120),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('class_id, class_parent_id, class_name, class_type', 'safe', 'on'=>'search'),
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
			'class_id' => '城市id',
			'class_parent_id' => '父类',
			'class_name' => '名称',
			'class_type' => '类型',
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

		$criteria=new CDbCriteria;

		$criteria->compare('class_id',$this->class_id);
		$criteria->compare('class_parent_id',$this->class_parent_id);
		$criteria->compare('class_name',$this->class_name,true);
		$criteria->compare('class_type',$this->class_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return YhmCity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
