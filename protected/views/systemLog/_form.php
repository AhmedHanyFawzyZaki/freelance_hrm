<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'system-log-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<!--<p class="help-block">Fields with <span class="required">*</span> are required.</p>-->

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'date_created',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'company_id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'employee_id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'type',array('class'=>'span9')); ?>

	<?php echo $form->textAreaRow($model,'comment',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions clear">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
