<?php

/**
 * This is the model class for table "{{system_log}}".
 *
 * The followings are the available columns in table '{{system_log}}':
 * @property integer $id
 * @property string $date_created
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $employee_id
 * @property integer $type
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Company $company
 * @property User $employee
 */
class SystemLog extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SystemLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{system_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, company_id, employee_id, type', 'numerical', 'integerOnly' => true),
            array('date_created, comment', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date_created, user_id, company_id, employee_id, type, comment', 'safe', 'on' => 'search'),
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
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'employee' => array(self::BELONGS_TO, 'User', 'employee_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'date_created' => Yii::t('translate', 'Date Created'),
            'user_id' => Yii::t('translate', 'User'),
            'company_id' => Yii::t('translate', 'Company'),
            'employee_id' => Yii::t('translate', 'Employee'),
            'type' => Yii::t('translate', 'Type'),
            'comment' => Yii::t('translate', 'Comment'),
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

        $criteria->condition = 'comment is not null and comment !=""';
        $criteria->compare('id', $this->id);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('comment', $this->comment, true);
        if(Yii::app()->user->hasState('company')){
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        }
        $criteria->order = 'id desc';
        $criteria->limit = 20;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
