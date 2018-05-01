<?php

/**
 * This is the model class for table "{{timeoff}}".
 *
 * The followings are the available columns in table '{{timeoff}}':
 * @property integer $id
 * @property string $time_from
 * @property string $time_to
 * @property integer $user_id
 * @property string $comments
 * @property integer $status
 * @property string $date_created
 * @property integer $payroll_id
 * @property integer $employee_approval
 * @property integer $company_id
 * @property integer $request_type
 *
 * The followings are the available model relations:
 * @property RequestType $requestType
 * @property Payroll $payroll
 * @property User $user
 * @property Company $company
 */
class Timeoff extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Timeoff the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{timeoff}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, time_from, time_to, request_type, status', 'required'),
            array('user_id, status, payroll_id, employee_approval, company_id, request_type', 'numerical', 'integerOnly' => true),
            array('time_from, time_to, comments, date_created', 'safe'),
            array('time_date_from, time_date_to, time_time_from, time_time_to', 'length', 'max' => 30),
            array('time_to', 'compareDates'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, time_from, time_to, user_id, comments, status, date_created, payroll_id, employee_approval, company_id, request_type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'requestType' => array(self::BELONGS_TO, 'RequestType', 'request_type'),
            'payroll' => array(self::BELONGS_TO, 'Payroll', 'payroll_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
            'user_id' => Yii::t('translate', 'Employee'),
            'comments' => Yii::t('translate', 'Comments'),
            'status' => Yii::t('translate', 'Status'),
            'date_created' => Yii::t('translate', 'Date Created'),
            'payroll_id' => Yii::t('translate', 'Payroll'),
            'employee_approval' => Yii::t('translate', 'Employee Approval'),
            'company_id' => Yii::t('translate', 'Company'),
            'request_type' => Yii::t('translate', 'Request Type'),
            'time_date_from' => Yii::t('translate', 'Date:'),
            'time_date_to' => Yii::t('translate', 'To:'),
            'time_time_from' => Yii::t('translate', 'Time:'),
            'time_time_to' => Yii::t('translate', 'To:'),
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('payroll_id', $this->payroll_id);
        $criteria->compare('employee_approval', $this->employee_approval);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('request_type', $this->request_type);
        
        if(Yii::app()->user->hasState('company')){
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        }

        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
            $criteria->compare('user_id', Yii::app()->user->id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {

            if ($this->time_date_from && $this->time_time_from)
                $this->time_from = date('Y-m-d H:i:00', strtotime($this->time_date_from . ' ' . $this->time_time_from));
            if ($this->time_date_to && $this->time_time_to)
                $this->time_to = date('Y-m-d H:i:00', strtotime($this->time_date_to . ' ' . $this->time_time_to));

            $this->time_from = date('Y-m-d H:i:s', strtotime($this->time_from));
            $this->time_to = date('Y-m-d H:i:s', strtotime($this->time_to));


            if ($this->user_id) {
                $this->company_id = $this->user->company_id;
            }

            $sysLog = new SystemLog;
            $sysLog->user_id = Yii::app()->user->id;
            $sysLog->employee_id = $this->user_id;
            $sysLog->company_id = $this->company_id;
            $sysLog->type = 3;
            if ($this->isNewRecord)
                $sysLog->comment = 'Requested time off from (' . date('H:i', strtotime($this->time_from)) . ' on ' . date('d/m/Y', strtotime($this->time_from)) . ') to (' . date('H:i', strtotime($this->time_to)) . ' on ' . date('d/m/Y', strtotime($this->time_to)) . ')';
            /* else
              $sysLog->comment = 'Time off updated to be taken => from (' . date('H:i', strtotime($this->time_from)) . ' on ' . date('d/m/Y', strtotime($this->time_from)) . ') to (' . date('H:i', strtotime($this->time_to)) . ' on ' . date('d/m/Y', strtotime($this->time_to)) . ')'; */
            $sysLog->save();

            return true;
        }
        return false;
    }

    protected function afterFind() {
        $this->time_from = date(Yii::app()->params['dateFormatPHP'], strtotime($this->time_from));
        $this->time_to = date(Yii::app()->params['dateFormatPHP'], strtotime($this->time_to));
    }

    public static function getStatus($val, $isLink = 0, $link = '') {
        $arr = array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined');

        if ($isLink && $link && $val == 0)
            return '<a href="' . $link . '" class="s_frame">' . $arr[$val] . '</a>';
        else
            return $arr[$val];
    }

    public static function getTime($time) {
        if ($time) {
            $date = date('M d Y', strtotime($time));
            $hours = date('h', strtotime($time));
            $mins = '';
            $am_pm = '';
            if ($hours && $hours > 0) {
                $am_pm = 'am';
                $mins = date('i', strtotime($time));
                if ($hours > 12) {
                    $hours-=10;
                    $am_pm = 'pm';
                }
            } else {
                $hours = '';
            }

            return $date . ' ' . $hours . ':' . $mins . $am_pm;
        } else {
            return 'No Time';
        }
    }

    public static function canRequest($id, $vacation_sick_leave) {
        $canRequest = false;
        $user = User::model()->findByPk($id);
        $field = $vacation_sick_leave ? 'sick_leave' : 'paid_timeoff';
        $field_pay = $vacation_sick_leave ? 'sick_leave_period' : 'paid_timeoff_period';
        $probation = $user->$field_pay * 30 * 24 * 60 * 60;
        if ($user->$field && time() >= (strtotime($user->hire_date) + $probation)) {
            $canRequest = true;
        }
        return $canRequest;
    }

    public static function changeStatus($status, $id) {
        if ($status == 0) {
            return '&nbsp;&nbsp;<a class="btn btn-small btn-success" href="' . Yii::app()->request->getBaseUrl(true) . '/timeoff/changeStatus?id=' . $id . '&status=1">Approve</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-small btn-danger" href="' . Yii::app()->request->getBaseUrl(true) . '/timeoff/changeStatus?id=' . $id . '&status=2">Decline</a>';
        }
        return '';
    }

    public function compareDates() {
        if ($this->time_date_from && $this->time_time_from)
            $this->time_from = date('Y-m-d H:i:00', strtotime($this->time_date_from . ' ' . $this->time_time_from));
        if ($this->time_date_to && $this->time_time_to)
            $this->time_to = date('Y-m-d H:i:00', strtotime($this->time_date_to . ' ' . $this->time_time_to));
        if ($this->time_to) {
            if ($this->time_to <= $this->time_from) {
                $this->addError('time_to', '"Time To" Must be greater than "' . $this->time_from . '"');
            }
        }
    }

}
