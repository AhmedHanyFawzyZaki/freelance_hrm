<?php

/**
 * This is the model class for table "{{payroll}}".
 *
 * The followings are the available columns in table '{{payroll}}':
 * @property integer $id
 * @property string $time_from
 * @property string $time_to
 * @property integer $status
 * @property string $date_created
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property ActivityLog[] $activityLogs
 * @property User $user
 * @property Timeoff[] $timeoffs
 */
class Payroll extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Payroll the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{payroll}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time_from, time_to', 'required'),
            array('status, user_id, company_id', 'numerical', 'integerOnly' => true),
            array('time_from, time_to, date_created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, time_from, time_to, status, date_created, user_id, company_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'activityLogs' => array(self::HAS_MANY, 'ActivityLog', 'payroll_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'timeoffs' => array(self::HAS_MANY, 'Timeoff', 'payroll_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'time_from' => Yii::t('translate', 'Time From'),
            'time_to' => Yii::t('translate', 'Time To'),
            'status' => Yii::t('translate', 'Status'),
            'date_created' => Yii::t('translate', 'Date Created'),
            'user_id' => Yii::t('translate', 'Created By'),
            'company_id' => Yii::t('translate', 'Company'),
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

        $criteria->order = 'id desc';

        $criteria->compare('id', $this->id);
        $criteria->compare('time_from', $this->time_from, true);
        $criteria->compare('time_to', $this->time_to, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('company_id', $this->company_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            $this->user_id = Yii::app()->user->id;
            $this->company_id = Yii::app()->user->getState('company');
            return true;
        }
        return false;
    }

    protected function afterSave() {
        Timeoff::model()->updateAll(array('payroll_id' => $this->id), 'company_id="' . $this->company_id . '" and (DATE_FORMAT(time_from,"%Y-%m-%d")>="' . $this->time_from . '" and DATE_FORMAT(time_to,"%Y-%m-%d")<="' . $this->time_to . '")');
        ActivityLog::model()->updateAll(array('payroll_id' => $this->id), 'company_id="' . $this->company_id . '" and (DATE_FORMAT(time_in,"%Y-%m-%d")>="' . $this->time_from . '" and DATE_FORMAT(time_out,"%Y-%m-%d")<="' . $this->time_to . '")');
        return true;
    }

    public static function hoursWorked($emp_id, $payroll_id = '', $from = '', $to = '') {
        if ($payroll_id)
            $times = ActivityLog::model()->findAllByAttributes(array('payroll_id' => $payroll_id, 'user_id' => $emp_id, 'status' => 1));
        else
            $times = ActivityLog::model()->findAll(array('condition' => 'user_id=' . $emp_id . ' and status=1 and DATE_FORMAT(time_in,"%Y-%m-%d")>="' . $from . '" and DATE_FORMAT(time_out,"%Y-%m-%d")<="' . $to . '"'));
        $hours = 0;
        if ($times) {
            foreach ($times as $tm) {
                $hours += strtotime($tm->time_out) - strtotime($tm->time_in);
            }
        }
        return $hours / (60 * 60);
    }

    public static function hoursDeducted($emp_id, $payroll_id = '', $from = '', $to = '') {
        if ($payroll_id)
            $times = Timeoff::model()->findAllByAttributes(array('payroll_id' => $payroll_id, 'user_id' => $emp_id, 'status' => 2));
        else
            $times = Timeoff::model()->findAll(array('condition' => 'user_id=' . $emp_id . ' and status=2 and DATE_FORMAT(time_from,"%Y-%m-%d")>="' . $from . '" and DATE_FORMAT(time_to,"%Y-%m-%d")<="' . $to . '"'));
        $hours = 0;
        if ($times) {
            foreach ($times as $tm) {
                $hours += strtotime($tm->time_to) - strtotime($tm->time_from);
            }
        }
        return $hours / (60 * 60);
    }

}
