<?php

/**
 * This is the model class for table "{{request_type}}".
 *
 * The followings are the available columns in table '{{request_type}}':
 * @property integer $id
 * @property string $name
 * @property integer $paid
 * @property integer $company_id
 */
class RequestType extends CActiveRecord {

    public $paid_title;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RequestType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{request_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, company_id', 'required'),
            array('paid, company_id, vacation_sick_leave', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, paid, company_id, vacation_sick_leave', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
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
            'paid' => Yii::t('translate', 'Paid'),
            'company_id' => Yii::t('translate', 'Company'),
            'vacation_sick_leave' => Yii::t('translate', 'Deduction'),
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
        $criteria->compare('paid', $this->paid);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('vacation_sick_leave', $this->vacation_sick_leave);
        if (Yii::app()->user->hasState('company')) {
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    protected function afterFind() {
        $this->paid_title = $this->paid ? 'Paid' : 'Unpaid';
    }

}
