<?php
$this->breadcrumbs=array(
	'User Pay Rate Histories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List UserPayRateHistory'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create UserPayRateHistory');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>