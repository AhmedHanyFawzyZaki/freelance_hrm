	

<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $username
 * @property string $image
 * @property string $phone
 * @property integer $user_type
 * @property string $date_created
 *
 * The followings are the available model relations:
 */
class User extends CActiveRecord {

    public $password_repeat;
    public $verifyCode;
    public $old_password;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, url', 'unique'),
            array('email', 'email'),
            array('first_name, last_name, user_type, department_id', 'required'),
            array('user_type, active, department_id, pay_rate_period, checkinout_notification, 
                checkin_notification, checkout_notification, checkin_late_notification, overtime, overtime_period, holiday_pay, 
                holiday_pay_period, sick_leave, sick_leave_period, paid_timeoff, paid_timeoff_period, company_id, vacation_credit, sickleave_credit', 'numerical', 'integerOnly' => true),
            array('email, password, username, image, employee_id, title, checkinout_email, checkin_late_email, first_name, last_name', 'length', 'max' => 255),
            array('username', 'required', 'on' => 'create ,update'),
            array('date_created, pay_rate, hire_date, vacation_date, sickleave_date', 'safe'),
            array('username, email', 'filter', 'filter' => 'trim'),
            array('username', 'match', 'pattern' => '/^[ \w#-]+$/', 'message' => 'Field can contain only alphanumeric characters and underscore(_) and space.'),
            // The following rule is used by search().
            array('id, email, password, username, image, phone, user_type, date_created', 'safe', 'on' => 'search'),
            array('password, password_repeat', 'safe', 'on' => 'register'),
            array('email, password, password_repeat, user_type', 'required', 'on' => 'register'),
            array('password', 'compare', 'compareAttribute' => 'password_repeat', 'on' => 'register'),
                //array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'register'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userType' => array(self::BELONGS_TO, 'UserType', 'user_type'),
            'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'payRatePeriod' => array(self::BELONGS_TO, 'PayPeriod', 'pay_rate_period'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'email' => Yii::t('translate', 'Email'),
            'password' => Yii::t('translate', 'Password'),
            'username' => Yii::t('translate', 'Name'),
            'department_id' => Yii::t('translate', 'Department'),
            'company_id' => Yii::t('translate', 'Company'),
            'employee_id' => Yii::t('translate', 'Employee ID'),
            'pay_rate' => Yii::t('translate', 'Pay Rate'),
            'pay_rate_period' => Yii::t('translate', 'Pay Period'),
            'title' => Yii::t('translate', 'Title'),
            'checkinout_notification' => Yii::t('translate', 'Send eMail notification when employee checks-in or out.'),
            'checkinout_email' => Yii::t('translate', 'Email:'),
            'checkin_notification' => Yii::t('translate', 'Send Check-in Notification'),
            'checkout_notification' => Yii::t('translate', 'Send Check-out Notification'),
            'checkin_late_notification' => Yii::t('translate', 'Send eMail notification when employee checks-in late.'),
            'checkin_late_email' => Yii::t('translate', 'Email:'),
            'image' => Yii::t('translate', 'Image'),
            'first_name' => Yii::t('translate', 'First Name'),
            'last_name' => Yii::t('translate', 'Last Name'),
            'user_type' => Yii::t('translate', 'Account Type'),
            'password_repeat' => Yii::t('translate', 'Repeat password'),
            'date_created' => Yii::t('translate', 'Date Created'),
            'active' => Yii::t('translate', 'Login to The TimeSnob Site'),
            'overtime' => Yii::t('translate', 'Allow Overtime?'),
            'overtime_period' => Yii::t('translate', 'Overtime Period'),
            'holiday_pay' => Yii::t('translate', 'Allow Holiday Pay?'),
            'holiday_pay_period' => Yii::t('translate', 'Holiday Pay Period'),
            'sick_leave' => Yii::t('translate', 'Allow Paid Sick Leave?'),
            'sick_leave_period' => Yii::t('translate', 'Sick Leave Period'),
            'paid_timeoff' => Yii::t('translate', 'Allow Paid Time Off?'),
            'paid_timeoff_period' => Yii::t('translate', 'Paid Time Off Period'),
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
        if ($this->date_created) {
            $criteria->addBetweenCondition('date_created', "1969-01-01 00:00:00", $this->date_created);
        }
        if (Yii::app()->user->hasState('company'))
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        else
            $criteria->compare('company_id', $this->company_id);
        $criteria->compare('employee_id', $this->employee_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('hire_date', $this->hire_date, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('user_type', $this->user_type);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('pay_rate', $this->pay_rate, true);
        $criteria->compare('pay_rate_period', $this->pay_rate_period);
        $criteria->compare('checkinout_notification', $this->checkinout_notification);
        $criteria->compare('checkinout_email', $this->checkinout_email, true);
        $criteria->compare('checkin_notification', $this->checkin_notification);
        $criteria->compare('checkout_notification', $this->checkout_notification);
        $criteria->compare('checkin_late_notification', $this->checkin_late_notification);
        $criteria->compare('checkin_late_email', $this->checkin_late_email, true);
        $criteria->compare('holiday_pay', $this->holiday_pay);
        $criteria->compare('holiday_pay_period', $this->holiday_pay_period);
        $criteria->compare('overtime', $this->overtime);
        $criteria->compare('overtime_period', $this->overtime_period);
        $criteria->compare('sick_leave', $this->sick_leave);
        $criteria->compare('sick_leave_period', $this->sick_leave_period);
        $criteria->compare('paid_timeoff', $this->paid_timeoff);
        $criteria->compare('paid_timeoff_period', $this->paid_timeoff_period);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterSave() {
        $payrate = UserPayRateHistory::model()->find(array('condition' => 'user_id=' . $this->id, 'order' => 'id desc'));
        if ($payrate && $payrate->pay_rate == $this->pay_rate && $payrate->pay_rate_period == $this->pay_rate_period) {
            //do nothing
        } elseif (!$this->pay_rate || $this->pay_rate == '' || $this->pay_rate == 0) {
            
        } else {
            $payrate = new UserPayRateHistory;
            $payrate->pay_rate_period = $this->pay_rate_period;
            $payrate->user_id = $this->id;
            $payrate->pay_rate = $this->pay_rate;
            $payrate->save();
        }
        return true;
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            if ($this->password) {
                $this->password = $this->hash($this->password); //password_hash($this->password, PASSWORD_BCRYPT); //$this->hash($this->password);
            }
            if ($this->image == '') {
                $this->image = 'no-img.jpg';
            }
            if ($this->url == '') {
                $this->url = Helper::slugify($this->username . rand(1, 999));
            }
            if ($this->department_id) {
                $this->company_id = $this->department->company_id;
            }
            $this->username = $this->first_name . ' ' . $this->last_name;
            $this->hire_date = date('Y-m-d', strtotime($this->hire_date));

            return true;
        }
        return false;
    }

    protected function afterFind() {
        if ($this->password) {
            $this->password = $this->simple_decrypt($this->password); //password_hash($this->password, PASSWORD_BCRYPT); //$this->hash($this->password);
        }
        $this->hire_date = date('m/d/Y', strtotime($this->hire_date));
        return true;
    }

    // Authentication methods
    public function hash($value) {
        return $this->simple_encrypt($value);
    }

    public function simple_encrypt($text, $salt = "!@#$%^&*1a2s3d4f") {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    public function simple_decrypt($text, $salt = "!@#$%^&*1a2s3d4f") {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    public function check($value) {
        //$new_hash = $this->simple_encrypt($value);
        if ($value == $this->password) {
            return true;
        }
        return false;
    }

    public static function NotSet($val, $id, $div_id) {
        return '<a href="' . Yii::app()->request->getBaseUrl(true) . '/user/update/' . $id . '?frame=1&field=User_' . $val . '&div=' . $div_id . '-div" class="red-color s_frame">Not Set</a>';
    }

}
