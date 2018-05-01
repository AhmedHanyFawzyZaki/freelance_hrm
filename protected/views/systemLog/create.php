<?php
$this->breadcrumbs=array(
	'System Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List SystemLog'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create SystemLog');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>