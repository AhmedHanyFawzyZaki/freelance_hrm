<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'department-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'code', array('class' => 'span9', 'maxlength' => 255)); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span9', 'maxlength' => 255)); ?>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'in_time', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'in_time', //attribute name
            'language' => '',
            'mode' => 'time', //use "time","date" or "datetime" (default)
            /* 'options' => array(
              "dateFormat" => Yii::app()->params['dateFormat'],
              'changeMonth' => 'true',
              'changeYear' => 'true',
              'showOtherMonths' => true, // Show Other month in jquery
              'yearRange' => "-100:+5",
              ), */// jquery plugin options
            'htmlOptions' => array(
                'class' => 'span9',
            ),
        ));
        ?>
    </div>
</div>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'out_time', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'out_time', //attribute name
            'language' => '',
            'mode' => 'time', //use "time","date" or "datetime" (default)
            /* 'options' => array(
              "dateFormat" => Yii::app()->params['dateFormat'],
              'changeMonth' => 'true',
              'changeYear' => 'true',
              'showOtherMonths' => true, // Show Other month in jquery
              'yearRange' => "-100:+5",
              ), */// jquery plugin options
            'htmlOptions' => array(
                'class' => 'span9',
            ),
        ));
        ?>
    </div>
</div>

<?php
if (Yii::app()->user->usertype == Yii::app()->params['Admin']) {
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'company_id', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'company_id',
            'data' => Helper::ListCompany(),
            'htmlOptions' => array('class' => "span7", "empty" => ""),
        ));
        ?>
    </div>
    <?php
} else {
    echo $form->hiddenField($model, 'company_id', array('value' => Yii::app()->user->getState('company')));
}
?>

<div class="form-actions clear">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Create' : 'Save',
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
