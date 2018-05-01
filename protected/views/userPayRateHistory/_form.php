<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-pay-rate-history-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'pay_rate',array('class'=>'span9','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'pay_rate_period',array('class'=>'span9')); ?>

	<div class="form-actions clear">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
