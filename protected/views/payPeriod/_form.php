<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'pay-period-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'name', array('class' => 'span9', 'maxlength' => 255)); ?>

<?php echo $form->textFieldRow($model, 'period_in_days', array('class' => 'span9', 'append' => 'equivalent days')); ?>

<?php echo $form->textFieldRow($model, 'period', array('class' => 'span9', 'append' => 'equivalent hours')); ?>

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
