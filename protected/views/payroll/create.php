<?php
$this->breadcrumbs=array(
	'Payrolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List Payroll'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create Payroll');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>