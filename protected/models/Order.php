<?php

/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $ping_id
 * @property integer $flag
 * @property string $flag_content
 * @property string $app
 * @property string $channel
 * @property string $order_no
 * @property string $client_ip
 * @property string $amount
 * @property string $paid
 * @property integer $time_paid
 * @property string $subject
 * @property string $body
 * @property string $gmt_created
 * @property string $gmt_modified
 */
class Order extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, ping_id, app, channel, order_no', 'required'),
			array('user_id, flag, time_paid', 'numerical', 'integerOnly'=>true),
			array('ping_id', 'length', 'max'=>64),
			array('flag_content, app', 'length', 'max'=>32),
			array('channel, order_no, client_ip', 'length', 'max'=>16),
			array('amount', 'length', 'max'=>8),
			array('paid', 'length', 'max'=>1),
			array('subject', 'length', 'max'=>200),
			array('body', 'length', 'max'=>250),
			array('gmt_created, gmt_modified', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, ping_id, flag, flag_content, app, channel, order_no, client_ip, amount, paid, time_paid, subject, body, gmt_created, gmt_modified', 'safe', 'on'=>'search'),
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
			'id' => 'order记录',
			'user_id' => '用户',
			'ping_id' => 'ping编号',
			'flag' => '消费标识',
			'flag_content' => '标识内容',
			'app' => 'app',
			'channel' => '付款方式',
			'order_no' => '订单编号',
			'client_ip' => 'IP',
			'amount' => '金额',
			'paid' => '是否付款',//0-否1-是
			'time_paid' => '付款时间',
			'subject' => '标题',
			'body' => '内容',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('ping_id',$this->ping_id,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('flag_content',$this->flag_content,true);
		$criteria->compare('app',$this->app,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('order_no',$this->order_no,true);
		$criteria->compare('client_ip',$this->client_ip,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('paid',$this->paid,true);
		$criteria->compare('time_paid',$this->time_paid);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
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
	 * @return Order the static model class
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
