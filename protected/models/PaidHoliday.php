<?php

/**
 * This is the model class for table "{{paid_holiday}}".
 *
 * The followings are the available columns in table '{{paid_holiday}}':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $day
 * @property integer $month
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class PaidHoliday extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaidHoliday the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{paid_holiday}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, company_id, day, month', 'required'),
            array('company_id', 'numerical', 'integerOnly' => true),
            array('name, day_month,day, month', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, company_id, day, month', 'safe', 'on' => 'search'),
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
            'company_id' => Yii::t('translate', 'Company'),
            'day' => Yii::t('translate', 'Day'),
            'month' => Yii::t('translate', 'Month'),
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
        $criteria->compare('company_id', $this->company_id);
        if (Yii::app()->user->hasState('company')) {
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        }
        $criteria->compare('day', $this->day);
        $criteria->compare('month', $this->month);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if (parent::beforeSave()) {
            $this->day_month = $this->day . '-' . $this->month;
        }
        return true;
    }

}
