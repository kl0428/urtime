<?php

/**
 * This is the model class for table "{{store}}".
 *
 * The followings are the available columns in table '{{store}}':
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property integer $manager
 * @property string $address
 * @property string $tel
 * @property string $realname
 * @property string $identity
 * @property string $mobile
 * @property string $bussiness_license
 * @property string $bankcode
 * @property string $banktype
 * @property string $is_open
 * @property string $introduction
 * @property string $images_str
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Store extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{store}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, image, manager, address, tel, realname, identity, mobile, bussiness_license, bankcode, banktype', 'required'),
			array('manager', 'numerical', 'integerOnly'=>true),
			array('name, tel, realname, identity, mobile, bankcode, banktype', 'length', 'max'=>32),
			array('image', 'length', 'max'=>64),
			array('address, bussiness_license', 'length', 'max'=>250),
			array('is_open', 'length', 'max'=>1),
			array('introduction, images_str, gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, image, manager, address, tel, realname, identity, mobile, bussiness_license, bankcode, banktype, is_open, introduction, images_str, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'id' => '店铺id',
			'name' => '店铺名称',
			'image' => '店铺logo',
			'manager' => '店铺管理员',
			'address' => '店铺地址',
			'tel' => '店铺固话',
			'realname' => '法人',
			'identity' => '身份证',
			'mobile' => '手机号',
			'bussiness_license' => '营业执照',
			'bankcode' => '银行卡号',
			'banktype' => '银行类型',
			'is_open' => '审核通过0-未审核,1-审核,2-退出,3-删除',
			'introduction' => '介绍',
			'images_str' => '介绍图片',
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
		$criteria->compare('image',$this->image,true);
		$criteria->compare('manager',$this->manager);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('identity',$this->identity,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('bussiness_license',$this->bussiness_license,true);
		$criteria->compare('bankcode',$this->bankcode,true);
		$criteria->compare('banktype',$this->banktype,true);
		$criteria->compare('is_open',$this->is_open,true);
		$criteria->compare('introduction',$this->introduction,true);
		$criteria->compare('images_str',$this->images_str,true);
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
	 * @return Store the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
