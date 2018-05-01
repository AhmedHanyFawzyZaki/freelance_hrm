<?php
$this->breadcrumbs=array(
	'Activity Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List Time Entries'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create Time Entry');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>