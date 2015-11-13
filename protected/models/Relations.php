<?php

/**
 * This is the model class for table "{{relations}}".
 *
 * The followings are the available columns in table '{{relations}}':
 * @property integer $re_id
 * @property integer $user_id
 * @property integer $alliance_id
 * @property string $apply_type
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Relations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{relations}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, alliance_id', 'required'),
			array('user_id, alliance_id', 'numerical', 'integerOnly'=>true),
			array('apply_type', 'length', 'max'=>1),
			array('gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('re_id, user_id, alliance_id, apply_type, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			're_id' => '关系编号',
			'user_id' => '用户id',
			'alliance_id' => '联盟id',
			'apply_type' => '申请状态 0-申请中,1-申请通过,2-被拒绝,3-删除',
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

		$criteria->compare('re_id',$this->re_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('alliance_id',$this->alliance_id);
		$criteria->compare('apply_type',$this->apply_type,true);
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
	 * @return Relations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
