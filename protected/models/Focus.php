<?php

/**
 * This is the model class for table "{{focus}}".
 *
 * The followings are the available columns in table '{{focus}}':
 * @property integer $focus_id
 * @property integer $focus_user
 * @property integer $user_id
 * @property string $is_focus
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Focus extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{focus}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('focus_user,focus_type， user_id', 'required'),
			array('focus_user, user_id', 'numerical', 'integerOnly'=>true),
			array('is_focus', 'length', 'max'=>1),
			array('gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('focus_id, focus_type,focus_user, user_id, is_focus, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'User','focus_user'),
			'store'=>array(self::BELONGS_TO,'Store','focus_user'),
			'alliance'=>array(self::BELONGS_TO,'Alliance','focus_user'),
			'dynamic' => array(self::Has_MANY,'Dynamic','','on'=>'focus_user = dy_user and focus_type = dy_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'focus_id' => '关注id',
			'focus_type' =>'关注类型',//0-个人，1-联盟，2-店铺，3-其他
			'focus_user' => '关注对象',
			'user_id' => '关注者',
			'is_focus' => '是否关注',//0-取消关注 1-关注
			'gmt_created' => '创建时间',
			'gmt_modified' => '修改时间',
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

		$criteria->compare('focus_id',$this->focus_id);
		$criteria->compare('focus_user',$this->focus_user);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('is_focus',$this->is_focus,true);
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
	 * @return Focus the static model class
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
