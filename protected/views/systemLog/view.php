<?php
$this->breadcrumbs=array(
	'System Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('translate', 'List SystemLog'),'url'=>array('index')),
	array('label'=>Yii::t('translate', 'Create SystemLog'),'url'=>array('create')),
	array('label'=>Yii::t('translate', 'Update SystemLog'),'url'=>array('update','id'=>$model->id)),
	array('label'=>Yii::t('translate', 'Delete SystemLog'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php $this->pageTitlecrumbs = Yii::t('translate', 'View SystemLog'). ' "'.$model->id.'"'; ?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'date_created',
		'user_id',
		'company_id',
		'employee_id',
		'type',
		'comment',
	),
)); ?>
