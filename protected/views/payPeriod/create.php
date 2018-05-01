<?php
$this->breadcrumbs=array(
	'Pay Periods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List PayPeriod'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create PayPeriod');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>