<?php

/**
 * This is the model class for table "{{user_pay_rate_history}}".
 *
 * The followings are the available columns in table '{{user_pay_rate_history}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $pay_rate
 * @property integer $pay_rate_period
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserPayRateHistory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserPayRateHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_pay_rate_history}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, pay_rate_period', 'numerical', 'integerOnly' => true),
            array('pay_rate', 'length', 'max' => 10),
            array('date_updated', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, pay_rate, pay_rate_period', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'payRatePeriod' => array(self::BELONGS_TO, 'PayPeriod', 'pay_rate_period'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'user_id' => Yii::t('translate', 'User'),
            'pay_rate' => Yii::t('translate', 'Pay Rate'),
            'pay_rate_period' => Yii::t('translate', 'Pay Rate Period'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('pay_rate', $this->pay_rate, true);
        $criteria->compare('pay_rate_period', $this->pay_rate_period);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
