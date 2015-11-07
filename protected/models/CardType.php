<?php

/**
 * This is the model class for table "{{card_type}}".
 *
 * The followings are the available columns in table '{{card_type}}':
 * @property integer $type_id
 * @property string $type_name
 * @property string $type_style
 * @property string $type_mark
 * @property integer $type_num
 * @property string $type_desc
 */
class CardType extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{card_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_name, type_style, type_num', 'required'),
			array('type_num', 'numerical', 'integerOnly'=>true),
			array('type_name', 'length', 'max'=>32),
			array('type_style', 'length', 'max'=>16),
			array('type_mark', 'length', 'max'=>1),
			array('type_desc', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('type_id, type_name, type_style, type_mark, type_num, type_desc', 'safe', 'on'=>'search'),
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
			'type_id' => '卡类型id',
			'type_name' => '卡名',
			'type_style' => '类别',
			'type_mark' => '种类',//0-通卡,1-体验
			'type_num' => '次数',
			'type_desc' => '描述',
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

		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('type_name',$this->type_name,true);
		$criteria->compare('type_style',$this->type_style,true);
		$criteria->compare('type_mark',$this->type_mark,true);
		$criteria->compare('type_num',$this->type_num);
		$criteria->compare('type_desc',$this->type_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CardType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	//根据type_mark类型标签获取制定标签的通信列表
	public function getTypeCards($mark = 0)
	{
		$data = $this->findAll(array('condition'=>'type_mark =:mark','params'=>array(':mark'=>$mark),'order'=>'type_style asc'));
		$result =array();
		if($data)
		{
			foreach($data as $k=>$v)
			{
				$result[$v->type_style][]=array(
					'id' 	=>$v->type_id,
					'name' =>$v->type_name,
					'type' =>$v->type_style,
					'style'=>$v->type_mark,
					'num'  =>$v->type_num,
					'desc' =>$v->type_desc,
				);
			}
		}
		return $result;
	}
}
