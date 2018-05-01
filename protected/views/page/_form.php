<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'page-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
        ));
?>

        <!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model, 'title', array('class' => 'span9', 'maxlength' => 255)); ?>

<div class="clear"><br></div>

<div class="control-group span11">
    <?php
    echo $form->labelEx($model, 'details', array('class' => 'control-label'));
    echo '<div class="controls">';
    $this->widget('application.extensions.eckeditor.ECKEditor', array(
        'model' => $model,
        'attribute' => 'details',
    ));
    echo '</div>';
    ?>
</div>

<?php //echo $form->textFieldRow($model, 'slug', array('class' => 'span9', 'maxlength' => 255)); ?>

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
