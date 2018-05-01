<?php

/**
 * This is the model class for table "{{department}}".
 *
 * The followings are the available columns in table '{{department}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $in_time
 * @property string $out_time
 * @property integer $company_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property User[] $users
 */
class Department extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Department the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{department}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('company_id, name, in_time, out_time, code', 'required'),
            array('company_id', 'numerical', 'integerOnly' => true),
            array('name, code', 'length', 'max' => 255),
            array('in_time, out_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, code, in_time, out_time, company_id', 'safe', 'on' => 'search'),
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
            'users' => array(self::HAS_MANY, 'User', 'department_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('translate', 'ID'),
            'name' => Yii::t('translate', 'Name'),
            'code' => Yii::t('translate', 'Code'),
            'in_time' => Yii::t('translate', 'In Time'),
            'out_time' => Yii::t('translate', 'Out Time'),
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

        $criteria->condition = 'id!=1';
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('in_time', $this->in_time, true);
        $criteria->compare('out_time', $this->out_time, true);
        
        if(Yii::app()->user->hasState('company'))
            $criteria->compare('company_id', Yii::app()->user->getState('company'));
        else
            $criteria->compare('company_id', $this->company_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
