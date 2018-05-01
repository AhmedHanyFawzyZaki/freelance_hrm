<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
        'type'=>'horizontal',
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'time_from',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'time_to',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'date_created',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span9')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
