<?php
$this->breadcrumbs=array(
	'Timeoffs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List Timeoff'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create Timeoff');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>