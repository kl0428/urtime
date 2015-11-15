<?php

/**
 * This is the model class for table "{{alliance}}".
 *
 * The followings are the available columns in table '{{alliance}}':
 * @property integer $id
 * @property integer $leader
 * @property string $image
 * @property integer $type
 * @property string $center_name
 * @property string $accept
 * @property string $notice
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Alliance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{alliance}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('leader, image, type, center_name', 'required'),
			array('name','unique','className'=>'Alliance','attributeName'=>'name','message'=>'联盟名称已存在'),
			array('leader, type', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>250),
			array('center_name', 'length', 'max'=>32),
			array('accept', 'length', 'max'=>1),
			array('notice, gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, leader, image, type, center_name, accept, notice, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'user'=>array(self::BELONGS_TO,'User','leader'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '联盟编号',
			'leader' => '盟主',
			'image' => '联盟头像',
			'type' => '审核状态',// 0-待审核,1-审核通过,2-审核失败,3-禁用
			'center_name' => '联盟健身中心名称',
			'accept' => '接受消息',
			'notice' => '最新公告',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('leader',$this->leader);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('center_name',$this->center_name,true);
		$criteria->compare('accept',$this->accept,true);
		$criteria->compare('notice',$this->notice,true);
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
	 * @return Alliance the static model class
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

	public function getAlliance($alliance_id=0)
	{

		$criteria = new CDbCriteria;
		$criteria->compare('t.id',$alliance_id);
		$criteria->with='user';
		$obj = $this->find($criteria);
		if($obj){
			$alliance = array(
				'id'=>$obj->id,
				'name'=>$obj->name,
				'leader'=>$obj->leader,
				'leader_name'=>$obj->user->nickname,
				'type'=>$obj->type,
				'center_name'=>$obj->center_name,
				'notice'=>$obj->notice,
				'members'=>Relations::model()->getMembers($alliance_id,0),
			);
		}else{
			$alliance = [];
		}
		return $alliance;
	}
}
