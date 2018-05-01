<?php

/**
 * This is the model class for table "{{activity_log}}".
 *
 * The followings are the available columns in table '{{activity_log}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $time_in
 * @property string $time_out
 * @property string $comments
 * @property string $date_created
 * @property integer $status
 * @property integer $payroll_id
 * @property integer $employee_approval
 * @property integer $department_id
 * @property integer $company_id
 *
 * The followings are the available model relations:
 * @property Payroll $payroll
 * @property User $user
 * @property Department $department
 * @property Company $company
 */
class ActivityLog extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ActivityLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{activity_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, time_in, status', 'required'),
            array('user_id, status, payroll_id, employee_approval, department_id, company_id', 'numerical', 'integerOnly' => true),
            array('time_in, time_out, comments, date_created', 'safe'),
            array('time_out', 'compareDates'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, time_in, time_out, comments, date_created, status, payroll_id, employee_approval, department_id, company_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'payroll' => array(self::BELONGS_TO, 'Payroll', 'payroll_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'user_id' => Yii::t('translate', 'User'),
            'time_in' => Yii::t('translate', 'Time In'),
            'time_out' => Yii::t('translate', 'Time Out'),
            'comments' => Yii::t('translate', 'Comments'),
            'date_created' => Yii::t('translate', 'Date Created'),
            'status' => Yii::t('translate', 'Status'),
            'payroll_id' => Yii::t('translate', 'Payroll'),
            'employee_approval' => Yii::t('translate', 'Employee Approval'),
            'department_id' => Yii::t('translate', 'Department'),
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('time_in', $this->time_in, true);
        $criteria->compare('time_out', $this->time_out, true);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('payroll_id', $this->payroll_id);
        $criteria->compare('employee_approval', $this->employee_approval);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('company_id', $this->company_id);

        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
            $criteria->compare('user_id', Yii::app()->user->id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {

            if ($this->time_in)
                $this->time_in = date('Y-m-d H:i:s', strtotime($this->time_in));
            else
                $this->time_in = NULL;
            if ($this->time_out && $this->time_out != '')
                $this->time_out = date('Y-m-d H:i:s', strtotime($this->time_out));
            else
                $this->time_out = NULL;

            if ($this->user_id) {
                $this->company_id = $this->user->company_id;
                $this->department_id = $this->user->department_id;
            }

            $sysLog = new SystemLog;
            $sysLog->user_id = Yii::app()->user->id;
            $sysLog->employee_id = $this->user_id;
            $sysLog->company_id = $this->company_id;
            if ($this->isNewRecord) {
                $sysLog->type = $this->time_out ? 1 : 0;
                $sysLog->comment = $sysLog->type ? 'Out @ ' . date('H:i', strtotime($this->time_out)) . ' On ' . date('d/m/Y', strtotime($this->time_out)) : 'In @ ' . date('H:i', strtotime($this->time_in)) . ' On ' . date('d/m/Y', strtotime($this->time_in));
            } else {
                $curr = self::model()->findByPk($this->id);
                $sysLog->type = $curr->time_out == '' ? 1 : 2;
                $sysLog->comment = $curr->time_out == '' ? 'Out @ ' . date('H:i', strtotime($this->time_out)) . ' On ' . date('d/m/Y', strtotime($this->time_out)) : ($curr->time_in != $this->time_in || $curr->time_out != $this->time_out) ? 'Time Card Correction @ ' . date('H:i', strtotime($this->time_in)) . ' On ' . date('d/m/Y', strtotime($this->time_in)) : '';
            }
            $sysLog->save();

            return true;
        }
        return false;
    }

    protected function afterFind() {
        if ($this->time_in)
            $this->time_in = date(Yii::app()->params['dateFormatPHP'], strtotime($this->time_in));
        if ($this->time_out)
            $this->time_out = date(Yii::app()->params['dateFormatPHP'], strtotime($this->time_out));
    }

    public static function changeStatus($status, $id) {
        if ($status == 0) {
            return '&nbsp;&nbsp;<a class="btn btn-small btn-success" href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/changeStatus?id=' . $id . '&status=1">Approve</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-small btn-danger" href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/changeStatus?id=' . $id . '&status=2">Decline</a>';
        }
        return '';
    }

    public static function ACLStatusForm() {
        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Normal'])
            return array('0' => 'Pending', '3' => 'Submitted For Approval', '2' => 'Declined', '1' => 'Approved');
        else
            return array('0' => 'Pending', '3' => 'Approved By Employee', '2' => 'Declined', '1' => 'Approved');
    }

    public static function ACLStatusValue($val, $id) {
        $isLink = 0;
        if (Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
            $arr = array('0' => 'Pending', '3' => 'Submitted For Approval', '2' => 'Declined', '1' => 'Approved');
            if ($val == 0) {
                $isLink = 1;
                $link = $arr[$val] . ' &nbsp;&nbsp;<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/changeStatus?id=' . $id . '&status=3" class="s_frame btn btn-small btn-success white">Submit for Approval</a>';
            }
        } else {
            $arr = array('0' => 'Pending', '3' => 'Approved By Employee', '2' => 'Declined', '1' => 'Approved');
            if ($val == 3) {
                $isLink = 1;
                $link = $arr[$val] . ' &nbsp;&nbsp;<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/changeStatus?id=' . $id . '&status=1" class="s_frame btn btn-small btn-success white">Approve</a> &nbsp;&nbsp;<a href="' . Yii::app()->request->getBaseUrl(true) . '/activityLog/changeStatus?id=' . $id . '&status=2" class="s_frame btn btn-small btn-success white">Decline</a>';
            }
        }

        if ($isLink) {
            return $link;
        } else {
            return $arr[$val];
        }
    }

    public function compareDates() {
        if ($this->time_out) {
            if ($this->time_out <= $this->time_in) {
                $this->addError('time_out', '"Time Out" Must be greater than "' . $this->time_in . '"');
            }
        }
    }

}
