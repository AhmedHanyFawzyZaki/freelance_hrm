<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'paid-holiday-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span9', 'maxlength' => 255)); ?>

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

<div class="control-group">
    <?php echo $form->labelEx($model, 'day', array('class' => 'control-label')) ?>
    <?php
    $this->widget('Select2', array(
        'model' => $model,
        'attribute' => 'day',
        'data' => array('01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07',
            '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12', '13' => '13', '14' => '14', '15' => '15',
            '16' => '16', '17' => '17', '18' => '18', '19' => '19', '20' => '20', '21' => '21', '22' => '22', '23' => '23',
            '24' => '24', '25' => '25', '26' => '26', '27' => '27', '28' => '28', '29' => '29', '30' => '30', '31' => '31'),
        'htmlOptions' => array('class' => "span7", "empty" => ""),
    ));
    ?>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'month', array('class' => 'control-label')) ?>
    <?php
    $this->widget('Select2', array(
        'model' => $model,
        'attribute' => 'month',
        'data' => array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
            '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'),
        'htmlOptions' => array('class' => "span7", "empty" => ""),
    ));
    ?>
</div>

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
