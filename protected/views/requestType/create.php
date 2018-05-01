<?php
$this->breadcrumbs=array(
	'Request Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List RequestType'),'url'=>array('index')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'Create RequestType');?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>