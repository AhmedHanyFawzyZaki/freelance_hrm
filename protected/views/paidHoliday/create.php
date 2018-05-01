<?php
$this->breadcrumbs=array(
	'Paid Holidays'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List PaidHoliday'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create PaidHoliday');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>