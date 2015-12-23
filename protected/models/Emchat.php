<?php

/**
 * This is the model class for table "{{emchat}}".
 *
 * The followings are the available columns in table '{{emchat}}':
 * @property integer $id
 * @property string $name
 * @property string $emchat_id
 * @property string $owner
 * @property string $desc
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Emchat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{emchat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, emchat_id, owner, desc', 'required'),
			array('name, emchat_id, owner', 'length', 'max'=>64),
			array('desc', 'length', 'max'=>250),
			array('gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, emchat_id, owner, desc, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'id' => '组id',
			'name' => '组名',
			'emchat_id' => '环信组id',
			'owner' => '环信群组名',
			'desc' => '组描述',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('emchat_id',$this->emchat_id,true);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('desc',$this->desc,true);
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
	 * @return Emchat the static model class
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
