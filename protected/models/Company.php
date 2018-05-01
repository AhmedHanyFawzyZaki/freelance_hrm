<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property integer $paid_time_available
 * @property integer $holiday_hours
 * @property integer $sick_fixed_pay
 * @property integer $sick_fixed_rollover
 * @property integer $sick_fixed_rollover_pay
 * @property integer $sick_fixed_max_hours
 * @property integer $sick_accrue_hour
 * @property integer $sick_accrue_per_hour
 * @property integer $sick_accrue_rollover
 * @property integer $sick_accrue_rollover_pay
 * @property integer $sick_accrue_max_hours
 * @property integer $vacation_fixed_accrued
 * @property integer $vacation_fixed_pay
 * @property integer $vacation_fixed_rollover
 * @property integer $vacation_fixed_rollover_pay
 * @property integer $vacation_fixed_max_hours
 * @property integer $vacation_accrue_hour
 * @property integer $vacation_accrue_per_hour
 * @property integer $vacation_accrue_rollover
 * @property integer $vacation_accrue_rollover_pay
 * @property integer $vacation_accrue_max_hours
 * The followings are the available model relations:
 * @property Department[] $departments
 * @property User[] $users
 */
class Company extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Company the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{company}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email', 'required'),
            array('paid_time_available, sick_fixed_accrued, sick_fixed_pay, sick_fixed_rollover, sick_fixed_rollover_pay, sick_fixed_max_hours, sick_accrue_hour, sick_accrue_per_hour, sick_accrue_rollover, sick_accrue_rollover_pay, sick_accrue_max_hours, vacation_fixed_accrued, vacation_fixed_pay, vacation_fixed_rollover, vacation_fixed_rollover_pay, vacation_fixed_max_hours, vacation_accrue_hour, vacation_accrue_per_hour, vacation_accrue_rollover, vacation_accrue_rollover_pay, vacation_accrue_max_hours, end_on', 'numerical', 'integerOnly' => true),
            array('name, email, phone, address, renewal_date', 'length', 'max' => 255),
            array('start_on, over_time, pay_period, weekly_holiday', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, email, phone, address, paid_time_available, renewal_date, sick_fixed_accrued, sick_fixed_pay, sick_fixed_rollover, sick_fixed_rollover_pay, sick_fixed_max_hours, sick_accrue_hour, sick_accrue_per_hour, sick_accrue_rollover, sick_accrue_rollover_pay, sick_accrue_max_hours, vacation_fixed_accrued, vacation_fixed_pay, vacation_fixed_rollover, vacation_fixed_rollover_pay, vacation_fixed_max_hours, vacation_accrue_hour, vacation_accrue_per_hour, vacation_accrue_rollover, vacation_accrue_rollover_pay, vacation_accrue_max_hours', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'departments' => array(self::HAS_MANY, 'Department', 'company_id'),
            'users' => array(self::HAS_MANY, 'User', 'company_id'),
            //'payPeriod' => array(self::HAS_MANY, 'PayPeriod', 'pay_period'),
            'payPeriod' => array(self::BELONGS_TO, 'PayPeriod', 'pay_period'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'name' => Yii::t('translate', 'Name'),
            'email' => Yii::t('translate', 'Email'),
            'phone' => Yii::t('translate', 'Phone'),
            'address' => Yii::t('translate', 'Address'),
            'paid_time_available (in payroll period)' => Yii::t('translate', 'Paid Time Available'),
            'renewal_date' => Yii::t('translate', 'Renewal Date'),
            'sick_fixed_accrued' => Yii::t('translate', 'Sick Leave Policy'),
            'sick_fixed_pay' => Yii::t('translate', 'Fixed Paid Hours Per Year'),
            'sick_fixed_rollover' => Yii::t('translate', 'Allow Sick Leave Rollover?'),
            'sick_fixed_rollover_pay' => Yii::t('translate', 'Rollover allowed per year'),
            'sick_fixed_max_hours' => Yii::t('translate', 'Max accumulated hours per year'),
            'sick_accrue_hour' => Yii::t('translate', 'Accrue'),
            'sick_accrue_per_hour' => Yii::t('translate', 'Every'),
            'sick_accrue_rollover' => Yii::t('translate', 'Allow Sick Leave Rollover?'),
            'sick_accrue_rollover_pay' => Yii::t('translate', 'Rollover allowed per year'),
            'sick_accrue_max_hours' => Yii::t('translate', 'Max accrued hours per year'),
            'vacation_fixed_accrued' => Yii::t('translate', 'Vacation Policy'),
            'vacation_fixed_pay' => Yii::t('translate', 'Fixed Paid Hours Per Year'),
            'vacation_fixed_rollover' => Yii::t('translate', 'Allow Vacation Rollover?'),
            'vacation_fixed_rollover_pay' => Yii::t('translate', 'Rollover allowed per year'),
            'vacation_fixed_max_hours' => Yii::t('translate', 'Max accumulated hours per year'),
            'vacation_accrue_hour' => Yii::t('translate', 'Accrue'),
            'vacation_accrue_per_hour' => Yii::t('translate', 'Every'),
            'vacation_accrue_rollover' => Yii::t('translate', 'Allow Vacation Rollover?'),
            'vacation_accrue_rollover_pay' => Yii::t('translate', 'Rollover allowed per year'),
            'vacation_accrue_max_hours' => Yii::t('translate', 'Max accumulated hours per year'),
            'pay_period' => Yii::t('translate', 'Pay Period'),
            'start_on' => Yii::t('translate', 'Start On'),
            'end_on' => Yii::t('translate', 'End On'),
            'over_time' => Yii::t('translate', 'Overtime'),
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

        $criteria->condition = 'id!=1';
        if (Yii::app()->user->hasState('company'))
            $criteria->compare('id', Yii::app()->user->getState('company'));
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('renewal_date', $this->renewal_date, true);
        $criteria->compare('paid_time_available', $this->paid_time_available);
        $criteria->compare('sick_fixed_accrued', $this->sick_fixed_accrued);
        $criteria->compare('sick_fixed_pay', $this->sick_fixed_pay);
        $criteria->compare('sick_fixed_rollover', $this->sick_fixed_rollover);
        $criteria->compare('sick_fixed_rollover_pay', $this->sick_fixed_rollover_pay);
        $criteria->compare('sick_fixed_max_hours', $this->sick_fixed_max_hours);
        $criteria->compare('sick_accrue_hour', $this->sick_accrue_hour);
        $criteria->compare('sick_accrue_per_hour', $this->sick_accrue_per_hour);
        $criteria->compare('sick_accrue_rollover', $this->sick_accrue_rollover);
        $criteria->compare('sick_accrue_rollover_pay', $this->sick_accrue_rollover_pay);
        $criteria->compare('sick_accrue_max_hours', $this->sick_accrue_max_hours);
        $criteria->compare('vacation_fixed_accrued', $this->vacation_fixed_accrued);
        $criteria->compare('vacation_fixed_pay', $this->vacation_fixed_pay);
        $criteria->compare('vacation_fixed_rollover', $this->vacation_fixed_rollover);
        $criteria->compare('vacation_fixed_rollover_pay', $this->vacation_fixed_rollover_pay);
        $criteria->compare('vacation_fixed_max_hours', $this->vacation_fixed_max_hours);
        $criteria->compare('vacation_accrue_hour', $this->vacation_accrue_hour);
        $criteria->compare('vacation_accrue_per_hour', $this->vacation_accrue_per_hour);
        $criteria->compare('vacation_accrue_rollover', $this->vacation_accrue_rollover);
        $criteria->compare('vacation_accrue_rollover_pay', $this->vacation_accrue_rollover_pay);
        $criteria->compare('vacation_accrue_max_hours', $this->vacation_accrue_max_hours);
        $criteria->compare('pay_period', $this->pay_period);
        $criteria->compare('start_on', $this->start_on, true);
        $criteria->compare('end_on', $this->end_on);
        $criteria->compare('over_time', $this->over_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            $this->over_time = implode(',', $this->over_time);
            $this->pay_period = implode(',', $this->pay_period);
            $this->start_on = date('Y-m-d H:i:s', strtotime($this->start_on));
            $this->weekly_holiday = implode(',', $this->weekly_holiday);
            return true;
        }
        return false;
    }

    protected function afterFind() {
        $this->over_time = explode(',', $this->over_time);
        $this->pay_period = explode(',', $this->pay_period);
        $this->weekly_holiday = explode(',', $this->weekly_holiday);
        $this->start_on = date(Yii::app()->params['dateFormatPHP'], strtotime($this->start_on));
        return true;
    }

    public static function PayrollStart($company_id, $period = '') {
        /* $lastPayroll = Payroll::model()->find(array('condition' => 'company_id=' . $company_id, 'order' => 'id desc'));
          if ($lastPayroll) {
          $diff = time() - strtotime($lastPayroll->time_to); //time since last generated payroll
          } */
        $company = Company::model()->findByPk($company_id);
        $start_day = $company->start_on ? $company->start_on : $company->date_created;
        $no_of_days = $period ? $period : 14; //14 days is the default pay period for all companies
        $period = $no_of_days * 24 * 60 * 60;
        /* if ($company->pay_period) {
          $period = $company->payPeriod->period_in_days * 24 * 60 * 60;
          } else {
          $period = 14 * 24 * 60 * 60; //14 days is the default pay period for all companies
          } */
        $no_of_previous_payroll = floor((time() - strtotime($start_day)) / $period); //no. of payroll sheets that should be generated until now
        //$last_payroll = date('Y-m-d', (($no_of_previous_payroll - 1) * $period) + strtotime($company->start_on)); // subtract 1 from the previous to get the current payroll not the next
        $last_payroll = date('Y-m-d', strtotime('+' . (($no_of_previous_payroll - 1) * $no_of_days) . ' day', strtotime($start_day))); // subtract 1 from the previous to get the current payroll not the next

        return $last_payroll;
    }

    public static function PayrollLast($company_id, $start, $period = '') {
        $company = Company::model()->findByPk($company_id);
        $no_of_days = $period ? $period : 14; //14 days is the default pay period for all companies
        $last = date('Y-m-d', strtotime('+' . ($no_of_days - 1) . ' day', strtotime($start))); // subtract 1 day from the number of days
        /* if ($company->pay_period) {
          $last = strtotime($start) + ($company->payPeriod->period_in_days * 24 * 60 * 60);
          } else {
          $last = strtotime($start) + (14 * 24 * 60 * 60); //14 days is the default pay period for all companies
          } */
        return $last;
    }

}
