<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $id
 * @property string $name
 * @property string $image
 * @property string $start_time
 * @property string $end_time
 * @property string $soft_del
 * @property integer $sort
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Banner extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{banner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, image, sort', 'required'),
			array('sort', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>32),
			array('image', 'length', 'max'=>56),
			array('soft_del', 'length', 'max'=>1),
			array('start_time, end_time, gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, image, start_time, end_time, soft_del, sort, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'id' => '发现banner_id',
			'name' => 'banner称呼',
			'image' => 'banner',
			'start_time' => 'banner展示开始时间',
			'end_time' => 'banner展示结束时间',
			'soft_del' => '是否删除0-未删除,1-删除',
			'sort' => '排序大前',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('soft_del',$this->soft_del,true);
		$criteria->compare('sort',$this->sort);
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
	 * @return Banner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//获取banner信息列表
	public  function getBannerList()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('soft_del=0');
		$criteria->addCondition('start_time <='.time());
		//$criteria->addCondition('end_time >='.time());
		$criteria->order='sort desc';
		$data = $this->findAll($criteria);
		$result =array();
		if($data){
			foreach($data as $k=>$v)
			{
				$result[] = array(
					'name'=>$v->name,
					'image_url'=>Yii::app()->hostInfo.'/'.$v->image,
				);
			}
		}
		return $result;
	}

}
