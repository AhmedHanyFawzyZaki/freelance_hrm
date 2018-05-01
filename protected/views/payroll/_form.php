<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'payroll-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'time_from', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'time_from', //attribute name
            'language' => '',
            'mode' => 'date', //use "time","date" or "datetime" (default)
            'options' => array(
                "dateFormat" => Yii::app()->params['dateFormatJS'],
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'showOtherMonths' => true, // Show Other month in jquery
                'showButtonPanel' => true,
                'showOn' => 'both',
                'buttonText' => '<i class="icon-calendar" style="display: table; padding: 5.6px 0;"></i>',
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span8',
                'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
            ),
        ));
        ?>
    </div>
</div>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'time_to', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'time_to', //attribute name
            'language' => '',
            'mode' => 'date', //use "time","date" or "datetime" (default)
            'options' => array(
                "dateFormat" => Yii::app()->params['dateFormatJS'],
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'showOtherMonths' => true, // Show Other month in jquery
                'showButtonPanel' => true,
                'showOn' => 'both',
                'buttonText' => '<i class="icon-calendar" style="display: table; padding: 5.6px 0;"></i>'
            ), // jquery plugin options
            'htmlOptions' => array(
                'class' => 'span8',
                'style' => 'border-radius: 5px 0 0 5px;border-right: 0 none;',
            ),
        ));
        ?>
    </div>
</div>

<?php echo $form->radioButtonListRow($model, 'status', array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')); ?>

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
