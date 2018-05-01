<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
        'type'=>'horizontal',
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'employee_id',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'hire_date',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'image',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'user_type',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'date_created',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'url',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'active',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'company_id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'department_id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'pay_rate',array('class'=>'span9','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'pay_rate_period',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'checkinout_notification',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'checkinout_email',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'checkin_notification',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'checkout_notification',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'checkin_late_notification',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'checkin_late_email',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'holiday_pay',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'holiday_pay_period',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'overtime',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'overtime_period',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'sick_leave',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'sick_leave_period',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'paid_timeoff',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'paid_timeoff_period',array('class'=>'span9')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
