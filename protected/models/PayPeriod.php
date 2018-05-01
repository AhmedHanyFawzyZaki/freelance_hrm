<?php

/**
 * This is the model class for table "{{pay_period}}".
 *
 * The followings are the available columns in table '{{pay_period}}':
 * @property integer $id
 * @property string $name
 * @property integer $period
 *
 * The followings are the available model relations:
 * @property User[] $users
 * @property UserPayRateHistory[] $userPayRateHistories
 */
class PayPeriod extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PayPeriod the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pay_period}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('period, name, company_id, period_in_days', 'required'),
            array('period, company_id, period_in_days', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, period, period_in_days', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'users' => array(self::HAS_MANY, 'User', 'pay_rate_period'),
            'userPayRateHistories' => array(self::HAS_MANY, 'UserPayRateHistory', 'pay_rate_period'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'name' => Yii::t('translate', 'Name'),
            'period' => Yii::t('translate', 'Period in hours'),
            'company_id' => Yii::t('translate', 'Company'),
			'period_in_days' => Yii::t('translate','Period in days')
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('period', $this->period);
		$criteria->compare('period_in_days', $this->period_in_days);
        $criteria->compare('company_id', $this->company_id);
        if (Yii::app()->user->hasState('company')) {
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    Public static function listPeriods($periods){
        $arr=array();
        if($periods){
            foreach ($periods as $p) {
                $arr[]=  PayPeriod::model()->findByPk($p)->name;
            }
        }
        return implode(', ',$arr);
    }

}
