<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
        'type'=>'horizontal',
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'code',array('class'=>'span9','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'in_time',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'out_time',array('class'=>'span9')); ?>

	<?php echo $form->textFieldRow($model,'company_id',array('class'=>'span9')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
