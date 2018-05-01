<?php

/**
 * This is the model class for table "{{user_permission}}".
 *
 * The followings are the available columns in table '{{user_permission}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $punch_other
 * @property integer $activity_log_create
 * @property integer $activity_log_update
 * @property integer $punch
 * @property integer $report
 * @property integer $gps
 * @property integer $pay_info
 * @property integer $time_off
 * @property integer $admin
 * @property integer $company_user
 * @property integer $company_department
 * @property integer $company_reports
 * @property integer $company_pay_info
 * @property integer $company_timeoff
 * @property integer $company_activity
 * @property integer $company_dashboard
 * @property integer $company_admin
 * @property integer $company_settings
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserPermission extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserPermission the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_permission}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, punch_other, activity_log_create, activity_log_update, punch, report, gps, pay_info, time_off, admin, company_user, company_department, company_reports, company_pay_info, company_timeoff, company_activity, company_dashboard, company_admin, company_settings', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, punch_other, activity_log_create, activity_log_update, punch, report, gps, pay_info, time_off, admin, company_user, company_department, company_reports, company_pay_info, company_timeoff, company_activity, company_dashboard, company_admin, company_settings', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'user_id' => Yii::t('translate', 'User'),
            'punch_other' => Yii::t('translate', 'Default Permissions'),
            'activity_log_create' => Yii::t('translate', 'Create Time Entries'),
            'activity_log_update' => Yii::t('translate', 'Edit Time Entries'),
            'punch' => Yii::t('translate', 'Punch In & Out'),
            'report' => Yii::t('translate', 'Run Reports (Own Personal Reports)'),
            'gps' => Yii::t('translate', 'View GPS Location Information'),
            'pay_info' => Yii::t('translate', 'View Pay Information (Own Pay info.)'),
            'time_off' => Yii::t('translate', 'Create Time Off Requests'),
            'admin' => Yii::t('translate', 'Admin Privileges'),
            'company_user' => Yii::t('translate', 'Create New Employees'),
            'company_department' => Yii::t('translate', 'Create New Departments'),
            'company_reports' => Yii::t('translate', 'Run Company Reports'),
            'company_pay_info' => Yii::t('translate', 'View All Employees\'s Pay Info'),
            'company_timeoff' => Yii::t('translate', 'Create / Edit Time Off Entries'),
            'company_activity' => Yii::t('translate', 'Create / Edit Time Entries'),
            'company_dashboard' => Yii::t('translate', 'Access Dashboard'),
            'company_admin' => Yii::t('translate', 'Create Other Admin Employees'),
            'company_settings' => Yii::t('translate', 'Access Company Settings'),
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
        $criteria->compare('punch_other', $this->punch_other);
        $criteria->compare('activity_log_create', $this->activity_log_create);
        $criteria->compare('activity_log_update', $this->activity_log_update);
        $criteria->compare('punch', $this->punch);
        $criteria->compare('report', $this->report);
        $criteria->compare('gps', $this->gps);
        $criteria->compare('pay_info', $this->pay_info);
        $criteria->compare('time_off', $this->time_off);
        $criteria->compare('admin', $this->admin);
        $criteria->compare('company_user', $this->company_user);
        $criteria->compare('company_department', $this->company_department);
        $criteria->compare('company_reports', $this->company_reports);
        $criteria->compare('company_pay_info', $this->company_pay_info);
        $criteria->compare('company_timeoff', $this->company_timeoff);
        $criteria->compare('company_activity', $this->company_activity);
        $criteria->compare('company_dashboard', $this->company_dashboard);
        $criteria->compare('company_admin', $this->company_admin);
        $criteria->compare('company_settings', $this->company_settings);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
