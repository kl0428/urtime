<?php

/**
 * This is the model class for table "{{card}}".
 *
 * The followings are the available columns in table '{{card}}':
 * @property integer $card_id
 * @property string $card_type
 * @property string $card_style
 * @property string $card_num
 * @property string $start_time
 * @property string $end_time
 * @property integer $total_num
 * @property integer $used_num
 * @property double $price
 * @property string $is_sale
 * @property integer type_id
 */
class Card extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{card}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('card_type, card_num, start_time, end_time, total_num,  price,type_id', 'required'),
			array('total_num, used_num', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('card_type', 'length', 'max'=>8),
			array('card_style, is_sale', 'length', 'max'=>1),
			array('card_num, start_time, end_time', 'length', 'max'=>32),
			array('used_num,is_sale','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('card_id, card_type, card_style, card_num, start_time, end_time, total_num, used_num, price, is_sale', 'safe', 'on'=>'search'),
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
			'card_id' => '卡片id',
			'card_type' => '种类',
			'card_style' => '类型',//0-通卡 1-体验
			'card_num' => '卡号',
			'start_time' => '有效开始时间',
			'end_time' => '有效结束时间',
			'total_num' => '使用总次数',
			'used_num' => '已用次数',
			'price' => '价值',
			'type_id'=>'通卡类型id',
			'is_sale' => '是否卖出',//0-未1-已
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

		$criteria->compare('card_id',$this->card_id);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('card_style',$this->card_style,true);
		$criteria->compare('card_num',$this->card_num,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('total_num',$this->total_num);
		$criteria->compare('used_num',$this->used_num);
		$criteria->compare('price',$this->price);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('is_sale',$this->is_sale,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Card the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//获取一张用户指定选择的通卡
	public function getCards($type_id=0,$num = 1)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('type_id',$type_id);
		$criteria->compare('is_sale',1);
		$criteria->limit = $num;
		$data  = $this->findAll($criteria);
		$result = array();
		if($data){
			$result =array(
				'card_id'=>$data->card_id,
				'card_type'=>$data->card_type,
				'card_style'=>$data->card_style,
				'card_num'=>$data->card_num,
				'used_num'=>$data->used_num,
				'price' =>$data->price,
			);
		}
		return $result;
	}
}
