<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'activity-log-form',
    'enableAjaxValidation' => false,
    'type' => strtolower(Yii::app()->controller->id) == 'dashboard' ? 'vertical' : 'horizontal',
        ));
?>
<?php if (strtolower(Yii::app()->controller->id) == 'dashboard') { ?>
    <style>
        .control-group{
            width: 100%;
            margin-bottom: 20px !important;
        }
        input{
            margin-bottom: 0px !important;
        }
        .select2-container{
            margin-left: 0px !important;
        }
        .control-group .span7, .control-group .span9, textarea{
            width:95% !important;
        }
        .control-group .span8{
            width: 85% !important;
        }
    </style>
<?php } ?>
<!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<?php
if ($model->isNewRecord && Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    $model->user_id = Yii::app()->user->id;
    echo $form->hiddenField($model, 'user_id');
} elseif (!$model->isNewRecord && Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    //do nothing keep the user id the same
} else {
    ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'user_id', array('class' => 'control-label')) ?>
        <?php
        $this->widget('Select2', array(
            'model' => $model,
            'attribute' => 'user_id',
            'data' => Helper::ListEmployee(),
            'htmlOptions' => array('class' => "span7", 'empty' => ' '),
        ));
        ?>
    </div>

    <?php
}
?>

<?php
$cl = 'hide';
if ($model->isNewRecord && Yii::app()->user->getState('usertype') == Yii::app()->params['Normal']) {
    $cl = 'hide';
}
?>
<div class="<?= $cl ?> control-group">
    <?php echo $form->radioButtonListRow($model, 'status', array('0' => 'Pending', '1' => 'Approved', '2' => 'Declined')); ?>
</div>

<div class="control-group ">
    <?php echo $form->labelEx($model, 'time_in', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'time_in', //attribute name
            'language' => '',
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
            'options' => array(
                "dateFormat" => Yii::app()->params['dateFormatJS'],
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'showOtherMonths' => true, // Show Other month in jquery
                'showButtonPanel' => true,
                'showOn' => 'both',
                'buttonText' => '<i class="icon-calendar" style="display: table; padding: 5.6px 0;"></i>',
                'onClose'=> 'js:function(){                  
                    $("#ActivityLog_time_out").val("");
                    $("#ActivityLog_time_out").datepicker("option","minDate",
                    $("#ActivityLog_time_in").datepicker("getDate"));
                }',
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
    <?php echo $form->labelEx($model, 'time_out', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model, //Model object
            'attribute' => 'time_out', //attribute name
            'language' => '',
            'mode' => 'datetime', //use "time","date" or "datetime" (default)
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

<?php echo $form->textAreaRow($model, 'comments', array('class' => 'span9')); ?>

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