<?php

/**
 * This is the model class for table "{{dynamic}}".
 *
 * The followings are the available columns in table '{{dynamic}}':
 * @property integer $dy_id
 * @property string $dy_type
 * @property integer $dy_user
 * @property string $dy_content
 * @property string $dy_images
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Dynamic extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dynamic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dy_user', 'required'),
			array('dy_user', 'numerical', 'integerOnly'=>true),
			array('dy_type', 'length', 'max'=>1),
			array('dy_content, dy_images, gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dy_id, dy_type, dy_user, dy_content, dy_images, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'user' =>array(self::BELONGS_TO,'User','dy_user'),
			'alliance' =>array(self::BELONGS_TO,'Alliance','dy_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dy_id' => '动态编号',
			'dy_type' => '动态类型',// 0-个人 1-联盟
			'dy_user' => '发表用户',
			'dy_content' => '动态内容',
			'dy_images' => '动态图片',
			'gmt_created' => '创建时间',
			'gmt_modified' => '更新时间',
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

		$criteria->compare('dy_id',$this->dy_id);
		$criteria->compare('dy_type',$this->dy_type,true);
		$criteria->compare('dy_user',$this->dy_user);
		$criteria->compare('dy_content',$this->dy_content,true);
		$criteria->compare('dy_images',$this->dy_images,true);
		$criteria->compare('gmt_created',$this->gmt_created,true);
		$criteria->compare('gmt_modified',$this->gmt_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Dynamic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		if($this->isNewRecord)
			$this->gmt_created = date('Y-m-d H:i:s');
		$this->gmt_modified = date('Y-m-d H:i:s');
		return true;
	}
}
